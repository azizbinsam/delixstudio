<div x-data="searchModal" x-cloak>

    {{-- Overlay --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[500] bg-black/70 backdrop-blur-sm" @click="close()">
    </div>

    {{-- Modal --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
        class="fixed top-[15%] left-1/2 -translate-x-1/2 z-[510] w-full max-w-xl px-4">

        <div class="bg-[#0D0D0D] border border-white/10 rounded-2xl shadow-2xl overflow-hidden">

            {{-- Input --}}
            <div class="flex items-center gap-3 px-4 py-3 border-b border-white/5">
                <i class="fas fa-search text-xs text-white/80 flex-shrink-0"></i>
                <input type="text" x-ref="input" x-model="query" @input.debounce.300ms="search()"
                    placeholder="Cari produk, kelas..."
                    class="flex-1 bg-transparent text-sm text-white placeholder-white/20 outline-none">
                <template x-if="loading">
                    <i class="fas fa-spinner fa-spin text-xs text-white/80 flex-shrink-0"></i>
                </template>
                <template x-if="!loading">
                    <kbd
                        class="text-[9px] text-white/80 border border-white/10 rounded px-1.5 py-0.5 font-sans flex-shrink-0">Esc</kbd>
                </template>
            </div>

            {{-- Results --}}
            <div x-ref="resultList" class="max-h-96 overflow-y-auto">

                {{-- Empty query — tampilkan hint --}}
                <template x-if="query.trim().length < 2 && !loading">
                    <div class="px-4 py-8 text-center">
                        <i class="fas fa-search text-white/10 text-2xl mb-3 block"></i>
                        <p class="text-xs text-white/40">Ketik minimal 2 karakter untuk mulai mencari</p>
                    </div>
                </template>

                {{-- No results --}}
                <template x-if="query.trim().length >= 2 && !loading && !hasResults">
                    <div class="px-4 py-8 text-center">
                        <i class="fas fa-inbox text-white/10 text-2xl mb-3 block"></i>
                        <p class="text-xs text-white/40">Tidak ada hasil untuk "<span x-text="query"
                                class="text-white/80"></span>"</p>
                    </div>
                </template>

                {{-- Grouped results --}}
                <template x-if="hasResults">
                    <div class="py-2">
                        <template x-for="(items, group) in results" :key="group">
                            <template x-if="items.length > 0">
                                <div class="mb-1">
                                    {{-- Group label --}}
                                    <p class="px-4 py-1.5 text-[10px] font-medium text-white/20 uppercase tracking-widest"
                                        x-text="group"></p>

                                    {{-- Items --}}
                                    <template x-for="(item, itemIndex) in items" :key="item.id">
                                        <a :href="item.url"
                                            :data-active="globalIndex(group, itemIndex) === activeIndex"
                                            class="flex items-center gap-3 px-4 py-2.5 transition-colors"
                                            :class="globalIndex(group, itemIndex) === activeIndex ?
                                                'bg-white/10 text-white' :
                                                'text-white/60 hover:bg-white/5 hover:text-white'"
                                            @mouseenter="activeIndex = globalIndex(group, itemIndex)">

                                            {{-- Icon --}}
                                            <div
                                                class="w-8 h-8 rounded-md bg-white/5 flex items-center justify-center flex-shrink-0 overflow-hidden">
                                                <template x-if="item.thumbnail">
                                                    <img :src="item.thumbnail"
                                                        class="w-full h-full object-cover opacity-70">
                                                </template>
                                                <template x-if="!item.thumbnail">
                                                    <i :class="'fas ' + item.icon + ' text-white/20 text-xs'"></i>
                                                </template>
                                            </div>

                                            {{-- Text --}}
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-medium truncate" x-text="item.title"></p>
                                                <p class="text-[11px] text-white/30 truncate" x-text="item.subtitle">
                                                </p>
                                            </div>

                                            {{-- Arrow indicator --}}
                                            <i class="fas fa-arrow-right text-[10px] text-white/10 flex-shrink-0 transition-opacity"
                                                :class="globalIndex(group, itemIndex) === activeIndex ? 'opacity-100' :
                                                    'opacity-0'"></i>
                                        </a>
                                    </template>
                                </div>
                            </template>
                        </template>
                    </div>
                </template>
            </div>

            {{-- Footer --}}
            <div class="px-4 py-2.5 border-t border-white/5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="flex items-center gap-1 text-[10px] text-white/40">
                        <kbd class="border border-white/10 rounded px-1 py-0.5 font-sans">↑</kbd>
                        <kbd class="border border-white/10 rounded px-1 py-0.5 font-sans">↓</kbd>
                        navigasi
                    </span>
                    <span class="flex items-center gap-1 text-[10px] text-white/40">
                        <kbd class="border border-white/10 rounded px-1 py-0.5 font-sans">↵</kbd>
                        buka
                    </span>
                </div>
                <template x-if="hasResults">
                    <p class="text-[10px] text-white/40" x-text="totalResults + ' hasil ditemukan'"></p>
                </template>
            </div>
        </div>
    </div>
</div>
