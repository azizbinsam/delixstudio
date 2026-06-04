<div>

    {{-- Filter & Search --}}
    <div class="card p-4 mb-4">
        <div class="flex flex-wrap items-center gap-3">
            <div class="flex-1 min-w-48">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-white/20 text-xs"></i>
                    <x-form.input name="search" placeholder="Cari nama kode promo..."
                        wire:model.live.debounce.300ms="search" class="pl-8 w-full" />
                </div>
            </div>
            <x-form.select name="type" placeholder="Tipe" wire:model.live="type" class="w-36" :options="['percentage' => 'Persentase', 'fixed' => 'Fixed']" />
            <x-form.select name="is_active" placeholder="Status" wire:model.live="is_active" class="w-36"
                :options="['1' => 'Aktif', '0' => 'Nonaktif']" />
            <x-form.select name="perPage" wire:model.live="perPage" class="w-24" :options="[10 => '10', 25 => '25', 50 => '50']" />

            {{-- Toggle Trashed --}}
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" wire:model.live="showTrashed" class="sr-only peer">
                <div
                    class="w-8 h-4 rounded-full transition-colors duration-200
                    bg-white/10 peer-checked:bg-white/60
                    relative after:content-[''] after:absolute after:top-0.5 after:left-0.5
                    after:bg-black after:rounded-full after:h-3 after:w-3
                    after:transition-all peer-checked:after:translate-x-4">
                </div>
                <span class="text-xs text-white/40">Tampilkan Dihapus</span>
            </label>
            @if ($search || $type || $is_active !== '')
                <x-btn variant="ghost" size="sm" wire:click="resetFilters">
                    <i class="fas fa-times text-[10px]"></i> Reset
                </x-btn>
            @endif
        </div>
        {{-- Bulk Actions --}}
        @if (count($selected) > 0)
            <div class="flex items-center gap-3 mt-3 pt-3 border-t border-white/5">
                <span class="text-xs text-white/40">{{ count($selected) }} dipilih</span>
                @if ($showTrashed)
                    <x-btn variant="primary" size="sm" x-data
                        @click.prevent="
                        confirmAction({
                            title: 'Restore Kode Promo',
                            message: '{{ count($selected) }} kode promo akan dikembalikan. Lanjutkan?',
                                confirmText: 'Ya, Restore',
                                type: 'restore',
                            }).then((confirmed) => { if (confirmed) $wire.bulkRestore() })
                            ">
                        <i class="fas fa-undo text-[10px]"></i> Restore
                    </x-btn>

                    <x-btn variant="destructive" size="sm" x-data
                        @click.prevent="
                        confirmAction({
                            title: 'Hapus Permanen',
                            message: '{{ count($selected) }} kode promo akan dihapus permanen dan tidak bisa dikembalikan!',
                            confirmText: 'Ya, Hapus Permanen',
                            type: 'danger',
                        }).then((confirmed) => { if (confirmed) $wire.bulkForceDelete() })
                    ">
                        <i class="fas fa-trash text-[10px]"></i> Hapus Permanen
                    </x-btn>
                @else
                    <x-btn variant="destructive" size="sm" x-data
                        @click.prevent="
                        confirmAction({
                            title: 'Hapus Kode Promo',
                            message: '{{ count($selected) }} kode promo akan dihapus. Lanjutkan?',
                                confirmText: 'Ya, Hapus',
                                type: 'danger',
                            }).then((confirmed) => { if (confirmed) $wire.bulkDelete() })
                    ">
                        <i class="fas fa-trash text-[10px]"></i> Hapus
                    </x-btn>
                @endif

                <x-btn variant="ghost" size="sm" wire:click="clearSelection">
                    Batal Pilih
                </x-btn>
            </div>
        @endif
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="table-wrapper border-0">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-8">
                            <x-form.checkbox name="selectAll" wire:model.live="selectAll" />
                        </th>
                        <th>
                            <button wire:click="sort('code')"
                                class="flex items-center gap-1 hover:text-white transition-colors">
                                Kode
                                @if ($sortBy === 'code')
                                    <i
                                        class="fas fa-sort-{{ $sortDir === 'asc' ? 'up' : 'down' }} text-[10px] text-white"></i>
                                @else
                                    <i class="fas fa-sort text-[10px] text-white/20"></i>
                                @endif
                            </button>
                        </th>
                        <th>Tipe</th>
                        <th>
                            <button wire:click="sort('value')"
                                class="flex items-center gap-1 hover:text-white transition-colors">
                                Nilai
                                @if ($sortBy === 'value')
                                    <i
                                        class="fas fa-sort-{{ $sortDir === 'asc' ? 'up' : 'down' }} text-[10px] text-white"></i>
                                @else
                                    <i class="fas fa-sort text-[10px] text-white/20"></i>
                                @endif
                            </button>
                        </th>
                        <th>Min. Pembelian</th>
                        <th>Pemakaian</th>
                        <th>
                            <button wire:click="sort('expired_at')"
                                class="flex items-center gap-1 hover:text-white transition-colors">
                                Expired
                                @if ($sortBy === 'expired_at')
                                    <i
                                        class="fas fa-sort-{{ $sortDir === 'asc' ? 'up' : 'down' }} text-[10px] text-white"></i>
                                @else
                                    <i class="fas fa-sort text-[10px] text-white/20"></i>
                                @endif
                            </button>
                        </th>
                        <th>Status</th>
                        <th>Berlaku Untuk</th>
                        <th>Banner</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($promoCodes as $promo)
                        <tr>
                            <td>
                                <x-form.checkbox name="selected" value="{{ $promo->id }}"
                                    wire:model.live="selected" />
                            </td>
                            <td>
                                <span class="text-xs font-mono text-white/70">{{ $promo->code }}</span>
                            </td>
                            <td>
                                <x-badge>{{ $promo->type === 'percentage' ? 'Persen' : 'Fixed' }}</x-badge>
                            </td>
                            <td>
                                <span class="text-xs text-white/60">
                                    {{ $promo->type === 'percentage' ? $promo->value . '%' : 'Rp ' . number_format($promo->value, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                <span class="text-xs text-white/40">
                                    Rp {{ number_format($promo->minimum_purchase, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                <span class="text-xs text-white/40">
                                    {{ $promo->used_count }}/{{ $promo->max_usage ?? '∞' }}
                                </span>
                            </td>
                            <td>
                                @if ($promo->expired_at)
                                    <span
                                        class="text-xs {{ $promo->expired_at->isPast() ? 'text-red-400' : 'text-white/40' }}">
                                        {{ $promo->expired_at->format('d M Y') }}
                                        @if ($promo->expired_at->isPast())
                                            <span class="text-[10px]">(expired)</span>
                                        @endif
                                    </span>
                                @else
                                    <span class="text-xs text-white/40">∞</span>
                                @endif
                            </td>
                            <td>
                                <x-badge variant="{{ $promo->is_active ? 'success' : 'secondary' }}">
                                    {{ $promo->is_active ? 'Aktif' : 'Nonaktif' }}
                                </x-badge>
                            </td>

                            {{-- Berlaku Untuk --}}
                            <td>
                                <span class="text-xs text-white/40">{{ $promo->scope_label }}</span>
                            </td>

                            {{-- Banner --}}
                            <td>
                                @if ($promo->show_in_banner)
                                    <span class="inline-flex items-center gap-1 text-xs text-amber-400">
                                        <i class="fas fa-bullhorn text-[10px]"></i> Tampil
                                    </span>
                                @else
                                    <span class="text-xs text-white/20">—</span>
                                @endif
                            </td>

                            <td>
                                @if ($promo->trashed())
                                    <div class="flex items-center gap-2 justify-end">
                                        <x-btn variant="primary" size="sm" x-data
                                            @click.prevent="
                    confirmAction({
                        title: 'Restore Kode Promo',
                        message: 'Kode promo {{ addslashes($promo->title) }} akan dikembalikan. Lanjutkan?',
                        confirmText: 'Ya, Restore',
                        type: 'restore',
                    }).then((confirmed) => { if (confirmed) $wire.restore({{ $promo->id }}) })
                ">
                                            <i class="fas fa-undo text-[10px]"></i> Restore
                                        </x-btn>
                                        <x-btn variant="destructive" size="sm" x-data
                                            @click.prevent="
                    confirmAction({
                        title: 'Hapus Permanen',
                        message: 'Kode promo{{ addslashes($promo->title) }} akan dihapus permanen dan tidak bisa dikembalikan!',
                        confirmText: 'Ya, Hapus Permanen',
                        type: 'danger',
                    }).then((confirmed) => { if (confirmed) $wire.forceDelete({{ $promo->id }}) })
                ">
                                            <i class="fas fa-trash text-[10px]"></i> Hapus Permanen
                                        </x-btn>
                                    </div>
                                @else
                                    <div class="flex items-center gap-2 justify-end">

                                        @php
                                            $itemIds = $promo->items
                                                ->map(
                                                    fn($item) => (str_contains($item->promotable_type, 'Course')
                                                        ? 'course'
                                                        : 'product') .
                                                        '_' .
                                                        $item->promotable_id,
                                                )
                                                ->values()
                                                ->toArray();
                                            $editPayload = Illuminate\Support\Js::from(
                                                array_merge($promo->toArray(), ['item_ids' => $itemIds]),
                                            );
                                        @endphp

                                        <x-btn variant="ghost" size="sm"
                                            @click="editData = {{ $editPayload }}; showEdit = true">
                                            Edit
                                        </x-btn>

                                        <form action="{{ route('admin.promo-codes.destroy', $promo) }}" method="POST"
                                            x-data
                                            @submit.prevent="
                                            confirmAction({
                                                title: 'Hapus Kode Promo',
                                                message: '{{ addslashes($promo->code) }} akan dihapus. Lanjutkan?',
                                                confirmText: 'Ya, Hapus',
                                            }).then((confirmed) => { if (confirmed) $el.submit() })
                                        ">
                                            @csrf @method('DELETE')
                                            <x-btn variant="destructive" size="sm" type="submit">Hapus</x-btn>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center py-12">
                                <i class="fas fa-ticket-alt text-2xl text-white/10 mb-2 block"></i>
                                <p class="text-xs text-white/20">
                                    {{ $search || $type || $is_active !== '' ? 'Tidak ada hasil' : 'Belum ada kode promo' }}
                                </p>
                                @if ($search || $type || $is_active !== '')
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
        <div class="card-footer flex items-center justify-between">
            <p class="text-xs text-white/30">
                Menampilkan {{ $promoCodes->firstItem() ?? 0 }}–{{ $promoCodes->lastItem() ?? 0 }}
                dari {{ $promoCodes->total() }} kode promo
            </p>
            {{ $promoCodes->links() }}
        </div>
    </div>

    {{-- Loading --}}
    <div wire:loading.delay class="fixed bottom-4 right-4 z-50">
        <div
            class="bg-[#0D0D0D] border border-white/10 rounded-lg px-3 py-2 flex items-center gap-2 text-xs text-white/50">
            <i class="fas fa-spinner fa-spin text-[10px] text-white/80"></i>
            Memuat...
        </div>
    </div>
</div>
