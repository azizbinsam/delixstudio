<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderPaidMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderManagerController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items'])
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show($invoice)
    {
        $order = Order::where('invoice_number', $invoice)
            ->with(['user', 'items.itemable', 'items.license', 'promoCode'])
            ->firstOrFail();

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $invoice)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,failed,expired',
        ]);

        $order = Order::where('invoice_number', $invoice)->firstOrFail();

        $order->update([
            'status' => $request->status,
            'paid_at' => $request->status === 'paid' ? now() : $order->paid_at,
        ]);

        if ($request->status === 'paid') {
            Mail::to($order->user->email)->send(new OrderPaidMail($order));
        }

        return back()->with('success', 'Status order berhasil diperbarui!');
    }

    public function viewLicense($invoice)
    {
        $order = Order::where('invoice_number', $invoice)
            ->with(['items.license'])
            ->firstOrFail();

        return view('admin.orders.license', compact('order'));
    }
}
