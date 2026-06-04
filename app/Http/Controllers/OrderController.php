<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductFile;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('user.orders.index', compact('orders'));
    }

    public function show($invoice)
    {
        $order = Order::where('invoice_number', $invoice)
            ->where('user_id', Auth::id())
            ->with([
                'items' => function ($query) {
                    $query->with([
                        'license',
                    ]);
                },
            ])
            ->firstOrFail();

        // Load itemable dengan withTrashed agar soft deleted tetap muncul
        $order->items->each(function ($item) {
            $modelClass = $item->itemable_type;
            if (class_exists($modelClass) && method_exists($modelClass, 'withTrashed')) {
                $item->setRelation(
                    'itemable',
                    $modelClass::withTrashed()
                        ->with(class_basename($modelClass) === 'Course' ? ['sections.chapters'] : [])
                        ->find($item->itemable_id)
                );
            }
        });

        return view('user.orders.show', compact('order'));
    }

    public function confirmPayment($invoice)
    {
        $order = Order::where('invoice_number', $invoice)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        $paymentSetting = PaymentSetting::first();

        return view('user.payment.confirm', compact('order', 'paymentSetting'));
    }

    public function submitConfirmation(Request $request, $invoice)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $order = Order::where('invoice_number', $invoice)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        // Kompres & simpan gambar
        $file = $request->file('payment_proof');
        $filename = 'payment_' . $invoice . '_' . time() . '.jpg';
        $savePath = storage_path('app/public/payment_proofs/' . $filename);

        // Buat folder jika belum ada
        if (!file_exists(storage_path('app/public/payment_proofs'))) {
            mkdir(storage_path('app/public/payment_proofs'), 0755, true);
        }

        // Kompres dengan Intervention Image
        \Intervention\Image\ImageManager::gd()
            ->read($file)
            ->scaleDown(width: 1200)
            ->toJpeg(quality: 70)
            ->save($savePath);

        $order->update([
            'payment_proof' => 'payment_proofs/' . $filename,
        ]);

        $paymentSetting = PaymentSetting::first();
        $waNumber = $paymentSetting->whatsapp_number;
        $message = urlencode(
            "Halo Admin Delix Studio, saya sudah melakukan pembayaran.\n" .
                "Invoice: {$order->invoice_number}\n" .
                "Total: Rp " . number_format($order->total, 0, ',', '.') . "\n" .
                "Mohon segera dikonfirmasi. Terima kasih!"
        );

        return redirect("https://wa.me/{$waNumber}?text={$message}");
    }

    public function midtransCallback(Request $request)
    {
        $paymentSetting = PaymentSetting::first();

        \Midtrans\Config::$serverKey = $paymentSetting->midtrans_server_key;
        \Midtrans\Config::$isProduction = $paymentSetting->midtrans_production;

        $notification = new \Midtrans\Notification();
        $transactionStatus = $notification->transaction_status;
        $orderId = $notification->order_id;

        $order = Order::where('invoice_number', $orderId)->firstOrFail();

        if ($transactionStatus === 'settlement' || $transactionStatus === 'capture') {
            $order->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $order->update(['status' => 'failed']);
        }

        return response()->json(['status' => 'ok']);
    }

    public function download($orderItemId)
    {
        $orderItem = OrderItem::where('id', $orderItemId)
            ->whereHas('order', function ($query) {
                $query->where('user_id', Auth::id())
                    ->where('status', 'paid');
            })->firstOrFail();

        $product = $orderItem->itemable;
        $file = $product->files()->firstOrFail();

        $disk = $file->disk ?? 'private'; // fallback ke private

        if (!Storage::disk($disk)->exists($file->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk($disk)->download(
            $file->file_path,
            $file->file_name ?? basename($file->file_path)
        );
    }
}
