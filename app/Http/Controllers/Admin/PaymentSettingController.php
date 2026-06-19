<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;

class PaymentSettingController extends Controller
{
    public function index()
    {
        $setting = PaymentSetting::first();
        return view('admin.payment-settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'midtrans_server_key' => 'nullable|string',
            'midtrans_client_key' => 'nullable|string',
            'bank_name' => 'nullable|string|max:100',
            'bank_account_number' => 'nullable|string|max:50',
            'bank_account_name' => 'nullable|string|max:100',
            'whatsapp_number' => 'nullable|string|max:20',
            'fersaku_api_key'        => 'nullable|string',
            'fersaku_webhook_secret' => 'nullable|string',
        ]);

        $setting = PaymentSetting::first();

        $setting->update([
            'midtrans_active' => $request->boolean('midtrans_active'),
            'midtrans_server_key' => $request->midtrans_server_key,
            'midtrans_client_key' => $request->midtrans_client_key,
            'midtrans_production' => $request->boolean('midtrans_production'),
            'manual_transfer_active' => $request->boolean('manual_transfer_active'),
            'bank_name' => $request->bank_name,
            'bank_account_number' => $request->bank_account_number,
            'bank_account_name' => $request->bank_account_name,
            'whatsapp_number' => $request->whatsapp_number,
            'fersaku_active'         => $request->boolean('fersaku_active'),
            'fersaku_api_key'        => $request->fersaku_api_key,
            'fersaku_webhook_secret' => $request->fersaku_webhook_secret,
            'fersaku_sandbox'        => $request->boolean('fersaku_sandbox'),
        ]);

        return back()->with('success', 'Pengaturan pembayaran berhasil diperbarui!');
    }
}
