<?php

namespace App\Http\Controllers;

use App\Mail\OrderCreatedMail;
use App\Mail\OrderPaidMail;
use App\Models\Course;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderLicense;
use App\Models\PaymentSetting;
use App\Models\Product;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // =========================================================================
    // CHECKOUT VIA CART (khusus Produk)
    // =========================================================================

    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('user.cart.index')->with('error', 'Keranjang kamu kosong!');
        }

        $promoCode = session()->get('promo_code');
        $subtotal  = collect($cart)->sum('price');
        $discount  = 0;

        if ($promoCode) {
            $promo = PromoCode::find($promoCode['id']);
            if ($promo) {
                $discount = $promo->calculateCartDiscount($cart);
            }
        }

        $total          = max(0, $subtotal - $discount);
        $paymentSetting = PaymentSetting::first();

        return view('pages.checkout.index', compact(
            'cart',
            'promoCode',
            'subtotal',
            'discount',
            'total',
            'paymentSetting'
        ));
    }

    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:manual_transfer,midtrans',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('user.cart.index')->with('error', 'Keranjang kamu kosong!');
        }

        $promoCode   = session()->get('promo_code');
        $subtotal    = collect($cart)->sum('price');
        $discount    = 0;
        $promoCodeId = null;

        if ($promoCode) {
            $promo = PromoCode::find($promoCode['id']);
            if ($promo) {
                $discount    = $promo->calculateCartDiscount($cart);
                $promoCodeId = $promo->id;
            }
        }

        $total = max(0, $subtotal - $discount);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id'        => Auth::id(),
                'invoice_number' => 'INV-' . strtoupper(Str::random(10)),
                'promo_code_id'  => $promoCodeId,
                'subtotal'       => $subtotal,
                'discount'       => $discount,
                'total'          => $total,
                'payment_method' => $request->payment_method,
                'status'         => 'pending',
            ]);

            foreach ($cart as $item) {
                $itemable = $item['type'] === 'course'
                    ? Course::find($item['id'])
                    : Product::find($item['id']);

                $orderItem = OrderItem::create([
                    'order_id'      => $order->id,
                    'itemable_type' => get_class($itemable),
                    'itemable_id'   => $itemable->id,
                    'item_name'     => $item['name'],
                    'price'         => $item['price'],
                ]);

                // Simpan data lisensi jika produk lisensi
                if ($item['type'] === 'product' && $itemable->type === 'license') {
                    $urlKey      = 'license_' . $item['id'] . '_url';
                    $usernameKey = 'license_' . $item['id'] . '_username';
                    $passwordKey = 'license_' . $item['id'] . '_password';

                    if ($request->filled($urlKey)) {
                        OrderLicense::create([
                            'order_item_id' => $orderItem->id,
                            'wp_admin_url'  => $request->input($urlKey),
                            'username'      => $request->input($usernameKey),
                            'password'      => $request->input($passwordKey),
                        ]);
                    }
                }
            }

            if ($promoCodeId) {
                PromoCode::find($promoCodeId)->increment('used_count');
            }

            DB::commit();
            session()->forget(['cart', 'promo_code']);

            return $this->finalizeOrder($order, $request->payment_method);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // CHECKOUT LANGSUNG (khusus Kelas / Course)
    // =========================================================================

    /**
     * Halaman checkout langsung untuk satu kelas.
     * Route: GET /user/checkout/course/{course}
     */
    public function courseCheckout(Course $course)
    {
        // Cek sudah punya kelas ini
        $hasPurchased = Auth::user()->orders()
            ->where('status', 'paid')
            ->whereHas(
                'items',
                fn($q) => $q
                    ->where('itemable_type', Course::class)
                    ->where('itemable_id', $course->id)
            )->exists();

        if ($hasPurchased) {
            return redirect()->route('courses.learn', $course->slug)
                ->with('error', 'Kamu sudah memiliki kelas ini!');
        }

        $paymentSetting = PaymentSetting::first();
        $promoCode      = null;
        $discount       = 0;
        $total          = $course->price;

        return view('pages.checkout.course', compact(
            'course',
            'paymentSetting',
            'promoCode',
            'discount',
            'total'
        ));
    }

    /**
     * Apply promo di halaman checkout kelas (AJAX-friendly via Livewire atau form biasa).
     * Route: POST /user/checkout/course/{course}/promo
     */
    public function applyCoursePromo(Request $request, Course $course)
    {
        $request->validate(['promo_code' => 'required|string']);
        
        $promo = PromoCode::where('code', strtoupper($request->promo_code))->first();

        if (!$promo || !$promo->isValid()) {
            return back()->withErrors(['promo_code' => 'Kode promo tidak ditemukan atau sudah tidak berlaku!']);
        }

        if (!$promo->isApplicableTo($course)) {
            return back()->withErrors(['promo_code' => 'Kode promo tidak berlaku untuk kelas ini!']);
        }

        if ($course->price < $promo->minimum_purchase) {
            return back()->withErrors(['promo_code' => 'Minimum pembelian Rp ' . number_format($promo->minimum_purchase, 0, ',', '.') . ' tidak terpenuhi!']);
        }

        // Simpan promo ke session khusus course checkout (terpisah dari cart)
        session()->put('course_promo_' . $course->id, [
            'id'    => $promo->id,
            'code'  => $promo->code,
            'type'  => $promo->type,
            'value' => $promo->value,
            'scope' => $promo->scope,
        ]);

        return back()->with('success', 'Kode promo berhasil digunakan!');
    }

    /**
     * Hapus promo di checkout kelas.
     * Route: DELETE /user/checkout/course/{course}/promo
     */
    public function removeCoursePromo(Course $course)
    {
        session()->forget('course_promo_' . $course->id);
        return back()->with('success', 'Kode promo dihapus!');
    }

    /**
     * Proses pembayaran checkout kelas langsung.
     * Route: POST /user/checkout/course/{course}
     */
    public function processCourse(Request $request, Course $course)
    {
        $request->validate([
            'payment_method' => 'required|in:manual_transfer,midtrans',
        ]);

        // Double-check sudah punya
        $hasPurchased = Auth::user()->orders()
            ->where('status', 'paid')
            ->whereHas(
                'items',
                fn($q) => $q
                    ->where('itemable_type', Course::class)
                    ->where('itemable_id', $course->id)
            )->exists();

        if ($hasPurchased) {
            return redirect()->route('courses.learn', $course->slug)
                ->with('error', 'Kamu sudah memiliki kelas ini!');
        }

        $sessionPromo = session()->get('course_promo_' . $course->id);
        $subtotal     = $course->price;
        $discount     = 0;
        $promoCodeId  = null;

        if ($sessionPromo) {
            $promo = PromoCode::find($sessionPromo['id']);
            if ($promo && $promo->isValid() && $promo->isApplicableTo($course)) {
                $discount    = $promo->calculateDiscount($course->price);
                $promoCodeId = $promo->id;
            }
        }

        $total = max(0, $subtotal - $discount);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id'        => Auth::id(),
                'invoice_number' => 'INV-' . strtoupper(Str::random(10)),
                'promo_code_id'  => $promoCodeId,
                'subtotal'       => $subtotal,
                'discount'       => $discount,
                'total'          => $total,
                'payment_method' => $request->payment_method,
                'status'         => 'pending',
            ]);

            OrderItem::create([
                'order_id'      => $order->id,
                'itemable_type' => Course::class,
                'itemable_id'   => $course->id,
                'item_name'     => $course->title,
                'price'         => $course->price,
            ]);

            if ($promoCodeId) {
                PromoCode::find($promoCodeId)->increment('used_count');
            }

            DB::commit();
            session()->forget('course_promo_' . $course->id);

            return $this->finalizeOrder($order, $request->payment_method);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // SHARED
    // =========================================================================

    public function success($invoice)
    {
        $order = Order::where('invoice_number', $invoice)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('pages.checkout.success', compact('order'));
    }

    /**
     * Finalisasi order: handle gratis, kirim email, redirect.
     */
    private function finalizeOrder(Order $order, string $paymentMethod): \Illuminate\Http\RedirectResponse
    {
        // Jika total 0 (promo 100%), langsung paid
        if ($order->total == 0) {
            $order->update(['status' => 'paid', 'paid_at' => now()]);
            Mail::to(Auth::user()->email)->send(new OrderPaidMail($order));

            return redirect()->route('user.checkout.success', $order->invoice_number)
                ->with('success', 'Pesanan berhasil! Kamu sudah bisa mengakses konten.');
        }

        Mail::to(Auth::user()->email)->send(new OrderCreatedMail($order));

        if ($paymentMethod === 'midtrans') {
            return $this->processMidtrans($order);
        }

        return redirect()->route('user.checkout.success', $order->invoice_number);
    }

    private function processMidtrans(Order $order): \Illuminate\Http\RedirectResponse
    {
        $paymentSetting = PaymentSetting::first();

        \Midtrans\Config::$serverKey    = $paymentSetting->midtrans_server_key;
        \Midtrans\Config::$isProduction = $paymentSetting->midtrans_production;
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;

        $params = [
            'transaction_details' => [
                'order_id'     => $order->invoice_number,
                'gross_amount' => (int) $order->total,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email'      => Auth::user()->email,
                'phone'      => Auth::user()->phone ?? '',
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $order->update(['midtrans_token' => $snapToken]);

        return redirect()->route('user.checkout.success', $order->invoice_number);
    }
}
