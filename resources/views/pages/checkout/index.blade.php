@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <x-section-header label="Pembayran" title="Checkout" description="" />
    <div class="pb-20">
        <div class="max-w-6xl mx-auto px-6">

            <form action="{{ route('user.checkout.process') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- Left --}}
                    <div class="lg:col-span-2 space-y-6">

                        {{-- Order Items --}}
                        <div class="card">
                            <div class="card-header">
                                <p class="text-xs font-medium text-white/50">Item Pesanan</p>
                            </div>
                            <div class="divide-y divide-white/5">
                                @foreach ($cart as $item)
                                    <div class="px-5 py-3 flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 bg-white/5 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <i
                                                    class="fas fa-{{ $item['type'] === 'course' ? 'play-circle' : 'box' }} text-xs text-white/30"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-medium text-white">{{ $item['name'] }}</p>
                                                <p class="text-[11px] text-white/30 capitalize">
                                                    {{ $item['type'] === 'course' ? 'Kelas' : 'Produk' }}</p>
                                            </div>
                                        </div>
                                        <span class="text-xs font-medium text-white/70">
                                            Rp {{ number_format($item['price'], 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Form Lisensi --}}
                        @foreach ($cart as $key => $item)
                            @if ($item['type'] === 'product')
                                @php
                                    $product = \App\Models\Product::find($item['id']);
                                @endphp
                                @if ($product && $product->type === 'license')
                                    <div class="card">
                                        <div class="card-header">
                                            <p class="text-xs font-medium text-white/50">
                                                Data Lisensi —
                                                <span class="text-white/70">{{ $item['name'] }}</span>
                                            </p>
                                        </div>
                                        <div class="card-body space-y-4">
                                            <div class="alert-info text-xs">
                                                <i class="fas fa-info-circle mt-0.5"></i>
                                                <span>Isi data WP-Admin kamu untuk aktivasi lisensi produk ini.</span>
                                            </div>
                                            <div>
                                                <label class="label">URL WP-Admin</label>
                                                <input type="url" name="license_{{ $item['id'] }}_url"
                                                    placeholder="https://example.com/wp-admin" class="input" required>
                                            </div>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="label">Username</label>
                                                    <input type="text" name="license_{{ $item['id'] }}_username"
                                                        placeholder="admin" class="input" required>
                                                </div>
                                                <div>
                                                    <label class="label">Password</label>
                                                    <input type="text" name="license_{{ $item['id'] }}_password"
                                                        placeholder="password wordpress" class="input" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach

                        {{-- Metode Pembayaran --}}
                        <div class="card">
                            <div class="card-header">
                                <p class="text-xs font-medium text-white/50">Metode Pembayaran</p>
                            </div>
                            <div class="card-body space-y-3">

                                {{-- Manual Transfer --}}
                                @if ($paymentSetting->manual_transfer_active)
                                    <label
                                        class="flex items-start gap-3 p-3 border border-white/10 rounded-lg cursor-pointer hover:border-white/20 transition-colors has-[:checked]:border-white/40 has-[:checked]:bg-white/5">
                                        <input type="radio" name="payment_method" value="manual_transfer"
                                            class="mt-0.5 accent-white" checked>
                                        <div>
                                            <p class="text-sm font-medium text-white">Transfer Bank Manual</p>
                                            <p class="text-xs text-white/30 mt-0.5 leading-relaxed">
                                                Transfer ke rekening {{ $paymentSetting->bank_name }} a/n
                                                {{ $paymentSetting->bank_account_name }}.
                                                Konfirmasi via WhatsApp setelah transfer.
                                            </p>
                                        </div>
                                    </label>
                                @endif

                                {{-- Midtrans --}}
                                @if ($paymentSetting->midtrans_active)
                                    <label
                                        class="flex items-start gap-3 p-3 border border-white/10 rounded-lg cursor-pointer hover:border-white/20 transition-colors has-[:checked]:border-white/40 has-[:checked]:bg-white/5">
                                        <input type="radio" name="payment_method" value="midtrans"
                                            class="mt-0.5 accent-white">
                                        <div>
                                            <p class="text-sm font-medium text-white">Midtrans</p>
                                            <p class="text-xs text-white/30 mt-0.5">
                                                Bayar via transfer bank, e-wallet, atau QRIS.
                                            </p>
                                        </div>
                                    </label>
                                @endif

                                {{-- Fersaku --}}
                                @if ($paymentSetting->fersaku_active)
                                    <label
                                        class="flex items-start gap-3 p-3 border border-white/10 rounded-lg cursor-pointer hover:border-white/20 transition-colors has-[:checked]:border-white/40 has-[:checked]:bg-white/5">
                                        <input type="radio" name="payment_method" value="fersaku"
                                            {{ old('payment_method') === 'fersaku' ? 'checked' : '' }} />
                                        <span>QRIS via Fersaku</span>
                                        <span class="text-xs text-gray-400">Bayar dengan QRIS dari e-wallet manapun</span>
                                    </label>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Right: Summary --}}
                    <div class="lg:col-span-1">
                        <div class="card p-5 sticky top-24">
                            <p class="text-xs font-medium text-white/40 uppercase tracking-widest mb-4">Ringkasan</p>

                            <div class="space-y-2.5 mb-5">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-white/30">Subtotal</span>
                                    <span class="text-xs text-white/60">Rp
                                        {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                @if ($discount > 0)
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-white/30">Diskon</span>
                                        <span class="text-xs text-green-400">- Rp
                                            {{ number_format($discount, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                                <div class="border-t border-white/5 pt-2.5 flex items-center justify-between">
                                    <span class="text-sm font-medium text-white">Total</span>
                                    <span class="text-sm font-semibold text-white">Rp
                                        {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <button type="submit" class="w-full btn-primary btn btn-lg justify-center">
                                Bayar Sekarang
                            </button>

                            <p class="text-[11px] text-white/20 text-center mt-3 leading-relaxed">
                                Dengan melanjutkan, kamu menyetujui
                                <a href="{{ route('terms') }}" wire:navigate class="underline">syarat & ketentuan</a>
                                yang berlaku.
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
