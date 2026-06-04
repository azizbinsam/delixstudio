<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Product;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $promoCode = session()->get('promo_code');

        // Validasi ulang promo setiap kali cart dibuka
        if ($promoCode) {
            $promo = PromoCode::find($promoCode['id']);

            if (!$promo || !$promo->isValid() || !$promo->isApplicableToCart($cart)) {
                session()->forget('promo_code');
                $promoCode = null;
                session()->flash('error', 'Kode promo sudah tidak berlaku dan telah dihapus dari keranjang.');
            }
        }

        return view('pages.cart.index', compact('cart', 'promoCode'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'type' => 'required|in:course,product',
            'id'   => 'required|integer',
        ]);

        // Kelas langsung ke checkout, tidak lewat cart
        if ($request->type === 'course') {
            return redirect()->route('user.checkout.course', $request->id);
        }

        $cart = session()->get('cart', []);
        $key  = 'product_' . $request->id;

        if (isset($cart[$key])) {
            return back()->with('error', 'Item sudah ada di keranjang!');
        }

        $item = Product::findOrFail($request->id);

        // Produk lisensi boleh beli berkali-kali, skip cek
        $skipPurchaseCheck = $item->type === 'license';

        if (!$skipPurchaseCheck) {
            $hasPurchased = Auth::user()->orders()
                ->where('status', 'paid')
                ->whereHas(
                    'items',
                    fn($q) => $q
                        ->where('itemable_type', Product::class)
                        ->where('itemable_id', $item->id)
                )->exists();

            if ($hasPurchased) {
                return back()->with('error', 'Kamu sudah memiliki produk ini!');
            }
        }

        $cart[$key] = [
            'type'      => 'product',
            'id'        => $item->id,
            'name'      => $item->title,
            'price'     => $item->price,
            'thumbnail' => $item->thumbnail,
        ];

        session()->put('cart', $cart);

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        return back()->with('success', 'Item berhasil dihapus dari keranjang!');
    }

    public function applyPromo(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $cart     = session()->get('cart', []);
        $subtotal = collect($cart)->sum('price');

        $promo = PromoCode::where('code', strtoupper($request->code))->first();

        // Validasi dasar
        if (!$promo || !$promo->isValid()) {
            return back()->withErrors(['code' => 'Kode promo tidak ditemukan atau sudah tidak berlaku!']);
        }

        // Validasi scope — apakah promo berlaku untuk item di cart?
        if (!$promo->isApplicableToCart($cart)) {
            return back()->withErrors(['code' => 'Kode promo tidak berlaku untuk item di keranjangmu!']);
        }

        // Validasi minimum purchase
        if ($subtotal < $promo->minimum_purchase) {
            return back()->withErrors(['code' => 'Minimum pembelian Rp ' . number_format($promo->minimum_purchase, 0, ',', '.') . ' tidak terpenuhi!']);
        }

        session()->put('promo_code', [
            'id'    => $promo->id,
            'code'  => $promo->code,
            'type'  => $promo->type,
            'value' => $promo->value,
            'scope' => $promo->scope,
        ]);

        return back()->with('success', 'Kode promo berhasil digunakan!');
    }

    public function removePromo()
    {
        session()->forget('promo_code');
        return back()->with('success', 'Kode promo dihapus!');
    }
}
