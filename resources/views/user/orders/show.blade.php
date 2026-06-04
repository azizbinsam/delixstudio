@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
    <div class="pt-10 pb-20">
        <div class="max-w-3xl mx-auto px-6">

            {{-- Header --}}
            <div class="flex items-center gap-3 mb-8">
                <a href="{{ route('user.orders.index') }}" wire:navigate
                    class="p-1.5 rounded-md text-white/30 hover:text-white hover:bg-white/5 transition-colors">
                    <i class="fas fa-arrow-left text-xs"></i>
                </a>
                <div>
                    <p class="section-label">Pesanan</p>
                    <h1 class="text-xl font-semibold tracking-tight text-white font-mono">
                        {{ $order->invoice_number }}
                    </h1>
                </div>
            </div>

            <div class="space-y-4">

                {{-- Status Card --}}
                <div class="card p-5">
                    <div class="flex items-center justify-between">
                        <div class="space-y-1">
                            <p class="text-xs text-white/30">Status Pesanan</p>
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
                        @if ($order->status === 'pending' && $order->payment_method === 'manual_transfer')
                            <a href="{{ route('user.payment.confirm', $order->invoice_number) }}" wire:navigate
                                class="btn-primary btn">
                                Konfirmasi Bayar
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Items --}}
                <div class="card">
                    <div class="card-header">
                        <p class="text-xs font-medium text-white/50">Item Pesanan</p>
                    </div>
                    <div class="divide-y divide-white/5">
                        @foreach ($order->items as $item)
                            <div class="px-5 py-4">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <x-badge>
                                                {{ class_basename($item->itemable_type) === 'Course' ? 'Kelas' : 'Produk' }}
                                            </x-badge>
                                            @if (!$item->itemable)
                                                <x-badge variant="destructive">Tidak Tersedia</x-badge>
                                            @endif
                                        </div>
                                        <p class="text-sm font-medium text-white">{{ $item->item_name }}</p>
                                        <p class="text-xs text-white/30 mt-0.5">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    {{-- Aksi --}}
                                    @if ($order->status === 'paid')
                                        @if (!$item->itemable)
                                            {{-- Produk/Kelas sudah dihapus --}}
                                            <div class="text-right flex-shrink-0">
                                                <p class="text-[11px] text-white/30 leading-relaxed max-w-[160px]">
                                                    Konten tidak tersedia. Hubungi admin untuk konfirmasi.
                                                </p>
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\PaymentSetting::first()?->whatsapp_number) }}?text={{ urlencode('Halo Admin, saya ingin konfirmasi pesanan ' . $order->invoice_number . ' untuk item: ' . $item->item_name) }}"
                                                    target="_blank" class="btn-outline btn-sm btn mt-2 inline-flex">
                                                    <i class="fab fa-whatsapp"></i> Hubungi Admin
                                                </a>
                                            </div>
                                        @elseif(class_basename($item->itemable_type) === 'Course')
                                            @php
                                                $course = $item->itemable;
                                                $firstChapter = $course?->sections->first()?->chapters->first();
                                            @endphp
                                            @if ($firstChapter)
                                                <a href="{{ route('courses.learn', [$course->slug, $firstChapter->id]) }}"
                                                    wire:navigate class="btn-primary btn-sm btn flex-shrink-0">
                                                    <i class="fas fa-play-circle"></i> Akses Kelas
                                                </a>
                                            @else
                                                <a href="{{ route('courses.show', $course->slug) }}" wire:navigate
                                                    class="btn-outline btn-sm btn flex-shrink-0">
                                                    <i class="fas fa-eye"></i> Lihat Kelas
                                                </a>
                                            @endif
                                        @elseif(class_basename($item->itemable_type) === 'Product')
                                            @if ($item->itemable->type === 'file')
                                                <a href="{{ route('user.download', $item->id) }}"
                                                    class="btn-outline btn-sm btn flex-shrink-0">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            @endif
                                        @endif
                                    @endif
                                </div>

                                {{-- License info --}}
                                @if ($item->license)
                                    <div class="mt-3 bg-white/5 rounded-lg px-3 py-2.5 space-y-1.5">
                                        <p class="text-[11px] text-white/30 font-medium uppercase tracking-wider">
                                            Data Lisensi
                                        </p>
                                        <div class="grid grid-cols-2 gap-2">
                                            <div>
                                                <p class="text-[11px] text-white/20">WP-Admin URL</p>
                                                <p class="text-xs text-white/50 truncate">
                                                    {{ $item->license->wp_admin_url }}
                                                </p>
                                            </div>
                                            <div>
                                                <p class="text-[11px] text-white/20">Username</p>
                                                <p class="text-xs text-white/50">{{ $item->license->username }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- Keterangan jika tidak tersedia --}}
                                @if (!$item->itemable && $order->status !== 'paid')
                                    <p class="text-[11px] text-white/30 mt-2 leading-relaxed">
                                        Konten ini tidak lagi tersedia.
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Payment Info --}}
                <div class="card p-5">
                    <p class="text-xs font-medium text-white/40 uppercase tracking-widest mb-4">Info Pembayaran</p>
                    <div class="space-y-2.5">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-white/30">Metode</span>
                            <span class="text-xs text-white/60 capitalize">
                                {{ str_replace('_', ' ', $order->payment_method) }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-white/30">Subtotal</span>
                            <span class="text-xs text-white/60">
                                Rp {{ number_format($order->subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                        @if ($order->discount > 0)
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-white/30">Diskon</span>
                                <span class="text-xs text-green-400">
                                    - Rp {{ number_format($order->discount, 0, ',', '.') }}
                                </span>
                            </div>
                        @endif
                        <div class="border-t border-white/5 pt-2.5 flex items-center justify-between">
                            <span class="text-sm font-medium text-white">Total</span>
                            <span class="text-sm font-semibold text-white">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </span>
                        </div>
                        @if ($order->paid_at)
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-white/30">Dibayar pada</span>
                                <span class="text-xs text-white/60">
                                    {{ $order->paid_at->format('d M Y, H:i') }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
