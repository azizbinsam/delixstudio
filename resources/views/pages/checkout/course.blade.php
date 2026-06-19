@extends('layouts.app')

@section('title', 'Checkout — ' . $course->title)

@section('content')
    <x-section-header label="Pembayaran" title="Checkout Kelas" description="" />

    <div class="pb-20">
        <div class="max-w-6xl mx-auto px-6">

            @php
                $sessionPromo = session('course_promo_' . $course->id);
                $discount = 0;
                if ($sessionPromo) {
                    $promo = \App\Models\PromoCode::find($sessionPromo['id']);
                    $discount = $promo ? $promo->calculateDiscount($course->price) : 0;
                }
                $total = max(0, $course->price - $discount);
            @endphp

            {{-- Form promo (hidden, di luar form utama) --}}
            @if (!$sessionPromo)
                <form id="form-promo" action="{{ route('user.checkout.course.promo', $course) }}" method="POST"
                    style="display:none">
                    @csrf
                </form>
            @else
                <form id="form-promo-remove" action="{{ route('user.checkout.course.promo.remove', $course) }}"
                    method="POST" style="display:none">
                    @csrf
                    @method('DELETE')
                </form>
            @endif

            {{-- Form utama checkout --}}
            <form action="{{ route('user.checkout.course.process', $course) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- Kiri: Detail Kelas --}}
                    <div class="lg:col-span-2 space-y-6">

                        {{-- Info Kelas --}}
                        <div class="card">
                            <div class="card-header">
                                <p class="text-xs font-medium text-white/50">Item Pesanan</p>
                            </div>
                            <div class="px-5 py-4 flex items-center gap-4">
                                <div class="w-16 h-12 bg-white/5 rounded-lg overflow-hidden flex-shrink-0">
                                    @if ($course->thumbnail)
                                        <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}"
                                            class="w-full h-full object-cover opacity-70">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fas fa-play-circle text-white/20"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span class="badge-secondary text-[10px] mb-1 inline-block">Kelas</span>
                                    <p class="text-sm font-medium text-white">{{ $course->title }}</p>
                                    <p class="text-xs text-white/30 mt-0.5">{{ $course->level }}</p>
                                </div>
                                <span class="text-sm font-semibold text-white flex-shrink-0">
                                    Rp {{ number_format($course->price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        {{-- Metode Pembayaran --}}
                        <div class="card">
                            <div class="card-header">
                                <p class="text-xs font-medium text-white/50">Metode Pembayaran</p>
                            </div>
                            <div class="card-body space-y-3">
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

                                @if ($paymentSetting->midtrans_active)
                                    <label
                                        class="flex items-start gap-3 p-3 border border-white/10 rounded-lg cursor-pointer hover:border-white/20 transition-colors has-[:checked]:border-white/40 has-[:checked]:bg-white/5">
                                        <input type="radio" name="payment_method" value="midtrans"
                                            class="mt-0.5 accent-white"
                                            {{ !$paymentSetting->manual_transfer_active ? 'checked' : '' }}>
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
                                            class="mt-0.5 accent-white">
                                        <div>
                                            <p class="text-sm font-medium text-white">QRIS via Fersaku</p>
                                            <p class="text-xs text-white/30 mt-0.5">
                                                Bayar dengan QRIS dari e-wallet manapun
                                            </p>
                                        </div>
                                    </label>
                                @endif
                            </div>
                        </div>

                    </div>

                    {{-- Kanan: Summary --}}
                    <div class="lg:col-span-1">
                        <div class="card p-5 sticky top-24">
                            <p class="text-xs font-medium text-white/40 uppercase tracking-widest mb-4">Ringkasan</p>

                            {{-- Kode Promo --}}
                            @if (!$sessionPromo)
                                <div class="mb-4">
                                    <label class="label">Kode Promo</label>
                                    <div class="flex gap-2">
                                        <input type="text" name="promo_code" form="form-promo"
                                            placeholder="Masukkan kode promo" class="input flex-1 uppercase"
                                            style="text-transform:uppercase">
                                        <button type="submit" form="form-promo" class="btn btn-outline flex-shrink-0">
                                            Pakai
                                        </button>
                                    </div>
                                    @error('promo_code')
                                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            @else
                                <div
                                    class="flex items-center justify-between bg-white/5 border border-white/10 rounded-lg px-3 py-2 mb-4">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-ticket-alt text-xs text-white/40"></i>
                                        <span class="text-xs font-medium text-white">{{ $sessionPromo['code'] }}</span>
                                        <span class="text-xs text-white/40">
                                            {{ $sessionPromo['type'] === 'percentage'
                                                ? $sessionPromo['value'] . '% off'
                                                : 'Rp ' . number_format($sessionPromo['value'], 0, ',', '.') . ' off' }}
                                        </span>
                                    </div>
                                    <button type="submit" form="form-promo-remove"
                                        class="text-white/20 hover:text-red-400 transition-colors text-xs p-1">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endif

                            {{-- Rincian Harga --}}
                            <div class="space-y-2.5 mb-5">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-white/30">Harga</span>
                                    <span class="text-xs text-white/60">
                                        Rp {{ number_format($course->price, 0, ',', '.') }}
                                    </span>
                                </div>
                                @if ($discount > 0)
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-white/30">Diskon</span>
                                        <span class="text-xs text-green-400">
                                            - Rp {{ number_format($discount, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endif
                                <div class="border-t border-white/5 pt-2.5 flex items-center justify-between">
                                    <span class="text-sm font-medium text-white">Total</span>
                                    <span class="text-sm font-semibold text-white">
                                        Rp {{ number_format($total, 0, ',', '.') }}
                                    </span>
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
