<div>
    {{-- Filter & Search --}}
    <div class="card p-4 mb-4">
        <div class="flex flex-wrap items-center gap-3">

            {{-- Search --}}
            <div class="flex-1 min-w-48">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-white/20 text-xs"></i>
                    <x-form.input name="search" placeholder="Cari invoice, nama, email..."
                        wire:model.live.debounce.300ms="search" class="pl-8 w-full" />
                </div>
            </div>

            {{-- Filter Status --}}
            <x-form.select name="type" placeholder="Status" wire:model.live="status" class="w-40"
                :options="[
                    'pending' => 'Pending',
                    'paid' => 'Paid',
                    'failed' => 'Failed',
                    'expired' => 'Expired',
                ]" />

            {{-- Filter Metode --}}
            <x-form.select name="type" placeholder="Metode" wire:model.live="payment_method" class="w-44"
                :options="['manual_transfer' => 'Manual Transfer', 'midtrans' => 'Midtrans']" />

            {{-- Per Page --}}
            <x-form.select name="perPage" wire:model.live="perPage" class="w-24" :options="[10 => '10', 25 => '25', 50 => '50']" />


            {{-- Reset --}}
            @if ($search || $status || $payment_method)
                <x-btn variant="ghost" size="sm" wire:click="resetFilters" class="text-white/40 hover:text-white">
                    <i class="fas fa-times text-[10px]"></i> Reset
                </x-btn>
            @endif
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="table-wrapper border-0">
            <table class="table">
                <thead>
                    <tr>
                        {{-- Sortable Columns --}}
                        <th>
                            <button wire:click="sort('invoice_number')"
                                class="flex items-center gap-1 hover:text-white transition-colors">
                                Invoice
                                @if ($sortBy === 'invoice_number')
                                    <i
                                        class="fas fa-sort-{{ $sortDir === 'asc' ? 'up' : 'down' }} text-[10px] text-white"></i>
                                @else
                                    <i class="fas fa-sort text-[10px] text-white/20"></i>
                                @endif
                            </button>
                        </th>
                        <th>
                            <button wire:click="sort('user_id')"
                                class="flex items-center gap-1 hover:text-white transition-colors">
                                User
                                @if ($sortBy === 'user_id')
                                    <i
                                        class="fas fa-sort-{{ $sortDir === 'asc' ? 'up' : 'down' }} text-[10px] text-white"></i>
                                @else
                                    <i class="fas fa-sort text-[10px] text-white/20"></i>
                                @endif
                            </button>
                        </th>
                        <th>Items</th>
                        <th>
                            <button wire:click="sort('total')"
                                class="flex items-center gap-1 hover:text-white transition-colors">
                                Total
                                @if ($sortBy === 'total')
                                    <i
                                        class="fas fa-sort-{{ $sortDir === 'asc' ? 'up' : 'down' }} text-[10px] text-white"></i>
                                @else
                                    <i class="fas fa-sort text-[10px] text-white/20"></i>
                                @endif
                            </button>
                        </th>
                        <th>Metode</th>
                        <th>
                            <button wire:click="sort('status')"
                                class="flex items-center gap-1 hover:text-white transition-colors">
                                Status
                                @if ($sortBy === 'status')
                                    <i
                                        class="fas fa-sort-{{ $sortDir === 'asc' ? 'up' : 'down' }} text-[10px] text-white"></i>
                                @else
                                    <i class="fas fa-sort text-[10px] text-white/20"></i>
                                @endif
                            </button>
                        </th>
                        <th>
                            <button wire:click="sort('created_at')"
                                class="flex items-center gap-1 hover:text-white transition-colors">
                                Tanggal
                                @if ($sortBy === 'created_at')
                                    <i
                                        class="fas fa-sort-{{ $sortDir === 'asc' ? 'up' : 'down' }} text-[10px] text-white"></i>
                                @else
                                    <i class="fas fa-sort text-[10px] text-white/20"></i>
                                @endif
                            </button>
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>
                                <span class="text-xs font-mono text-white/50">
                                    {{ $order->invoice_number }}
                                </span>
                            </td>
                            <td>
                                <div>
                                    <p class="text-xs text-white/60">{{ $order->user->name ?? '-' }}</p>
                                    <p class="text-[11px] text-white/30">{{ $order->user->email ?? '' }}</p>
                                </div>
                            </td>
                            <td>
                                <span class="text-xs text-white/40">{{ $order->items->count() }} item</span>
                            </td>
                            <td>
                                <span class="text-xs text-white/60">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                <span class="text-xs text-white/40 capitalize">
                                    {{ str_replace('_', ' ', $order->payment_method) }}
                                </span>
                            </td>
                            <td>
                                <x-badge
                                    variant="{{ match ($order->status) {
                                        'paid' => 'success',
                                        'pending' => 'warning',
                                        'failed', 'expired' => 'destructive',
                                        default => 'secondary',
                                    } }}">
                                    {{ ucfirst($order->status) }}
                                </x-badge>
                            </td>
                            <td>
                                <span class="text-xs text-white/30">
                                    {{ $order->created_at->format('d M Y') }}
                                </span>
                            </td>
                            <td>
                                <x-btn href="{{ route('admin.orders.show', $order->invoice_number) }}" wire:navigate
                                    variant="ghost" size="sm">
                                    Detail
                                </x-btn>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-12">
                                <i class="fas fa-receipt text-2xl text-white/10 mb-2 block"></i>
                                <p class="text-xs text-white/20">
                                    {{ $search || $status || $payment_method ? 'Tidak ada hasil yang ditemukan' : 'Belum ada pesanan' }}
                                </p>
                                @if ($search || $status || $payment_method)
                                    <x-btn variant="ghost" wire:click="resetFilters" class="mt-2">
                                        Reset filter
                                    </x-btn>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination & Info --}}
        <div class="card-footer flex items-center justify-between">
            <p class="text-xs text-white/30">
                Menampilkan {{ $orders->firstItem() ?? 0 }}–{{ $orders->lastItem() ?? 0 }}
                dari {{ $orders->total() }} pesanan
            </p>
            {{ $orders->links() }}
        </div>
    </div>

    {{-- Loading indicator --}}
    <div wire:loading.delay class="fixed bottom-4 right-4 z-50">
        <div
            class="bg-[#0D0D0D] border border-white/10 rounded-lg px-3 py-2 flex items-center gap-2 text-xs text-white/50">
            <i class="fas fa-spinner fa-spin text-[10px] text-white/80"></i>
            Memuat...
        </div>
    </div>
</div>
