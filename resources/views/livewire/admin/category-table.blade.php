<div>

    {{-- Filter & Search --}}
    <div class="card p-4 mb-4">
        <div class="flex flex-wrap items-center gap-3">
            <div class="flex-1 min-w-48">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-white/20 text-xs"></i>
                    <x-form.input name="search" placeholder="Cari nama kategori..."
                        wire:model.live.debounce.300ms="search" class="pl-8 w-full" />
                </div>
            </div>

            <x-form.select name="type" placeholder="Semua Tipe" wire:model.live="type" class="w-36"
                :options="['course' => 'Kelas', 'product' => 'Produk']" />

            <x-form.select name="perPage" wire:model.live="perPage" class="w-24" :options="[10 => '10', 25 => '25', 50 => '50']" />

            @if ($search || $type)
                <x-btn variant="ghost" size="sm" wire:click="resetFilters" class="text-white/40 hover:text-white">
                    <i class="fas fa-times text-[10px]"></i> Reset
                </x-btn>
            @endif
        </div>
        @if (count($selected) > 0)
            <div class="flex items-center gap-3 mt-3 pt-3 border-t border-white/5">
                <span class="text-xs text-white/40">{{ count($selected) }} dipilih</span>

                <x-btn variant="destructive" size="sm" x-data
                    @click.prevent="
                        confirmAction({
                            title: 'Hapus Kelas',
                            message: '{{ count($selected) }} kelas akan dihapus. Lanjutkan?',
                                confirmText: 'Ya, Hapus',
                                type: 'danger',
                            }).then((confirmed) => { if (confirmed) $wire.bulkDelete() })
                    ">
                    <i class="fas fa-trash text-[10px]"></i> Hapus
                </x-btn>

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
                        <th class="w-8" wire:key="th-selectAll-{{ $selectAll }}">
                            <x-form.checkbox name="selectAll" wire:model.live="selectAll" />
                        </th>
                        <th>
                            <button wire:click="sort('name')"
                                class="flex items-center gap-1 hover:text-white transition-colors">
                                Nama
                                @if ($sortBy === 'name')
                                    <i
                                        class="fas fa-sort-{{ $sortDir === 'asc' ? 'up' : 'down' }} text-[10px] text-white"></i>
                                @else
                                    <i class="fas fa-sort text-[10px] text-white/20"></i>
                                @endif
                            </button>
                        </th>
                        <th>Slug</th>
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
                        <th>Icon</th>
                        <th>Konten</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>
                                <x-form.checkbox name="selected" value="{{ $category->id }}" wire:model.live="selected"
                                    wire:key="selected-{{ $category->id }}" />
                            </td>
                            <td>
                                <span class="text-xs font-medium text-white/70">{{ $category->name }}</span>
                            </td>
                            <td>
                                <span class="text-xs font-mono text-white/30">{{ $category->slug }}</span>
                            </td>
                            <td>
                                <x-badge>{{ $category->type === 'course' ? 'Kelas' : 'Produk' }}</x-badge>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    @if ($category->icon)
                                        <i class="{{ $category->icon }} text-white/30 text-xs"></i>
                                        <span class="text-xs text-white/20 font-mono">{{ $category->icon }}</span>
                                    @else
                                        <span class="text-xs text-white/20">-</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="text-xs text-white/40">
                                    {{ $category->type === 'course' ? $category->courses_count . ' kelas' : $category->products_count . ' produk' }}
                                </span>
                            </td>
                            <td>
                                <div class="flex items-center gap-2 justify-end">

                                    <x-btn variant="ghost" size="sm"
                                        @click="editData = {
                                            id: {{ $category->id }},
                                            name: '{{ $category->name }}',
                                            type: '{{ $category->type }}',
                                            icon: '{{ $category->icon ?? '' }}'
                                        }; showEdit = true">
                                        Edit
                                    </x-btn>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                        x-data
                                        @submit.prevent="
                                            confirmAction({
                                                title: 'Hapus Kategori',
                                                message: '{{ addslashes($category->name) }} akan dihapus. Lanjutkan?',
                                                confirmText: 'Ya, Hapus',
                                            }).then((confirmed) => { if (confirmed) $el.submit() })
                                        ">
                                        @csrf @method('DELETE')
                                        <x-btn variant="destructive" size="sm" type="submit">Hapus</x-btn>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12">
                                <i class="fas fa-tag text-2xl text-white/10 mb-2 block"></i>
                                <p class="text-xs text-white/20">
                                    {{ $search || $type ? 'Tidak ada hasil' : 'Belum ada kategori' }}
                                </p>
                                <x-btn variant="ghost" wire:click="resetFilters" class="mt-2">
                                    Reset filter
                                </x-btn>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer flex items-center justify-between">
            <p class="text-xs text-white/30">
                Menampilkan {{ $categories->firstItem() ?? 0 }}–{{ $categories->lastItem() ?? 0 }}
                dari {{ $categories->total() }} kategori
            </p>
            {{ $categories->links() }}
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
