<div>

    {{-- Filter & Search --}}
    <div class="card p-4 mb-4">
        <div class="flex flex-wrap items-center gap-3">

            {{-- Search --}}
            <div class="flex-1 min-w-48">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-white/20 text-xs"></i>
                    <x-form.input name="search" placeholder="Cari judul produk..." wire:model.live.debounce.300ms="search"
                        class="pl-8 w-full" />
                </div>
            </div>

            {{-- Filter Kategori --}}
            <x-form.select name="category_id" placeholder="Semua Kategori" wire:model.live="category_id" class="w-40">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </x-form.select>

            {{-- Filter Tipe --}}
            <x-form.select name="type" placeholder="Semua Tipe" wire:model.live="type" class="w-36"
                :options="['file' => 'File', 'license' => 'Lisensi']" />

            {{-- Filter Status --}}
            <x-form.select name="status" placeholder="Semua Status" wire:model.live="status" class="w-36"
                :options="['published' => 'Published', 'draft' => 'Draft']" />

            {{-- Per Page --}}
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

            {{-- Reset --}}
            @if ($search || $status || $type || $category_id || $showTrashed)
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
                                title: 'Restore Produk',
                                message: '{{ count($selected) }} produk akan dikembalikan. Lanjutkan?',
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
                                message: '{{ count($selected) }} produk akan dihapus permanen!',
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
                                title: 'Hapus Produk',
                                message: '{{ count($selected) }} produk akan dihapus. Lanjutkan?',
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
                            <button wire:click="sort('title')"
                                class="flex items-center gap-1 hover:text-white transition-colors">
                                Produk
                                @if ($sortBy === 'title')
                                    <i
                                        class="fas fa-sort-{{ $sortDir === 'asc' ? 'up' : 'down' }} text-[10px] text-white"></i>
                                @else
                                    <i class="fas fa-sort text-[10px] text-white/20"></i>
                                @endif
                            </button>
                        </th>
                        <th>Kategori</th>
                        <th>
                            <button wire:click="sort('type')"
                                class="flex items-center gap-1 hover:text-white transition-colors">
                                Tipe
                                @if ($sortBy === 'type')
                                    <i
                                        class="fas fa-sort-{{ $sortDir === 'asc' ? 'up' : 'down' }} text-[10px] text-white"></i>
                                @else
                                    <i class="fas fa-sort text-[10px] text-white/20"></i>
                                @endif
                            </button>
                        </th>
                        <th>
                            <button wire:click="sort('price')"
                                class="flex items-center gap-1 hover:text-white transition-colors">
                                Harga
                                @if ($sortBy === 'price')
                                    <i
                                        class="fas fa-sort-{{ $sortDir === 'asc' ? 'up' : 'down' }} text-[10px] text-white"></i>
                                @else
                                    <i class="fas fa-sort text-[10px] text-white/20"></i>
                                @endif
                            </button>
                        </th>
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
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <x-form.checkbox name="selected" value="{{ $product->id }}"
                                    wire:model.live="selected" />
                            </td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-7 bg-white/5 rounded overflow-hidden flex-shrink-0">
                                        @if ($product->thumbnail)
                                            <img src="{{ Storage::url($product->thumbnail) }}"
                                                class="w-full h-full object-cover opacity-70">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i class="fas fa-box text-[10px] text-white/20"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <span class="text-xs font-medium text-white/70 line-clamp-1">
                                        {{ $product->title }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <span class="text-xs text-white/40">{{ $product->category->name ?? '-' }}</span>
                            </td>
                            <td>
                                <x-badge>{{ $product->type === 'file' ? 'File' : 'Lisensi' }}</x-badge>
                            </td>
                            <td>
                                <span class="text-xs text-white/60">
                                    {{ $product->price == 0 ? 'Gratis' : 'Rp ' . number_format($product->price, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                <x-badge variant="{{ $product->status === 'published' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($product->status) }}
                                </x-badge>
                            </td>
                            <td>
                                <span class="text-xs text-white/30">
                                    {{ $product->created_at->format('d M Y') }}
                                </span>
                            </td>
                            <td>
                                @if ($product->trashed())
                                    <div class="flex items-center gap-2 justify-end">
                                        <x-btn variant="primary" size="sm" x-data
                                            @click.prevent="
                                                confirmAction({
                                                    title: 'Restore Produk',
                                                    message: '{{ addslashes($product->title) }} akan dikembalikan. Lanjutkan?',
                                                    confirmText: 'Ya, Restore',
                                                    type: 'restore',
                                                }).then((confirmed) => { if (confirmed) $wire.restore({{ $product->id }}) })
                                            ">
                                            <i class="fas fa-undo text-[10px]"></i> Restore
                                        </x-btn>
                                        <x-btn variant="destructive" size="sm" x-data
                                            @click.prevent="
                                                confirmAction({
                                                    title: 'Hapus Permanen',
                                                    message: '{{ addslashes($product->title) }} akan dihapus permanen!',
                                                    confirmText: 'Ya, Hapus Permanen',
                                                    type: 'danger',
                                                }).then((confirmed) => { if (confirmed) $wire.forceDelete({{ $product->id }}) })
                                            ">
                                            <i class="fas fa-trash text-[10px]"></i> Hapus Permanen
                                        </x-btn>
                                    </div>
                                @else
                                    <div class="flex items-center gap-2 justify-end">
                                        <x-btn href="{{ route('admin.products.edit', $product) }}" wire:navigate
                                            variant="ghost" size="sm">Edit</x-btn>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                            x-data
                                            @submit.prevent="
                                                confirmAction({
                                                    title: 'Hapus Produk',
                                                    message: '{{ addslashes($product->title) }} akan dihapus. Lanjutkan?',
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
                            <td colspan="8" class="text-center py-12">
                                <i class="fas fa-box text-2xl text-white/10 mb-2 block"></i>
                                <p class="text-xs text-white/20">
                                    {{ $search || $status || $type || $category_id || $showTrashed ? 'Tidak ada hasil' : 'Belum ada produk' }}
                                </p>
                                @if ($search || $status || $type || $category_id || $showTrashed)
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

        {{-- Pagination --}}
        <div class="card-footer flex items-center justify-between">
            <p class="text-xs text-white/30">
                Menampilkan {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}
                dari {{ $products->total() }} produk
            </p>
            {{ $products->links() }}
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
