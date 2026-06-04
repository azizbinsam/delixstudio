@extends('layouts.admin')

@section('title', 'Kelola Kelas')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">{{ $course->title }}</h1>
            <p class="page-desc">Kelola sections & chapters</p>
        </div>
        <x-btn variant="outline" href="{{ route('admin.courses.index') }}" wire:navigate>
            <i class="fas fa-arrow-left"></i> Kembali
        </x-btn>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- Sections & Chapters --}}
        <div class="lg:col-span-2 space-y-3" x-data="{ editSection: null, showEditSection: false, editChapter: null, showEditChapter: false }">

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="alert-success">
                    <i class="fas fa-check-circle text-xs"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @forelse($course->sections as $section)
                <div class="card">
                    {{-- Section Header --}}
                    <div class="card-header flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="text-xs text-white/20 font-mono w-4">{{ $section->order }}</span>
                            <span class="text-sm font-medium text-white/70">{{ $section->title }}</span>
                            <span class="text-[11px] text-white/20">{{ $section->chapters->count() }} chapter</span>
                        </div>
                        <div class="flex items-center gap-2">
                            {{-- Tombol Edit Section --}}
                            <x-btn variant="ghost" size="sm"
                                @click="editSection = {
                                id: {{ $section->id }},
                                title: '{{ addslashes($section->title) }}',
                                order: {{ $section->order }}
                                }; showEditSection = true">
                                Edit
                            </x-btn>
                            {{-- Tombol Hapus Section --}}
                            <form action="{{ route('admin.sections.destroy', $section) }}" method="POST" x-data
                                @submit.prevent="
                            confirmAction({
                                title: 'Hapus Section',
                                message: 'Section beserta semua chapter di dalamnya akan dihapus. Lanjutkan?',
                                confirmText: 'Ya, Hapus',
                            }).then(() => $el.submit())
                        ">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="p-1.5 rounded-md text-white/20 hover:text-red-400 hover:bg-red-500/10 transition-colors">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Chapters --}}
                    <div class="divide-y divide-white/5">
                        @forelse($section->chapters as $chapter)
                            <div class="px-5 py-3 flex items-center justify-between gap-3">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <span
                                        class="text-[10px] text-white/20 font-mono w-4 flex-shrink-0">{{ $chapter->order }}</span>
                                    <i class="fas fa-play-circle text-[10px] text-white/20 flex-shrink-0"></i>
                                    <div class="min-w-0">
                                        <p class="text-xs text-white/60 truncate">{{ $chapter->title }}</p>
                                        @if ($chapter->description)
                                            <p class="text-[11px] text-white/25 truncate mt-0.5">
                                                {{ $chapter->description }}
                                            </p>
                                        @endif
                                    </div>
                                    @if ($chapter->is_free)
                                        <x-badge variant="success">Gratis</x-badge>
                                    @endif
                                </div>
                                <div class="flex items-center gap-1.5 flex-shrink-0">
                                    <x-btn variant="ghost" size="sm"
                                        @click="editChapter = {
                                        id: {{ $chapter->id }},
                                        section_id: {{ $section->id }},
                                        title: '{{ addslashes($chapter->title) }}',
                                        description: '{{ addslashes($chapter->description) }}',
                                        youtube_url: '{{ $chapter->youtube_url }}',
                                        order: {{ $chapter->order }},
                                        is_free: {{ $chapter->is_free ? 'true' : 'false' }}
                                    }; showEditChapter = true">
                                        Edit
                                    </x-btn>
                                    <form action="{{ route('admin.chapters.destroy', $chapter) }}" method="POST" x-data
                                        @submit.prevent="
                                        confirmAction({
                                            title: 'Hapus Chapter',
                                            message: 'Chapter ini akan dihapus permanen. Lanjutkan?',
                                            confirmText: 'Ya, Hapus',
                                        }).then(() => $el.submit())
                                    ">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="p-1.5 rounded-md text-white/20 hover:text-red-400 hover:bg-red-500/10 transition-colors">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="px-5 py-4 text-center">
                                <p class="text-xs text-white/20">Belum ada chapter di section ini</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Add Chapter Inline --}}
                    <div class="border-t border-white/5 px-5 py-4" x-data="{ open: false }">
                        <button type="button" @click="open = !open"
                            class="text-xs text-white/30 hover:text-white transition-colors flex items-center gap-1.5">
                            <i class="fas fa-plus text-[10px]"></i> Tambah Chapter
                        </button>
                        <div x-show="open" x-transition class="mt-3">
                            <form action="{{ route('admin.chapters.store', $section) }}" method="POST">
                                @csrf
                                <div class="space-y-3">
                                    <div class="grid grid-cols-2 gap-2 items-end">
                                        <x-form.input name="title" label="Judul Chapter" placeholder="Judul chapter"
                                            required />
                                        <x-form.number name="order" label="Urutan" type="number" :value="$section->chapters->count() + 1" />
                                    </div>
                                    <x-form.textarea name="description" label="Deskripsi"
                                        placeholder="Deskripsi chapter (opsional)" :rows="2" />
                                    <x-form.input name="youtube_url" label="YouTube URL"
                                        placeholder="https://youtube.com/watch?v=..." required />
                                    <div class="flex items-center justify-between">
                                        <x-form.checkbox name="is_free" label="Chapter gratis (preview)" />
                                        <div class="flex gap-2">
                                            <x-btn variant="ghost" size="sm" @click="open = false">Batal</x-btn>
                                            <x-btn type="submit" size="sm">Simpan</x-btn>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 border border-white/5 rounded-xl">
                    <i class="fas fa-layer-group text-2xl text-white/10 mb-2 block"></i>
                    <p class="text-xs text-white/20">Belum ada section</p>
                    <p class="text-[11px] text-white/15 mt-1">Tambah section menggunakan form di sebelah kanan</p>
                </div>
            @endforelse

            {{-- Modal Edit Chapter --}}
            <x-modal show="showEditChapter" title="Edit Chapter" max-width="md">
                <form :action="`/admin/chapters/${editChapter?.id}`" method="POST" class="space-y-3">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-2 gap-2">
                        <div class="space-y-1.5">
                            <label class="label">Judul Chapter</label>
                            <input type="text" name="title" :value="editChapter?.title" class="input" required>
                        </div>
                        <div class="space-y-1.5">
                            <label class="label">Urutan</label>
                            <input type="number" name="order" :value="editChapter?.order" class="input"
                                min="1">
                        </div>
                    </div>
                    <div class="space-y-1.5">
                        <label class="label">Deskripsi</label>
                        <textarea name="description" rows="2" class="input resize-none" :value="editChapter?.description"></textarea>
                    </div>
                    <div class="space-y-1.5">
                        <label class="label">YouTube URL</label>
                        <input type="text" name="youtube_url" :value="editChapter?.youtube_url" class="input"
                            required>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="hidden" name="is_free" value="0">
                        <input type="checkbox" name="is_free" id="edit_is_free" value="1"
                            class="accent-white w-3.5 h-3.5" :checked="editChapter?.is_free">
                        <label for="edit_is_free" class="text-xs text-white/50">Chapter gratis (preview)</label>
                    </div>
                    <div class="flex gap-2 pt-2">
                        <x-btn variant="outline" class="flex-1" @click="showEditChapter = false">Batal</x-btn>
                        <x-btn type="submit" class="flex-1">Simpan</x-btn>
                    </div>
                </form>
            </x-modal>

            {{-- Modal Edit Section --}}
            <x-modal show="showEditSection" title="Edit Section">
                <form :action="`/admin/sections/${editSection?.id}`" method="POST" class="space-y-3">
                    @csrf @method('PUT')
                    <div class="space-y-1.5">
                        <label class="label">Judul Section</label>
                        <input type="text" name="title" :value="editSection?.title" class="input" required>
                    </div>
                    <div class="space-y-1.5">
                        <label class="label">Urutan</label>
                        <input type="number" name="order" :value="editSection?.order" class="input" min="1">
                    </div>
                    <div class="flex gap-2 pt-2">
                        <x-btn variant="outline" class="flex-1" @click="showEditSection = false">Batal</x-btn>
                        <x-btn type="submit" class="flex-1">Simpan</x-btn>
                    </div>
                </form>
            </x-modal>
        </div>

        {{-- Sidebar: Add Section --}}
        <div class="space-y-4">
            <div class="card p-5">
                <p class="text-xs font-medium text-white/40 uppercase tracking-widest mb-4">Tambah Section</p>
                <form action="{{ route('admin.sections.store', $course) }}" method="POST" class="space-y-3">
                    @csrf
                    <x-form.input name="title" label="Judul Section" placeholder="Judul section" required />
                    <x-form.number name="order" label="Urutan" type="number" :value="$course->sections->count() + 1" />
                    <x-btn type="submit" class="w-full justify-center">
                        <i class="fas fa-plus"></i> Tambah Section
                    </x-btn>
                </form>
            </div>

            {{-- Course Info --}}
            <div class="card p-5">
                <p class="text-xs font-medium text-white/40 uppercase tracking-widest mb-4">Info Kelas</p>
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-white/30">Total Section</span>
                        <span class="text-xs text-white/60">{{ $course->sections->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-white/30">Total Chapter</span>
                        <span class="text-xs text-white/60">
                            {{ $course->sections->sum(fn($s) => $s->chapters->count()) }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-white/30">Status</span>
                        <x-badge variant="{{ $course->status === 'published' ? 'success' : 'secondary' }}">
                            {{ ucfirst($course->status) }}
                        </x-badge>
                    </div>
                    <div class="border-t border-white/5 pt-2.5">
                        <x-btn variant="outline" class="w-full justify-center"
                            href="{{ route('admin.courses.edit', $course) }}" wire:navigate>
                            <i class="fas fa-edit"></i> Edit Kelas
                        </x-btn>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
