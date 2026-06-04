@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title font-mono">{{ $order->invoice_number }}</h1>
            <p class="page-desc">Detail transaksi</p>
        </div>
        <x-btn variant="outline" href="{{ route('admin.orders.index') }}" wire:navigate>
            <i class="fas fa-arrow-left"></i> Kembali
        </x-btn>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- Left --}}
        <div class="lg:col-span-2 space-y-4">

            {{-- Items --}}
            <div class="card">
                <div class="card-header">
                    <p class="text-xs font-medium text-white/50">Item Pesanan</p>
                </div>
                <div class="divide-y divide-white/5">
                    @foreach ($order->items as $item)
                        <div class="px-5 py-4">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <x-badge class="mb-1">
                                        {{ class_basename($item->itemable_type) === 'Course' ? 'Kelas' : 'Produk' }}
                                    </x-badge>
                                    <p class="text-sm font-medium text-white/70">{{ $item->item_name }}</p>
                                    <p class="text-xs text-white/30 mt-0.5">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>

                            {{-- License --}}
                            @if ($item->license)
                                <div class="mt-3 bg-white/5 rounded-lg px-4 py-3 space-y-2">
                                    <p class="text-[11px] text-white/30 font-medium uppercase tracking-wider mb-2">
                                        <i class="fas fa-key mr-1"></i> Data Lisensi
                                    </p>
                                    <div class="space-y-2">
                                        <div class="flex items-start gap-3">
                                            <span
                                                class="text-[11px] text-white/20 w-20 flex-shrink-0 pt-0.5">WP-Admin</span>
                                            <a href="{{ $item->license->wp_admin_url }}" target="_blank"
                                                class="text-xs text-white/50 font-mono hover:text-white transition-colors break-all">
                                                {{ $item->license->wp_admin_url }}
                                                <i class="fas fa-external-link-alt text-[10px] ml-1"></i>
                                            </a>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="text-[11px] text-white/20 w-20 flex-shrink-0">Username</span>
                                            <span
                                                class="text-xs text-white/50 font-mono">{{ $item->license->username }}</span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="text-[11px] text-white/20 w-20 flex-shrink-0">Password</span>
                                            <span class="text-xs text-white/50 font-mono" x-data="{ show: false }">
                                                <span x-show="!show">••••••••</span>
                                                <span x-show="show">{{ $item->license->password }}</span>
                                                <button type="button" @click="show = !show"
                                                    class="ml-2 text-white/20 hover:text-white/50 transition-colors">
                                                    <i class="fas text-[10px]"
                                                        :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Bukti Transfer --}}
            @if ($order->payment_proof)
                <div class="card p-5">
                    <p class="text-xs font-medium text-white/40 uppercase tracking-widest mb-4">Bukti Transfer</p>
                    <img src="{{ Storage::url($order->payment_proof) }}"
                        class="max-w-xs rounded-lg border border-white/10 opacity-80">
                </div>
            @endif
        </div>

        {{-- Right --}}
        <div class="space-y-4">

            {{-- Update Status --}}
            <div class="card p-5">
                <p class="text-xs font-medium text-white/40 uppercase tracking-widest mb-4">Update Status</p>
                <form action="{{ route('admin.orders.status', $order->invoice_number) }}" method="POST" class="space-y-3">
                    @csrf @method('PUT')
                    <x-form.select name="status" label="Status Pesanan" :selected="$order->status" :options="[
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                        'expired' => 'Expired',
                    ]" />
                    <x-btn type="submit" class="w-full justify-center">Update Status</x-btn>
                </form>
            </div>

            {{-- Order Info --}}
            <div class="card p-5">
                <p class="text-xs font-medium text-white/40 uppercase tracking-widest mb-4">Info Pesanan</p>
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-white/30">User</span>
                        <span class="text-xs text-white/60">{{ $order->user->name ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-white/30">Email</span>
                        <span class="text-xs text-white/60">{{ $order->user->email ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-white/30">Metode</span>
                        <span class="text-xs text-white/60 capitalize">
                            {{ str_replace('_', ' ', $order->payment_method) }}
                        </span>
                    </div>
                    @if ($order->promoCode)
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-white/30">Promo</span>
                            <span class="text-xs font-mono text-white/60">{{ $order->promoCode->code }}</span>
                        </div>
                    @endif
                    <div class="border-t border-white/5 pt-2.5 space-y-2">
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
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-white">Total</span>
                            <span class="text-sm font-semibold text-white">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-white/30">Status</span>
                        @php
                            $statusVariant = match ($order->status) {
                                'paid' => 'success',
                                'pending' => 'warning',
                                'failed', 'expired' => 'destructive',
                                default => 'secondary',
                            };
                        @endphp
                        <x-badge variant="{{ $statusVariant }}">{{ ucfirst($order->status) }}</x-badge>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-white/30">Tanggal</span>
                        <span class="text-xs text-white/60">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    @if ($order->paid_at)
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-white/30">Dibayar</span>
                            <span class="text-xs text-white/60">{{ $order->paid_at->format('d M Y, H:i') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
