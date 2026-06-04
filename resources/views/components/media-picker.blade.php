@props(['name', 'label' => 'Thumbnail', 'value' => null, 'type' => 'image'])

<div x-data="{
    selected: '{{ $value ?? '' }}',
    selectedUrl: '{{ $value ? (Str::startsWith($value, 'http') ? $value : Storage::url($value)) : '' }}',
    selectedName: '',
    selectedSize: '',
    showPicker: false,

    // Picker state
    pickerItems: [],
    pickerLoading: false,
    pickerSearch: '',
    pickerSelected: null,
    pickerSelectedItem: null,
    type: '{{ $type }}',

    // Pagination
    currentPage: 1,
    lastPage: 1,
    total: 0,
    perPage: 48,

    // Mode: 'pick' | 'manage'
    mode: 'pick',

    // Bulk delete
    bulkSelected: [],

    async init() {
        if (!this.selected) return;
        const params = new URLSearchParams({ file_path: this.selected });
        const res = await fetch('/admin/media/find?' + params, {
            headers: { 'Accept': 'application/json' }
        });
        if (!res.ok) return;
        const data = await res.json();
        if (data) {
            this.selectedName = data.name ?? '';
            this.selectedSize = data.size_label ?? data.size_formatted ?? '';
        }
    },

    async openPicker() {
        this.showPicker = true;
        this.mode = 'pick';
        this.pickerSelected = null;
        this.pickerSelectedItem = null;
        this.bulkSelected = [];
        this.currentPage = 1;
        this.pickerSearch = '';
        await this.fetchMedia();
    },

    async fetchMedia(page = null) {
        this.pickerLoading = true;
        if (page !== null) this.currentPage = page;

        const params = new URLSearchParams({
            type: this.type,
            per_page: this.perPage,
            page: this.currentPage,
            ...(this.pickerSearch && { search: this.pickerSearch })
        });

        const res = await fetch('/admin/media?' + params, {
            headers: { 'Accept': 'application/json' }
        });
        const data = await res.json();
        this.pickerItems = data.data;
        this.currentPage = data.current_page;
        this.lastPage = data.last_page;
        this.total = data.total;
        this.pickerLoading = false;
    },

    confirmSelect() {
        if (!this.pickerSelectedItem) return;
        this.selected = this.pickerSelectedItem.file_path;
        this.selectedUrl = this.pickerSelectedItem.url;
        this.selectedName = this.pickerSelectedItem.name;
        this.selectedSize = this.pickerSelectedItem.size_label ?? '';
        this.showPicker = false;
    },

    async uploadAndSelect(event) {
        const file = event.target.files[0];
        if (!file) return;
        const formData = new FormData();
        formData.append('file', file);
        formData.append('_token', document.querySelector('meta[name=csrf-token]').content);
        const res = await fetch('/admin/media', { method: 'POST', body: formData });
        const data = await res.json();
        if (data.success) {
            this.selected = data.media.file_path;
            this.selectedUrl = data.media.url;
            this.selectedName = data.media.name;
            this.selectedSize = data.media.size_label ?? '';
            this.showPicker = false;
        }
    },

    clear() {
        this.selected = null;
        this.selectedUrl = null;
        this.selectedName = '';
        this.selectedSize = '';
    },

    // ── Manage mode ──────────────────────────────────────────

    switchMode(m) {
        this.mode = m;
        this.bulkSelected = [];
        this.confirmingDelete = false;
        if (m === 'pick') {
            this.pickerSelected = null;
            this.pickerSelectedItem = null;
        }
    },

    toggleBulk(id) {
        if (this.bulkSelected.includes(id)) {
            this.bulkSelected = this.bulkSelected.filter(i => i !== id);
        } else {
            this.bulkSelected.push(id);
        }
    },

    toggleSelectAll() {
        if (this.bulkSelected.length === this.pickerItems.length) {
            this.bulkSelected = [];
        } else {
            this.bulkSelected = this.pickerItems.map(i => i.id);
        }
    },

    get allSelected() {
        return this.pickerItems.length > 0 && this.bulkSelected.length === this.pickerItems.length;
    },

    async deleteSingle(id, event) {
        event.stopPropagation();
        const ok = await confirmAction({
            title: 'Hapus File',
            message: 'File ini akan dihapus permanen. Tindakan ini tidak bisa dibatalkan.',
            confirmText: 'Hapus',
            type: 'danger',
        });
        if (!ok) return;
        await this.doDelete([id]);
    },

    async deleteBulk() {
        if (this.bulkSelected.length === 0) return;
        const ok = await confirmAction({
            title: 'Hapus ' + this.bulkSelected.length + ' File',
            message: 'Semua file yang dipilih akan dihapus permanen. Tindakan ini tidak bisa dibatalkan.',
            confirmText: 'Hapus Semua',
            type: 'danger',
        });
        if (!ok) return;
        await this.doDelete(this.bulkSelected);
        this.bulkSelected = [];
    },

    async doDelete(ids) {
        const token = document.querySelector('meta[name=csrf-token]').content;
        await Promise.all(ids.map(id =>
            fetch('/admin/media/' + id, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token,
                }
            })
        ));
        // Refresh, stay on current page (fallback to prev page if empty)
        const wasLast = this.currentPage === this.lastPage;
        await this.fetchMedia();
        if (wasLast && this.pickerItems.length === 0 && this.currentPage > 1) {
            await this.fetchMedia(this.currentPage - 1);
        }
    },

    get fileIcon() {
        if (!this.selectedName) return 'fa-file';
        const ext = this.selectedName.split('.').pop().toLowerCase();
        const map = {
            zip: 'fa-file-archive',
            rar: 'fa-file-archive',
            '7z': 'fa-file-archive',
            pdf: 'fa-file-pdf',
            doc: 'fa-file-word',
            docx: 'fa-file-word',
            xls: 'fa-file-excel',
            xlsx: 'fa-file-excel',
            mp4: 'fa-file-video',
            mov: 'fa-file-video',
            avi: 'fa-file-video',
            mp3: 'fa-file-audio',
            wav: 'fa-file-audio',
        };
        return map[ext] ?? 'fa-file';
    },

    itemIcon(name) {
        if (!name) return 'fa-file';
        const ext = name.split('.').pop().toLowerCase();
        const map = {
            zip: 'fa-file-archive',
            rar: 'fa-file-archive',
            '7z': 'fa-file-archive',
            pdf: 'fa-file-pdf',
            doc: 'fa-file-word',
            docx: 'fa-file-word',
            xls: 'fa-file-excel',
            xlsx: 'fa-file-excel',
            mp4: 'fa-file-video',
            mov: 'fa-file-video',
            mp3: 'fa-file-audio',
            wav: 'fa-file-audio',
        };
        return map[ext] ?? 'fa-file';
    }
}">
    <label class="label">{{ $label }}</label>

    {{-- Preview / Trigger --}}
    <div class="border border-white/10 border-dashed rounded-xl overflow-hidden mb-2 cursor-pointer"
        @click="openPicker()">
        <template x-if="selectedUrl">
            <div>
                {{-- Image preview --}}
                <template x-if="type === 'image'">
                    <div class="relative group aspect-video">
                        <img :src="selectedUrl" class="w-full h-full object-cover opacity-80">
                        <div
                            class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                            <span class="text-xs text-white bg-white/20 px-3 py-1.5 rounded-lg backdrop-blur-sm">
                                <i class="fas fa-exchange-alt mr-1"></i> Ganti
                            </span>
                            <span @click.stop="clear()"
                                class="text-xs text-red-400 bg-red-500/20 px-3 py-1.5 rounded-lg backdrop-blur-sm">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </span>
                        </div>
                    </div>
                </template>
                {{-- File preview --}}
                <template x-if="type !== 'image'">
                    <div class="relative group flex items-center gap-3 px-4 py-3 hover:bg-white/5 transition-colors">
                        <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
                            <i :class="'fas ' + fileIcon + ' text-white/50 text-lg'"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-white truncate" x-text="selectedName"></p>
                            <p class="text-xs text-white/30" x-text="selectedSize"></p>
                        </div>
                        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="text-xs text-white bg-white/20 px-2 py-1 rounded-lg">
                                <i class="fas fa-exchange-alt mr-1"></i> Ganti
                            </span>
                            <span @click.stop="clear()" class="text-xs text-red-400 bg-red-500/20 px-2 py-1 rounded-lg">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </span>
                        </div>
                    </div>
                </template>
            </div>
        </template>
        <template x-if="!selectedUrl">
            <div class="p-8 text-center hover:bg-white/5 transition-colors">
                <i class="fas fa-{{ $type === 'image' ? 'image' : 'file' }} text-white/20 text-2xl mb-2 block"></i>
                <p class="text-xs text-white/30">Klik untuk pilih dari Media Library</p>
            </div>
        </template>
    </div>

    <input type="hidden" name="{{ $name }}" :value="selected">

    {{-- ─────────────────────────────────────────────────────────────
         MODAL PICKER
    ───────────────────────────────────────────────────────────── --}}
    <div x-show="showPicker" x-cloak x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        class="fixed inset-0 z-[300] flex items-center justify-center p-4">

        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" @click="showPicker = false"></div>

        <div class="relative w-full max-w-3xl card p-5 z-10 flex flex-col" style="max-height: 85vh;"
            x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-4 flex-shrink-0">
                <div class="flex items-center gap-3">
                    <p class="text-sm font-semibold text-white">Media Library</p>
                    <span class="text-xs text-white/30" x-text="'(' + total + ' file)'"></span>
                </div>
                <div class="flex items-center gap-2">
                    {{-- Mode toggle --}}
                    <div class="flex items-center bg-white/5 rounded-lg p-0.5 text-xs">
                        <button type="button" @click="switchMode('pick')"
                            :class="mode === 'pick' ? 'bg-white/10 text-white' : 'text-white/30 hover:text-white'"
                            class="px-3 py-1.5 rounded-md transition-all">
                            <i class="fas fa-hand-pointer mr-1"></i> Pilih
                        </button>
                        <button type="button" @click="switchMode('manage')"
                            :class="mode === 'manage' ? 'bg-white/10 text-white' : 'text-white/30 hover:text-white'"
                            class="px-3 py-1.5 rounded-md transition-all">
                            <i class="fas fa-cog mr-1"></i> Kelola
                        </button>
                    </div>
                    <label class="btn-outline btn-sm btn cursor-pointer">
                        <i class="fas fa-upload text-[10px]"></i> Upload
                        <input type="file" class="hidden" :accept="type === 'image' ? 'image/*' : '*'"
                            @change="uploadAndSelect($event)">
                    </label>
                    <button type="button" @click="showPicker = false"
                        class="p-1 rounded-md text-white/30 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
            </div>

            {{-- Search --}}
            <input type="text" x-model="pickerSearch" placeholder="Cari file..." class="input mb-3 flex-shrink-0"
                @input.debounce.300ms="fetchMedia(1)">

            {{-- Manage toolbar --}}
            <div x-show="mode === 'manage'"
                class="flex items-center justify-between mb-3 flex-shrink-0 bg-white/5 rounded-lg px-3 py-2">
                <div class="flex items-center gap-3">
                    <label
                        class="flex items-center gap-2 cursor-pointer text-xs text-white/60 hover:text-white transition-colors">
                        <div class="relative">
                            <input type="checkbox" class="sr-only" :checked="allSelected" @change="toggleSelectAll()">
                            <div class="w-4 h-4 rounded border transition-all"
                                :class="allSelected ? 'bg-white border-white' : 'border-white/20 bg-transparent'">
                                <i x-show="allSelected"
                                    class="fas fa-check text-black text-[8px] absolute inset-0 flex items-center justify-center"
                                    style="display:flex"></i>
                            </div>
                        </div>
                        Pilih semua
                    </label>
                    <span x-show="bulkSelected.length > 0" class="text-xs text-white/40"
                        x-text="bulkSelected.length + ' dipilih'"></span>
                </div>
                <button type="button" @click="deleteBulk()" x-show="bulkSelected.length > 0"
                    class="btn-sm btn text-xs text-red-400 bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 transition-colors">
                    <i class="fas fa-trash mr-1"></i>
                    Hapus <span x-text="bulkSelected.length"></span> File
                </button>
            </div>

            {{-- Grid --}}
            <div class="overflow-y-auto flex-1 min-h-0">
                <template x-if="pickerLoading">
                    <div class="text-center py-12">
                        <i class="fas fa-spinner fa-spin text-white/20"></i>
                    </div>
                </template>
                <template x-if="!pickerLoading">
                    <div>
                        <div class="grid grid-cols-4 sm:grid-cols-5 md:grid-cols-6 gap-2">
                            <template x-for="item in pickerItems" :key="item.id">
                                <div class="relative card overflow-hidden cursor-pointer transition-all group"
                                    :class="{
                                        'border-white': mode === 'pick' && pickerSelected === item.id,
                                        'border-white': mode === 'manage' && bulkSelected.includes(item.id),
                                        'hover:border-white/30': mode === 'pick' && pickerSelected !== item.id,
                                        'hover:border-white/20': mode === 'manage' && !bulkSelected.includes(item
                                            .id),
                                    }"
                                    @click="mode === 'pick'
                                        ? (pickerSelected = item.id, pickerSelectedItem = item)
                                        : toggleBulk(item.id)">

                                    <div class="aspect-square bg-white/5">
                                        {{-- Image --}}
                                        <template x-if="item.type === 'image'">
                                            <img :src="item.url" :alt="item.name"
                                                class="w-full h-full object-cover opacity-70 hover:opacity-100 transition-opacity">
                                        </template>
                                        {{-- File --}}
                                        <template x-if="item.type !== 'image'">
                                            <div
                                                class="w-full h-full flex flex-col items-center justify-center gap-1 p-2">
                                                <i
                                                    :class="'fas ' + itemIcon(item.name) + ' text-white/20 text-2xl'"></i>
                                                <span class="text-[9px] text-white/20 truncate w-full text-center"
                                                    x-text="item.name.split('.').pop().toUpperCase()"></span>
                                            </div>
                                        </template>
                                    </div>

                                    {{-- Pick mode: check indicator --}}
                                    <div x-show="mode === 'pick' && pickerSelected === item.id"
                                        class="absolute top-1 right-1 w-5 h-5 bg-white rounded-full flex items-center justify-center shadow">
                                        <i class="fas fa-check text-black text-[10px]"></i>
                                    </div>

                                    {{-- Manage mode: checkbox --}}
                                    <div x-show="mode === 'manage'"
                                        class="absolute top-1 left-1 w-5 h-5 rounded border transition-all"
                                        :class="bulkSelected.includes(item.id) ?
                                            'bg-white border-white' :
                                            'bg-black/40 border-white/20 opacity-0 group-hover:opacity-100'">
                                        <i x-show="bulkSelected.includes(item.id)"
                                            class="fas fa-check text-black text-[8px] flex items-center justify-center w-full h-full"></i>
                                    </div>

                                    {{-- Manage mode: single delete button --}}
                                    <button type="button"
                                        x-show="mode === 'manage' && !bulkSelected.includes(item.id)"
                                        @click.stop="deleteSingle(item.id, $event)"
                                        class="absolute bottom-1 right-1 w-6 h-6 rounded bg-red-500/80 text-white opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center z-10">
                                        <i class="fas fa-trash text-[9px]"></i>
                                    </button>

                                    {{-- File name tooltip on hover --}}
                                    <div
                                        class="absolute bottom-0 left-0 right-0 bg-black/60 px-1.5 py-1
                                        opacity-0 group-hover:opacity-100 transition-opacity">
                                        <p class="text-[9px] text-white/70 truncate" x-text="item.name"></p>
                                        <p class="text-[9px] text-white/30"
                                            x-text="item.size_label ?? item.size_formatted"></p>
                                    </div>
                                </div>
                            </template>

                            <template x-if="pickerItems.length === 0">
                                <div class="col-span-6 text-center py-12">
                                    <i class="fas fa-image text-white/10 text-2xl mb-2 block"></i>
                                    <p class="text-xs text-white/20">Belum ada file</p>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-between mt-4 pt-4 border-t border-white/5 flex-shrink-0">

                {{-- Pagination --}}
                <div class="flex items-center gap-1">
                    <button type="button" @click="fetchMedia(1)" :disabled="currentPage === 1"
                        class="w-7 h-7 flex items-center justify-center rounded-md text-white/40 hover:text-white hover:bg-white/5 transition-colors disabled:opacity-20 disabled:cursor-not-allowed">
                        <i class="fas fa-angle-double-left text-xs"></i>
                    </button>
                    <button type="button" @click="fetchMedia(currentPage - 1)" :disabled="currentPage === 1"
                        class="w-7 h-7 flex items-center justify-center rounded-md text-white/40 hover:text-white hover:bg-white/5 transition-colors disabled:opacity-20 disabled:cursor-not-allowed">
                        <i class="fas fa-angle-left text-xs"></i>
                    </button>

                    <span class="text-xs text-white/30 px-2" x-text="'Hal. ' + currentPage + ' / ' + lastPage"></span>

                    <button type="button" @click="fetchMedia(currentPage + 1)" :disabled="currentPage === lastPage"
                        class="w-7 h-7 flex items-center justify-center rounded-md text-white/40 hover:text-white hover:bg-white/5 transition-colors disabled:opacity-20 disabled:cursor-not-allowed">
                        <i class="fas fa-angle-right text-xs"></i>
                    </button>
                    <button type="button" @click="fetchMedia(lastPage)" :disabled="currentPage === lastPage"
                        class="w-7 h-7 flex items-center justify-center rounded-md text-white/40 hover:text-white hover:bg-white/5 transition-colors disabled:opacity-20 disabled:cursor-not-allowed">
                        <i class="fas fa-angle-double-right text-xs"></i>
                    </button>
                </div>

                {{-- Action buttons --}}
                <div class="flex gap-2">
                    <template x-if="mode === 'pick'">
                        <div class="flex gap-2">
                            <p class="text-xs text-white/30 self-center"
                                x-text="pickerSelected ? '1 file dipilih' : 'Belum ada yang dipilih'"></p>
                            <button type="button" @click="showPicker = false"
                                class="btn-outline btn-sm btn">Batal</button>
                            <button type="button" @click="confirmSelect()" :disabled="!pickerSelected"
                                class="btn-primary btn-sm btn"
                                :class="{ 'opacity-30 cursor-not-allowed': !pickerSelected }">
                                Pilih
                            </button>
                        </div>
                    </template>
                    <template x-if="mode === 'manage'">
                        <div class="flex gap-2">
                            <p class="text-xs text-white/30 self-center"
                                x-text="bulkSelected.length + ' file dipilih'"></p>
                            <button type="button" @click="showPicker = false"
                                class="btn-outline btn-sm btn">Tutup</button>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

</div>
