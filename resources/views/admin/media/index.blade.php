@extends('layouts.admin')

@section('title', 'Media Library')

@section('content')

    {{-- Toast Notification --}}
    <div x-data="toastNotif()" @toast.window="show($event.detail)" class="mb-4 flex flex-col gap-2 pointer-events-none">
        <template x-for="(toast, i) in toasts" :key="toast.id">
            <div x-show="toast.visible" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 translate-x-4"
                :class="toast.type === 'success' ? 'alert-success' : 'alert-error'" class="pointer-events-auto w-full">
                <i :class="toast.type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle'"
                    class="text-xs flex-shrink-0"></i>
                <span x-text="toast.message"></span>
            </div>
        </template>
    </div>

    {{-- Media Library --}}
    <div x-data="mediaLibrary()" x-init="init()">

        <div class="page-header">
            <div>
                <h1 class="page-title">Media Library</h1>
                <p class="page-desc">Kelola semua file yang telah diupload</p>
            </div>
            <x-btn variant="primary" @click="showUpload = true">
                <i class="fas fa-upload"></i> Upload File
            </x-btn>
        </div>

        {{-- Filter & Search --}}
        <div class="flex items-center gap-3 mb-5">
            <div class="flex items-center gap-1.5">
                <button @click="filterType = ''" :class="filterType === '' ? 'bg-white text-black' : 'btn-outline'"
                    class="btn">Semua</button>
                <button @click="filterType = 'image'"
                    :class="filterType === 'image' ? 'bg-white text-black' : 'btn-outline'"
                    class="btn">Gambar</button>
                <button @click="filterType = 'file'"
                    :class="filterType === 'file' ? 'bg-white text-black' : 'btn-outline'" class="btn">File</button>
            </div>
            <input type="text" x-model="search" placeholder="Cari file..." class="input max-w-xs"
                @input.debounce.300ms="fetchMedia()">

            {{-- Select All --}}
            <div class="ml-auto flex items-center gap-2" x-show="mediaItems.length > 0">
                <x-btn variant="outline" @click="toggleSelectAll()" class="flex items-center gap-1.5">
                    <div class="w-3.5 h-3.5 rounded border flex items-center justify-center transition-colors"
                        :class="isAllSelected() ? 'bg-white border-white' : 'border-white/40'">
                        <i class="fas fa-check text-[8px] text-black" x-show="isAllSelected()"></i>
                    </div>
                    <span class="text-xs">Pilih Semua</span>
                </x-btn>
            </div>
        </div>

        {{-- Bulk Action Bar --}}
        <div x-show="selectedIds.length > 0" x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="flex items-center justify-between bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 mb-4"
            style="display: none;">
            <p class="text-xs text-white/50">
                <span class="text-white font-medium" x-text="selectedIds.length"></span> file dipilih
            </p>
            <div class="flex items-center gap-2">
                <x-btn variant="outline" size="sm" @click="selectedIds = []">
                    Batal
                </x-btn>
                <button @click="bulkDelete()" :disabled="deleting"
                    class="btn btn-sm bg-red-500/20 text-red-400 border border-red-500/30 hover:bg-red-500/30 transition-colors disabled:opacity-50">
                    <template x-if="deleting">
                        <span><i class="fas fa-spinner fa-spin text-[10px] mr-1"></i> Menghapus...</span>
                    </template>
                    <template x-if="!deleting">
                        <span><i class="fas fa-trash text-[10px] mr-1"></i> Hapus <span x-text="selectedIds.length"></span>
                            File</span>
                    </template>
                </button>
            </div>
        </div>

        {{-- Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
            <template x-for="item in mediaItems" :key="item.id">
                <div class="group relative card overflow-hidden cursor-pointer" @click="toggleSelect(item)">

                    {{-- Checkbox --}}
                    <div class="absolute top-1.5 left-1.5 z-10 transition-opacity"
                        :class="selectedIds.includes(item.id) ? 'opacity-100' : 'opacity-0 group-hover:opacity-100'">
                        <div class="w-5 h-5 rounded-md border flex items-center justify-center transition-colors"
                            :class="selectedIds.includes(item.id) ?
                                'bg-white border-white' :
                                'border-white/40 bg-black/50 backdrop-blur-sm'">
                            <i class="fas fa-check text-[9px] text-black" x-show="selectedIds.includes(item.id)"></i>
                        </div>
                    </div>

                    {{-- Preview --}}
                    <div class="aspect-square bg-white/5 overflow-hidden">
                        <template x-if="item.type === 'image'">
                            <img :src="item.url" :alt="item.name"
                                class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity">
                        </template>
                        <template x-if="item.type !== 'image'">
                            <div class="w-full h-full flex flex-col items-center justify-center gap-1">
                                <i class="fas fa-file text-white/20 text-2xl"></i>
                                <span class="text-[10px] text-white/30 uppercase"
                                    x-text="item.file_name.split('.').pop()"></span>
                            </div>
                        </template>
                    </div>

                    {{-- Info --}}
                    <div class="p-2">
                        <p class="text-[11px] text-white/50 truncate" x-text="item.name"></p>
                        <p class="text-[10px] text-white/25" x-text="item.size_formatted"></p>
                    </div>

                    {{-- Action Buttons --}}
                    <div
                        class="absolute top-1.5 right-1.5 flex flex-col gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        {{-- Download --}}
                        <a :href="`/admin/media/${item.id}/download`" @click.stop title="Download"
                            class="w-6 h-6 bg-black/60 rounded-md text-white/40 hover:text-blue-400 transition-colors flex items-center justify-center">
                            <i class="fas fa-download text-[10px]"></i>
                        </a>
                        {{-- Delete --}}
                        <button @click.stop="deleteSingle(item)" :disabled="deleting" title="Hapus"
                            class="w-6 h-6 bg-black/60 rounded-md text-white/40 hover:text-red-400 transition-colors flex items-center justify-center disabled:opacity-30">
                            <i :class="deleting ? 'fas fa-spinner fa-spin' : 'fas fa-trash'" class="text-[10px]"></i>
                        </button>
                    </div>

                    {{-- Selected Border --}}
                    <div x-show="selectedIds.includes(item.id)"
                        class="absolute inset-0 border-2 border-white rounded-xl pointer-events-none"></div>
                </div>
            </template>

            {{-- Empty --}}
            <template x-if="mediaItems.length === 0 && !loading">
                <div class="col-span-6 text-center py-16 border border-white/5 rounded-xl">
                    <i class="fas fa-photo-video text-3xl text-white/10 mb-2 block"></i>
                    <p class="text-xs text-white/30">Belum ada file</p>
                </div>
            </template>

            {{-- Loading --}}
            <template x-if="loading">
                <div class="col-span-6 text-center py-16">
                    <i class="fas fa-spinner fa-spin text-white/20 text-xl"></i>
                    <p class="text-xs text-white/20 mt-2">Memuat...</p>
                </div>
            </template>
        </div>

        {{-- Pagination --}}
        <div class="flex items-center justify-between mt-5">
            <p class="text-xs text-white/30" x-text="`${pagination.total} file`"></p>
            <div class="flex items-center gap-1">
                <button @click="prevPage()" :disabled="pagination.current_page <= 1" class="btn-outline btn-sm btn"
                    :class="{ 'opacity-30': pagination.current_page <= 1 }">
                    <i class="fas fa-chevron-left text-[10px]"></i>
                </button>
                <span class="text-xs text-white/40 px-2"
                    x-text="`${pagination.current_page} / ${pagination.last_page}`"></span>
                <button @click="nextPage()" :disabled="pagination.current_page >= pagination.last_page"
                    class="btn-outline btn-sm btn"
                    :class="{ 'opacity-30': pagination.current_page >= pagination.last_page }">
                    <i class="fas fa-chevron-right text-[10px]"></i>
                </button>
            </div>
        </div>

        {{-- Modal Upload --}}
        <div x-show="showUpload" x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-[200] flex items-center justify-center p-4"
            style="display: none;">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="showUpload = false"></div>
            <div class="relative w-full max-w-md card p-6 z-10" x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">

                <div class="flex items-center justify-between mb-5">
                    <p class="text-sm font-semibold text-white">Upload File</p>
                    <button @click="showUpload = false"
                        class="p-1 rounded-md text-white/30 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>

                {{-- Drop Zone --}}
                <div class="border border-white/10 border-dashed rounded-xl p-8 text-center transition-colors"
                    :class="isDragging ? 'border-white/40 bg-white/5' : 'hover:border-white/20'"
                    @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false"
                    @drop.prevent="handleDrop($event)" @click="$refs.fileInput.click()">

                    <template x-if="!uploading">
                        <div>
                            <i class="fas fa-cloud-upload-alt text-3xl text-white/20 mb-2 block"></i>
                            <p class="text-xs text-white/40">Drag & drop atau klik untuk upload</p>
                            <p class="text-[11px] text-white/20 mt-1">Semua tipe file, maks. 50MB</p>
                        </div>
                    </template>

                    <template x-if="uploading">
                        <div>
                            <i class="fas fa-spinner fa-spin text-2xl text-white/40 mb-2 block"></i>
                            <p class="text-xs text-white/40">Mengupload...</p>
                            <div class="mt-3 h-1 bg-white/10 rounded-full overflow-hidden">
                                <div class="h-full bg-white/40 rounded-full transition-all"
                                    :style="`width: ${uploadProgress}%`"></div>
                            </div>
                            <p class="text-[11px] text-white/30 mt-2" x-text="`${Math.round(uploadProgress)}%`"></p>
                        </div>
                    </template>
                </div>

                <input type="file" class="hidden" x-ref="fileInput" multiple
                    @change="handleFiles($event.target.files)">

                {{-- Upload Queue --}}
                <template x-if="uploadQueue.length > 0">
                    <div class="mt-4 space-y-2">
                        <template x-for="(item, index) in uploadQueue" :key="index">
                            <div class="flex items-center gap-2 text-xs">
                                <i class="fas fa-file text-white/20 flex-shrink-0"></i>
                                <span class="text-white/50 truncate flex-1" x-text="item.name"></span>
                                <span class="text-white/25" x-text="formatSize(item.size)"></span>
                            </div>
                        </template>
                        <button @click="uploadFiles()" :disabled="uploading"
                            class="w-full btn-primary btn mt-3 disabled:opacity-50">
                            <template x-if="uploading">
                                <span><i class="fas fa-spinner fa-spin mr-1"></i> Mengupload...</span>
                            </template>
                            <template x-if="!uploading">
                                <span>Upload <span x-text="uploadQueue.length"></span> File</span>
                            </template>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // ─── Toast Notification ───────────────────────────────────────────────────────
            if (typeof toastNotif === 'undefined') {
                function toastNotif() {
                    return {
                        toasts: [],
                        show(detail) {
                            const id = Date.now();
                            this.toasts.push({
                                id,
                                message: detail.message,
                                type: detail.type ?? 'success',
                                visible: true
                            });
                            setTimeout(() => {
                                const t = this.toasts.find(t => t.id === id);
                                if (t) t.visible = false;
                                setTimeout(() => {
                                    this.toasts = this.toasts.filter(t => t.id !== id);
                                }, 200);
                            }, 3500);
                        }
                    }
                }

                function toast(message, type = 'success') {
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: {
                            message,
                            type
                        }
                    }));
                }
            }

            // ─── Confirm Dialog ───────────────────────────────────────────────────────────
            if (typeof confirmAction === 'undefined') {
                function confirmAction(options) {
                    return new Promise((resolve) => {
                        window.dispatchEvent(new CustomEvent('confirm', {
                            detail: {
                                ...options,
                                callback: resolve
                            }
                        }));
                    });
                }
            }

            // ─── Media Library ────────────────────────────────────────────────────────────
            function mediaLibrary() {
                return {
                    mediaItems: [],
                    loading: false,
                    deleting: false,
                    showUpload: false,
                    uploading: false,
                    uploadProgress: 0,
                    uploadQueue: [],
                    isDragging: false,
                    filterType: '',
                    search: '',
                    selectedIds: [],
                    pagination: {
                        current_page: 1,
                        last_page: 1,
                        total: 0,
                    },

                    init() {
                        this.fetchMedia();
                        this.$watch('filterType', () => {
                            this.pagination.current_page = 1;
                            this.selectedIds = [];
                            this.fetchMedia();
                        });
                    },

                    async fetchMedia() {
                        this.loading = true;
                        const params = new URLSearchParams({
                            page: this.pagination.current_page,
                            ...(this.filterType && {
                                type: this.filterType
                            }),
                            ...(this.search && {
                                search: this.search
                            }),
                        });

                        try {
                            const res = await fetch(`/admin/media?${params}`, {
                                headers: {
                                    'Accept': 'application/json'
                                }
                            });
                            const data = await res.json();
                            this.mediaItems = data.data;
                            this.pagination = {
                                current_page: data.current_page,
                                last_page: data.last_page,
                                total: data.total,
                            };
                        } catch (e) {
                            toast('Gagal memuat data', 'error');
                        } finally {
                            this.loading = false;
                        }
                    },

                    toggleSelect(item) {
                        const idx = this.selectedIds.indexOf(item.id);
                        if (idx === -1) {
                            this.selectedIds.push(item.id);
                        } else {
                            this.selectedIds.splice(idx, 1);
                        }
                    },

                    isAllSelected() {
                        return this.mediaItems.length > 0 &&
                            this.mediaItems.every(item => this.selectedIds.includes(item.id));
                    },

                    toggleSelectAll() {
                        if (this.isAllSelected()) {
                            const pageIds = this.mediaItems.map(i => i.id);
                            this.selectedIds = this.selectedIds.filter(id => !pageIds.includes(id));
                        } else {
                            this.mediaItems.forEach(item => {
                                if (!this.selectedIds.includes(item.id)) {
                                    this.selectedIds.push(item.id);
                                }
                            });
                        }
                    },

                    async deleteSingle(item) {
                        const ok = await confirmAction({
                            title: 'Hapus File',
                            message: `File "${item.name}" akan dihapus permanen.`,
                            confirmText: 'Hapus',
                            type: 'danger',
                        });

                        if (ok === false) return;

                        this.deleting = true;
                        try {
                            const response = await fetch(`/admin/media/${item.id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                }
                            });

                            if (!response.ok) throw new Error();

                            this.selectedIds = this.selectedIds.filter(id => id !== item.id);
                            toast('File berhasil dihapus');
                            await this.fetchMedia();

                        } catch (e) {
                            toast('Gagal menghapus file', 'error');
                        } finally {
                            this.deleting = false;
                        }
                    },

                    async bulkDelete() {
                        const ok = await confirmAction({
                            title: 'Hapus ' + this.selectedIds.length + ' File',
                            message: `Semua file yang dipilih akan dihapus permanen. Tindakan ini tidak bisa dibatalkan.`,
                            confirmText: 'Hapus Semua',
                            type: 'danger',
                        });

                        if (ok === false) return;

                        this.deleting = true;
                        const count = this.selectedIds.length;
                        try {
                            await Promise.all(
                                this.selectedIds.map(id =>
                                    fetch(`/admin/media/${id}`, {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Accept': 'application/json',
                                        }
                                    })
                                )
                            );

                            this.selectedIds = [];
                            toast(`${count} file berhasil dihapus`);
                            await this.fetchMedia();

                        } catch (e) {
                            toast('Gagal menghapus sebagian file', 'error');
                        } finally {
                            this.deleting = false;
                        }
                    },

                    handleDrop(event) {
                        this.isDragging = false;
                        this.handleFiles(event.dataTransfer.files);
                    },

                    handleFiles(files) {
                        this.uploadQueue = Array.from(files);
                    },

                    async uploadFiles() {
                        this.uploading = true;
                        this.uploadProgress = 0;
                        let successCount = 0;
                        let failCount = 0;

                        for (let i = 0; i < this.uploadQueue.length; i++) {
                            const formData = new FormData();
                            formData.append('file', this.uploadQueue[i]);
                            formData.append('_token', '{{ csrf_token() }}');

                            try {
                                const res = await fetch('/admin/media', {
                                    method: 'POST',
                                    body: formData,
                                });
                                if (res.ok) successCount++;
                                else failCount++;
                            } catch (e) {
                                failCount++;
                            }

                            this.uploadProgress = ((i + 1) / this.uploadQueue.length) * 100;
                        }

                        this.uploading = false;
                        this.uploadQueue = [];
                        this.showUpload = false;

                        if (successCount > 0) toast(`${successCount} file berhasil diupload`);
                        if (failCount > 0) toast(`${failCount} file gagal diupload`, 'error');

                        await this.fetchMedia();
                    },

                    prevPage() {
                        if (this.pagination.current_page > 1) {
                            this.pagination.current_page--;
                            this.fetchMedia();
                        }
                    },

                    nextPage() {
                        if (this.pagination.current_page < this.pagination.last_page) {
                            this.pagination.current_page++;
                            this.fetchMedia();
                        }
                    },

                    formatSize(bytes) {
                        if (bytes < 1024) return bytes + ' B';
                        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
                        return (bytes / 1048576).toFixed(1) + ' MB';
                    },
                }
            }
        </script>
    @endpush

@endsection
