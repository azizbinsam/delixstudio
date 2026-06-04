@extends('layouts.admin')

@section('title', 'Detail User')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">{{ $user->name }}</h1>
            <p class="page-desc">Detail informasi member</p>
        </div>
        <a href="{{ route('admin.users.index') }}" wire:navigate class="btn-outline btn">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- User Info --}}
        <div class="space-y-4">
            <div class="card p-5">
                <div class="flex items-center gap-3 mb-4 pb-4 border-b border-white/5">
                    <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center flex-shrink-0">
                        @if ($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}" class="w-full h-full rounded-full object-cover">
                        @else
                            <span class="text-sm text-white/50 font-medium">{{ substr($user->name, 0, 1) }}</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white">{{ $user->name }}</p>
                        <p class="text-xs text-white/30">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-white/30">Phone</span>
                        <span class="text-xs text-white/60">{{ $user->phone ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-white/30">Bergabung</span>
                        <span class="text-xs text-white/60">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-white/30">Total Pesanan</span>
                        <span class="text-xs text-white/60">{{ $totalOrders }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-white/30">Total Belanja</span>
                        <span class="text-xs text-white/60">Rp {{ number_format($totalSpending, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Orders --}}
        <div class="lg:col-span-2">
            <div class="card">
                <div class="card-header">
                    <p class="text-xs font-medium text-white/50">Riwayat Pesanan</p>
                </div>
                <div class="table-wrapper border-0 rounded-t-none">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user->orders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->invoice_number) }}" wire:navigate
                                            class="text-xs font-mono text-white/50 hover:text-white transition-colors">
                                            {{ $order->invoice_number }}
                                        </a>
                                    </td>
                                    <td><span class="text-xs text-white/40">{{ $order->items->count() }} item</span></td>
                                    <td><span class="text-xs text-white/60">Rp
                                            {{ number_format($order->total, 0, ',', '.') }}</span></td>
                                    <td>
                                        @php
                                            $statusClass = match ($order->status) {
                                                'paid' => 'badge-success',
                                                'pending' => 'badge-warning',
                                                'failed', 'expired' => 'badge-destructive',
                                                default => 'badge-secondary',
                                            };
                                        @endphp
                                        <span class="{{ $statusClass }} capitalize">{{ $order->status }}</span>
                                    </td>
                                    <td><span
                                            class="text-xs text-white/30">{{ $order->created_at->format('d M Y') }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-white/20 text-xs">Belum ada pesanan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
