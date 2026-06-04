@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')
    <x-section-header label="Belanja" title="Keranjang" description="" />
    <div class="pb-20">
        <div class="max-w-6xl mx-auto px-6">
            @if (empty($cart))
                {{-- Empty State --}}
                <div class="text-center py-24 border border-white/5 rounded-xl">
                    <i class="fas fa-shopping-cart text-3xl text-white/10 mb-3 block"></i>
                    <p class="text-sm text-white/30 mb-4">Keranjangmu masih kosong</p>
                    <div class="flex items-center justify-center gap-3">
                        <a href="{{ route('courses.index') }}" wire:navigate class="btn-outline btn">Lihat Kelas</a>
                        <a href="{{ route('products.index') }}" wire:navigate class="btn-outline btn">Lihat Produk</a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- Cart Items --}}
                    <div class="lg:col-span-2 space-y-3">
                        @foreach ($cart as $key => $item)
                            <div class="card p-4 flex items-center gap-4">

                                {{-- Thumbnail --}}
                                <div class="w-20 h-14 bg-white/5 rounded-lg overflow-hidden flex-shrink-0">
                                    @if ($item['thumbnail'])
                                        <img src="{{ Storage::url($item['thumbnail']) }}" alt="{{ $item['name'] }}"
                                            class="w-full h-full object-cover opacity-70">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i
                                                class="fas fa-{{ $item['type'] === 'course' ? 'play-circle' : 'box' }} text-white/20 text-sm"></i>
                                        </div>
                                    @endif
                                </div>

                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-1.5 mb-1">
                                        <span
                                            class="badge-secondary capitalize">{{ $item['type'] === 'course' ? 'Kelas' : 'Produk' }}</span>
                                    </div>
                                    <p class="text-sm font-medium text-white truncate">{{ $item['name'] }}</p>
                                    <p class="text-sm font-semibold text-white/80 mt-1">
                                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                                    </p>
                                </div>

                                {{-- Remove --}}
                                <form action="{{ route('user.cart.remove', $key) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-1.5 rounded-md text-white/20 hover:text-red-400 hover:bg-red-500/10 transition-colors">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>

                    {{-- Summary --}}
                    <div class="lg:col-span-1">
                        <div class="card p-5 sticky top-24">
                            <p class="text-xs font-medium text-white/40 uppercase tracking-widest mb-4">Ringkasan</p>

                            {{-- Promo Code --}}
                            @if (!$promoCode)
                                <form action="{{ route('user.cart.promo') }}" method="POST" class="mb-4">
                                    @csrf
                                    <label class="label">Kode Promo</label>
                                    <div class="flex gap-2">
                                        <input type="text" name="code" placeholder="Masukkan kode promo"
                                            class="input flex-1 uppercase" style="text-transform: uppercase;">
                                        <button type="submit" class="btn-outline btn flex-shrink-0">
                                            Pakai
                                        </button>
                                    </div>
                                    @error('code')
                                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                    @enderror
                                </form>
                            @else
                                <div
                                    class="flex items-center justify-between bg-white/5 border border-white/10 rounded-lg px-3 py-2 mb-4">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-ticket-alt text-xs text-white/40"></i>
                                        <span class="text-xs font-medium text-white">{{ $promoCode['code'] }}</span>
                                        <span class="text-xs text-white/40">
                                            {{ $promoCode['type'] === 'percentage'
                                                ? $promoCode['value'] . '% off'
                                                : 'Rp ' . number_format($promoCode['value'], 0, ',', '.') . ' off' }}
                                        </span>
                                    </div>
                                    {{-- Hapus Promo --}}
                                    <form action="{{ route('user.cart.promo.remove') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-white/20 hover:text-red-400 transition-colors text-xs p-1">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif

                            {{-- Subtotal --}}
                            @php
                                $subtotal = collect($cart)->sum('price');
                                $discount = 0;
                                if ($promoCode) {
                                    $discount =
                                        $promoCode['type'] === 'percentage'
                                            ? $subtotal * ($promoCode['value'] / 100)
                                            : $promoCode['value'];
                                }
                                $total = max(0, $subtotal - $discount);
                            @endphp

                            <div class="space-y-2.5 mb-4">
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

                            <a href="{{ route('user.checkout.index') }}" wire:navigate
                                class="w-full btn-primary btn btn-lg justify-center">
                                Lanjut ke Checkout
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
