@extends('layouts.app')

@section('title', $product->title)

@section('content')
    <div class="pt-10 pb-20">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                {{-- Left --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- Breadcrumb --}}
                    <div class="flex items-center gap-2 text-xs text-white/30">
                        <a href="{{ route('products.index') }}" wire:navigate
                            class="hover:text-white transition-colors">Produk</a>
                        <i class="fas fa-chevron-right text-[10px]"></i>
                        <span class="text-white/50 truncate">{{ $product->title }}</span>
                    </div>

                    {{-- Thumbnail --}}
                    @if ($product->thumbnail)
                        <div class="aspect-video rounded-xl overflow-hidden bg-white/5">
                            <img src="{{ Storage::url($product->thumbnail) }}" alt="{{ $product->title }}"
                                class="w-full h-full object-cover opacity-80">
                        </div>
                    @endif

                    {{-- Meta --}}
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="badge-secondary">{{ $product->category->name ?? '-' }}</span>
                            <span class="badge-secondary">{{ $product->type === 'file' ? 'File' : 'Lisensi' }}</span>
                        </div>
                        <h1 class="text-2xl font-semibold tracking-tight text-white mb-3">{{ $product->title }}</h1>
                        <p class="text-sm text-white/40 leading-relaxed">{{ $product->description }}</p>
                    </div>


                    {{-- Info Lisensi --}}
                    @if ($product->type === 'license')
                        <div class="alert-info">
                            <i class="fas fa-info-circle text-xs mt-0.5"></i>
                            <div>
                                <p class="font-medium text-white/60 mb-0.5">Produk Lisensi</p>
                                <p class="text-white/30 leading-relaxed">
                                    Produk ini memerlukan akses WP-Admin. Kamu akan diminta mengisi URL WP-Admin, username,
                                    dan password saat checkout.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Right: Sticky Card --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-24 card">

                        {{-- Thumbnail --}}
                        @if ($product->thumbnail)
                            <div class="aspect-video rounded-t-xl overflow-hidden">
                                <img src="{{ Storage::url($product->thumbnail) }}" alt="{{ $product->title }}"
                                    class="w-full h-full object-cover opacity-80">
                            </div>
                        @endif

                        <div class="p-5">
                            {{-- Price --}}
                            <div class="text-2xl font-semibold text-white mb-5">
                                @if ($product->price == 0)
                                    Gratis
                                @else
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                @endif
                            </div>

                            @if ($hasPurchased && $product->type !== 'license')
                                <div class="alert-success mb-3 text-xs">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Kamu sudah memiliki produk ini</span>
                                </div>

                                @if ($product->type === 'file')
                                    @php
                                        $order = Auth::user()
                                            ->orders()
                                            ->where('status', 'paid')
                                            ->whereHas('items', function ($q) use ($product) {
                                                $q->where('itemable_type', \App\Models\Product::class)->where(
                                                    'itemable_id',
                                                    $product->id,
                                                );
                                            })
                                            ->latest()
                                            ->first();
                                    @endphp
                                    @if ($order)
                                        <a href="{{ route('user.orders.show', $order->invoice_number) }}" wire:navigate
                                            class="w-full btn-outline btn justify-center mt-2">
                                            <i class="fas fa-download"></i> Download File
                                        </a>
                                    @endif
                                @endif
                            @else
                                @auth
                                    <form action="{{ route('user.cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="type" value="product">
                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                        <button type="submit" class="w-full btn-primary btn btn-lg justify-center">
                                            <i class="fas fa-shopping-cart"></i>
                                            {{ $hasPurchased ? 'Beli Lagi (Domain Baru)' : 'Tambah ke Keranjang' }}
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" wire:navigate
                                        class="w-full btn-primary btn btn-lg justify-center">
                                        Masuk untuk Membeli
                                    </a>
                                @endauth
                            @endif

                            {{-- Tombol Demo & Tutorial --}}
                            @if ($product->demo_url || $product->tutorial_url)
                                <div class="mt-3 space-y-2">
                                    @if ($product->demo_url)
                                        <a href="{{ $product->demo_url }}" target="_blank"
                                            class="w-full btn-outline btn justify-center">
                                            <i class="fas fa-external-link-alt text-[10px]"></i>
                                            Lihat Demo
                                        </a>
                                    @endif
                                    @if ($product->tutorial_url)
                                        @php
                                            $isTutorialYoutube =
                                                str_contains($product->tutorial_url, 'youtube.com') ||
                                                str_contains($product->tutorial_url, 'youtu.be');
                                        @endphp
                                        <a href="{{ $product->tutorial_url }}" target="_blank"
                                            class="w-full btn-outline btn justify-center">
                                            @if ($isTutorialYoutube)
                                                <i class="fab fa-youtube text-red-400 text-[10px]"></i>
                                            @else
                                                <i class="fas fa-book text-[10px]"></i>
                                            @endif
                                            Tutorial Install
                                        </a>
                                    @endif
                                </div>
                            @endif

                            {{-- Info --}}
                            <div class="mt-5 pt-5 border-t border-white/5 space-y-2.5">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-white/30">Kategori</span>
                                    <span class="text-xs text-white/60">{{ $product->category->name ?? '-' }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-white/30">Tipe</span>
                                    <span
                                        class="text-xs text-white/60">{{ $product->type === 'file' ? 'File Download' : 'Lisensi' }}</span>
                                </div>
                                @if ($product->type === 'file' && $product->files->count() > 0)
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-white/30">File</span>
                                        <span class="text-xs text-white/60">{{ $product->files->count() }} file</span>
                                    </div>
                                @endif
                                @if ($product->demo_url)
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-white/30">Demo</span>
                                        <a href="{{ $product->demo_url }}" target="_blank"
                                            class="text-xs text-white/60 hover:text-white transition-colors flex items-center gap-1">
                                            Lihat Demo <i class="fas fa-external-link-alt text-[10px]"></i>
                                        </a>
                                    </div>
                                @endif
                                @if ($product->tutorial_url)
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-white/30">Tutorial</span>
                                        <a href="{{ $product->tutorial_url }}" target="_blank"
                                            class="text-xs text-white/60 hover:text-white transition-colors flex items-center gap-1">
                                            Lihat Tutorial <i class="fas fa-external-link-alt text-[10px]"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
