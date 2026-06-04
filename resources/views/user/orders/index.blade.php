@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
    <x-section-header label="Member Area" title="Pesanan Saya" description="" />

    <div class="pb-20">
        <div class="max-w-6xl mx-auto px-6">

            @if ($orders->count() > 0)
                <div class="space-y-3">
                    @foreach ($orders as $order)
                        <div class="card p-4">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-xs font-mono text-white/50">{{ $order->invoice_number }}</span>
                                        @php
                                            $statusClass = match ($order->status) {
                                                'paid' => 'badge-success',
                                                'pending' => 'badge-warning',
                                                'failed', 'expired' => 'badge-destructive',
                                                default => 'badge-secondary',
                                            };
                                        @endphp
                                        <span class="{{ $statusClass }} capitalize">{{ $order->status }}</span>
                                    </div>
                                    <p class="text-xs text-white/30">
                                        {{ $order->items->count() }} item ·
                                        {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }} ·
                                        {{ $order->created_at->format('d M Y') }}
                                    </p>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="text-sm font-semibold text-white mb-2">
                                        Rp {{ number_format($order->total, 0, ',', '.') }}
                                    </p>
                                    <div class="flex items-center gap-2 justify-end">
                                        @if ($order->status === 'pending' && $order->payment_method === 'manual_transfer')
                                            <a href="{{ route('user.payment.confirm', $order->invoice_number) }}"
                                                wire:navigate class="btn-primary btn-sm btn">
                                                Bayar
                                            </a>
                                        @endif
                                        <a href="{{ route('user.orders.show', $order->invoice_number) }}" wire:navigate
                                            class="btn-outline btn-sm btn">
                                            Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">{{ $orders->links() }}</div>
            @else
                <div class="text-center py-20 border border-white/5 rounded-xl">
                    <i class="fas fa-receipt text-3xl text-white/10 mb-3 block"></i>
                    <p class="text-xs text-white/30 mb-4">Belum ada pesanan</p>
                    <a href="{{ route('courses.index') }}" wire:navigate class="btn-outline btn">
                        Mulai Belanja
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
