<div>
    {{-- Filter & Search --}}
    <div class="card p-4 mb-4">
        <div class="flex flex-wrap items-center gap-3">

            {{-- Search --}}
            <div class="flex-1 min-w-48">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-white/20 text-xs"></i>
                    <x-form.input name="search" placeholder="Cari nam, email, atau nomor HP..."
                        wire:model.live.debounce.300ms="search" class="pl-8 w-full" />
                </div>
            </div>

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
            @if ($search)
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
                            title: 'Restore User',
                            message: '{{ count($selected) }} user akan dikembalikan. Lanjutkan?',
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
                            message: 'User {{ count($selected) }} akan dihapus permanen dan tidak bisa dikembalikan!',
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
                            title: 'Hapus User',
                            message: 'User {{ count($selected) }} akan dihapus. Lanjutkan?',
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
                        {{-- Checkbox All --}}
                        <th class="w-8">
                            <x-form.checkbox name="selectAll" wire:model.live="selectAll" />
                        </th>
                        <th>
                            <button wire:click="sort('name')"
                                class="flex items-center gap-1 hover:text-white transition-colors">
                                User
                                @if ($sortBy === 'name')
                                    <i
                                        class="fas fa-sort-{{ $sortDir === 'asc' ? 'up' : 'down' }} text-[10px] text-white"></i>
                                @else
                                    <i class="fas fa-sort text-[10px] text-white/20"></i>
                                @endif
                            </button>
                        </th>
                        <th>
                            <button wire:click="sort('email')"
                                class="flex items-center gap-1 hover:text-white transition-colors">
                                Email
                                @if ($sortBy === 'email')
                                    <i
                                        class="fas fa-sort-{{ $sortDir === 'asc' ? 'up' : 'down' }} text-[10px] text-white"></i>
                                @else
                                    <i class="fas fa-sort text-[10px] text-white/20"></i>
                                @endif
                            </button>
                        </th>
                        <th>Phone</th>
                        <th>
                            <button wire:click="sort('orders_count')"
                                class="flex items-center gap-1 hover:text-white transition-colors">
                                Pesanan
                                @if ($sortBy === 'orders_count')
                                    <i
                                        class="fas fa-sort-{{ $sortDir === 'asc' ? 'up' : 'down' }} text-[10px] text-white"></i>
                                @else
                                    <i class="fas fa-sort text-[10px] text-white/20"></i>
                                @endif
                            </button>
                        </th>
                        <th>
                            <button wire:click="sort('total_spending')"
                                class="flex items-center gap-1 hover:text-white transition-colors">
                                Total Belanja
                                @if ($sortBy === 'total_spending')
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
                                Bergabung
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
                    @forelse($users as $user)
                        <tr>
                            <td>
                                @if (!$user->is_admin)
                                    <x-form.checkbox name="selected" value="{{ $user->id }}"
                                        wire:model.live="selected" />
                                @endif
                            </td>
                            <td>
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-7 h-7 rounded-full bg-white/10 flex items-center justify-center flex-shrink-0 overflow-hidden">
                                        @if ($user->avatar)
                                            <img src="{{ Storage::url($user->avatar) }}"
                                                class="w-full h-full object-cover rounded-full">
                                        @else
                                            <span class="text-[11px] text-white/50 font-medium">
                                                {{ substr($user->name, 0, 1) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="text-xs font-medium text-white/70">{{ $user->name }}</span>
                                        @if ($user->is_admin)
                                            <span class="badge badge-warning ml-1.5">
                                                <i class="fas fa-shield-halved text-[9px]"></i> Admin
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-xs text-white/40">{{ $user->email }}</span>
                            </td>
                            <td>
                                <span class="text-xs text-white/40">{{ $user->phone ?? '-' }}</span>
                            </td>
                            <td>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs text-white/60">{{ $user->orders_count }}</span>
                                    @if ($user->paid_orders_count > 0)
                                        <span class="text-[11px] text-white/30">
                                            ({{ $user->paid_orders_count }} paid)
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="text-xs text-white/60">
                                    {{ $user->total_spending ? 'Rp ' . number_format($user->total_spending, 0, ',', '.') : '-' }}
                                </span>
                            </td>
                            <td>
                                <span class="text-xs text-white/30">
                                    {{ $user->created_at->format('d M Y') }}
                                </span>
                            </td>
                            <td>
                                @if ($user->trashed())
                                    <div class="flex items-center gap-2 justify-end">
                                        <x-btn variant="primary" size="sm" x-data
                                            @click.prevent="
                    confirmAction({
                        title: 'Restore User',
                        message: 'User {{ addslashes($user->name) }} akan dikembalikan. Lanjutkan?',
                        confirmText: 'Ya, Restore',
                        type: 'restore',
                    }).then((confirmed) => { if (confirmed) $wire.restore({{ $user->id }}) })
                ">
                                            <i class="fas fa-undo text-[10px]"></i> Restore
                                        </x-btn>
                                        <x-btn variant="destructive" size="sm" x-data
                                            @click.prevent="
                    confirmAction({
                        title: 'Hapus Permanen',
                        message: 'User {{ addslashes($user->title) }} akan dihapus permanen dan tidak bisa dikembalikan!',
                        confirmText: 'Ya, Hapus Permanen',
                        type: 'danger',
                    }).then((confirmed) => { if (confirmed) $wire.forceDelete({{ $user->id }}) })
                ">
                                            <i class="fas fa-trash text-[10px]"></i> Hapus Permanen
                                        </x-btn>
                                    </div>
                                @else
                                    <div class="flex items-center gap-2 justify-end">
                                        <x-btn variant="ghost" size="sm"
                                            href="{{ route('admin.users.show', $user) }}" wire:navigate>
                                            Detail
                                        </x-btn>

                                        {{-- Promote / Demote --}}
                                        @if (Auth::user()->email === env('ADMIN_EMAIL', 'admin@delixstudio.com'))
                                            @if (!$user->is_admin)
                                                <x-btn variant="secondary" size="sm" x-data="{ id: {{ $user->id }} }"
                                                    @click="
            confirmAction({
                title: 'Jadikan Admin',
                message: '{{ addslashes($user->name) }} akan dijadikan admin. Lanjutkan?',
                confirmText: 'Ya, Promote',
                type: 'info',
            }).then(ok => ok && $wire.promote(id))
        ">
                                                    <i class="fas fa-shield-halved text-[10px]"></i> Promote
                                                </x-btn>
                                            @elseif ($user->id !== Auth::id())
                                                <x-btn variant="outline" size="sm" x-data="{ id: {{ $user->id }} }"
                                                    @click="
            confirmAction({
                title: 'Cabut Akses Admin',
                message: '{{ addslashes($user->name) }} akan dicabut aksesnya. Lanjutkan?',
                confirmText: 'Ya, Demote',
                type: 'danger',
            }).then(ok => ok && $wire.demote(id))
        ">
                                                    <i class="fas fa-shield text-[10px]"></i> Demote
                                                </x-btn>
                                            @endif
                                        @endif
                                        {{-- Hapus — tidak bisa hapus admin --}}
                                        @if (!$user->is_admin)
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                x-data
                                                @submit.prevent="
                    confirmAction({
                        title: 'Hapus User',
                        message: '{{ addslashes($user->name) }} akan dihapus. Lanjutkan?',
                        confirmText: 'Ya, Hapus',
                    }).then((confirmed) => { if (confirmed) $el.submit() })
                ">
                                                @csrf @method('DELETE')
                                                <x-btn variant="destructive" size="sm"
                                                    type="submit">Hapus</x-btn>
                                            </form>
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12">
                                <i class="fas fa-users text-2xl text-white/10 mb-2 block"></i>
                                <p class="text-xs text-white/20">
                                    {{ $search ? 'Tidak ada hasil untuk "' . $search . '"' : 'Belum ada user' }}
                                </p>
                                @if ($search)
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
                Menampilkan {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }}
                dari {{ $users->total() }} user
            </p>
            {{ $users->links() }}
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
