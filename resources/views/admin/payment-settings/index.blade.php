@extends('layouts.admin')

@section('title', 'Pengaturan Pembayaran')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Pengaturan Pembayaran</h1>
            <p class="page-desc">Konfigurasi metode pembayaran</p>
        </div>
    </div>

    <form action="{{ route('admin.payment-settings.update') }}" method="POST">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

            {{-- Manual Transfer --}}
            <div class="card p-5 space-y-4">
                <x-form.toggle name="manual_transfer_active" label="Transfer Bank Manual" hint="Konfirmasi via WhatsApp"
                    :checked="$setting->manual_transfer_active" />
                <x-form.input name="bank_name" label="Nama Bank" :value="$setting->bank_name" placeholder="BCA" />
                <x-form.input name="bank_account_number" label="Nomor Rekening" :value="$setting->bank_account_number"
                    placeholder="1234567890" />
                <x-form.input name="bank_account_name" label="Atas Nama" :value="$setting->bank_account_name"
                    placeholder="Nama Pemilik Rekening" />
                <x-form.input name="whatsapp_number" label="Nomor WhatsApp Admin" :value="$setting->whatsapp_number"
                    placeholder="628123456789" hint="Format internasional tanpa +, contoh: 628123456789" />
            </div>

            {{-- Midtrans --}}
            <div class="card p-5 space-y-4">
                <x-form.toggle name="midtrans_active" label="Midtrans" hint="Payment gateway otomatis" :checked="$setting->midtrans_active" />
                <x-form.input name="midtrans_server_key" label="Server Key" :value="$setting->midtrans_server_key"
                    placeholder="SB-Mid-server-xxxx" />
                <x-form.input name="midtrans_client_key" label="Client Key" :value="$setting->midtrans_client_key"
                    placeholder="SB-Mid-client-xxxx" />

                {{-- Mode Production Toggle --}}
                <x-form.toggle name="midtrans_production" label="Mode Production" hint="Matikan untuk mode sandbox/testing"
                    :checked="$setting->midtrans_production" />
            </div>
        </div>

        <div class="mt-4 flex justify-end">
            <x-btn type="submit" size="lg">Simpan Pengaturan</x-btn>
        </div>
    </form>
@endsection
