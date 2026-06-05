@extends('layouts.app')

@section('title', 'Pesanan Berhasil')

@section('content')
    <div class="pt-10 pb-20">
        <div class="max-w-lg mx-auto px-6 text-center">

            {{-- Icon --}}
            <div
                class="w-14 h-14 bg-white/5 border border-white/10 rounded-full flex items-center justify-center mx-auto mb-6">
                @if ($order->status === 'paid')
                    <i class="fas fa-check text-white/60"></i>
                @elseif($order->payment_method === 'midtrans')
                    <i class="fas fa-clock text-white/60"></i>
                @else
                    <i class="fas fa-clock text-white/60"></i>
                @endif
            </div>

            <h1 class="text-xl font-semibold text-white mb-2">
                @if ($order->status === 'paid')
                    Pesanan Aktif! 🎉
                @elseif($order->payment_method === 'midtrans')
                    Pesanan Dibuat
                @else
                    Pesanan Dibuat
                @endif
            </h1>

            <p class="text-xs text-white/30 leading-relaxed mb-8">
                @if ($order->status === 'paid')
                    Pesanan kamu sudah aktif. Kamu bisa langsung mengakses semua konten yang sudah dibeli.
                @elseif($order->payment_method === 'midtrans')
                    Pembayaran kamu sedang diproses. Akses konten akan aktif setelah pembayaran dikonfirmasi.
                @else
                    Selesaikan pembayaran transfer bank dan konfirmasi via WhatsApp untuk mengaktifkan pesananmu.
                @endif
            </p>

            {{-- Invoice Card --}}
            <div class="card p-5 text-left mb-6">
                <div class="flex items-center justify-between mb-4 pb-4 border-b border-white/5">
                    <span class="text-xs text-white/30">Invoice</span>
                    <span class="text-xs font-mono text-white/60">{{ $order->invoice_number }}</span>
                </div>
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-white/30">Status</span>
                        <x-badge
                            variant="{{ match ($order->status) {
                                'paid' => 'success',
                                'pending' => 'warning',
                                'failed', 'expired' => 'destructive',
                                default => 'secondary',
                            } }}">
                            {{ ucfirst($order->status) }}
                        </x-badge>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-white/30">Metode</span>
                        <span
                            class="text-xs text-white/60 capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-white/30">Total</span>
                        <span class="text-sm font-semibold text-white">Rp
                            {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col gap-2">
                @if ($order->status === 'pending' && $order->payment_method === 'manual_transfer')
                    <a href="{{ route('user.payment.confirm', $order->invoice_number) }}" wire:navigate
                        class="w-full btn-primary btn btn-lg justify-center">
                        Konfirmasi Pembayaran
                    </a>
                @endif

                @if ($order->status === 'pending' && $order->payment_method === 'midtrans' && $order->midtrans_token)
                    <button id="pay-midtrans-btn" class="w-full btn-primary btn btn-lg justify-center">
                        Selesaikan Pembayaran
                    </button>
                @endif

                <a href="{{ route('user.orders.show', $order->invoice_number) }}" wire:navigate
                    class="w-full btn-outline btn btn-lg justify-center">
                    Lihat Detail Pesanan
                </a>
                <a href="{{ route('home') }}" wire:navigate class="w-full btn-ghost btn justify-center text-white/30">
                    Kembali ke Home
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @if ($order->status === 'pending' && $order->payment_method === 'midtrans' && $order->midtrans_token)
        @php $paymentSetting = \App\Models\PaymentSetting::first(); @endphp

        <script
            src="{{ $paymentSetting->midtrans_production
                ? 'https://app.midtrans.com/snap/snap.js'
                : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
            data-client-key="{{ $paymentSetting->midtrans_client_key }}"></script>

        <script>
            document.getElementById('pay-midtrans-btn').onclick = function() {
                snap.pay('{{ $order->midtrans_token }}', {
                    onSuccess: function(result) {
                        window.location.reload();
                    },
                    onPending: function(result) {
                        window.location.reload();
                    },
                    onError: function(result) {
                        alert('Pembayaran gagal, silakan coba lagi.');
                    },
                    onClose: function() {
                        // user tutup popup, tidak perlu action
                    }
                });
            };

            // Auto-buka popup langsung saat halaman load
            window.addEventListener('load', function() {
                document.getElementById('pay-midtrans-btn').click();
            });
        </script>
    @endif
@endpush
