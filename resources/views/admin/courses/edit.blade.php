@extends('layouts.admin')

@section('title', 'Edit Kelas')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Kelas</h1>
        </div>
        <x-btn variant="outline" href="{{ route('admin.courses.index') }}" wire:navigate>
            <i class="fas fa-arrow-left"></i> Kembali
        </x-btn>
    </div>

    <form action="{{ route('admin.courses.update', $course) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            {{-- Main --}}
            <div class="lg:col-span-2 space-y-4">
                <div class="card card-body space-y-4">
                    <x-form.input name="title" label="Judul Kelas" :value="$course->title" required />
                    <x-form.textarea name="description" label="Deskripsi" :value="$course->description" :rows="4" required />
                    <x-form.input name="overview_video" label="URL Video Overview (YouTube)" :value="$course->overview_video"
                        placeholder="https://youtube.com/watch?v=..."
                        hint="Video ini bisa ditonton user sebelum membeli kelas" />
                    <x-form.input name="whatsapp_group" label="Link WhatsApp Group" :value="$course->whatsapp_group"
                        placeholder="https://chat.whatsapp.com/..." />
                </div>

                {{-- Tools --}}
                <div class="card p-5" x-data="{ tools: {{ json_encode($course->tools->map(fn($t) => ['name' => $t->name, 'icon' => $t->icon, 'url' => $t->url])->toArray()) }} }">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-xs font-medium text-white/40 uppercase tracking-widest">Tools yang Digunakan</p>
                        <x-btn variant="ghost" size="sm" @click="tools.push({ name: '', icon: '', url: '' })">
                            <i class="fas fa-plus"></i> Tambah
                        </x-btn>
                    </div>
                    <div class="space-y-3">
                        <div class="grid grid-cols-3 gap-2 mb-1">
                            <p class="text-[11px] text-white/20">Nama</p>
                            <p class="text-[11px] text-white/20">Icon (FA class)</p>
                            <p class="text-[11px] text-white/20">URL (opsional)</p>
                        </div>
                        <template x-for="(tool, index) in tools" :key="index">
                            <div class="grid grid-cols-3 gap-2 items-center">
                                <input type="text" :name="`tools[${index}][name]`" x-model="tool.name"
                                    placeholder="Nama tool" class="input">
                                <input type="text" :name="`tools[${index}][icon]`" x-model="tool.icon"
                                    placeholder="fas fa-code" class="input">
                                <div class="flex gap-2">
                                    <input type="text" :name="`tools[${index}][url]`" x-model="tool.url"
                                        placeholder="https://..." class="input flex-1">
                                    <button type="button" @click="tools.splice(index, 1)"
                                        class="p-1.5 rounded-md text-white/20 hover:text-red-400 hover:bg-red-500/10 transition-colors flex-shrink-0">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </template>

                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-4">
                <div class="card card-body space-y-4">
                    <x-form.select name="category_id" label="Kategori" required :selected="$course->category_id" :options="$categories->pluck('name', 'id')->toArray()" />
                    <x-form.select name="level" label="Level" :selected="$course->level" :options="['beginner' => 'Beginner', 'intermediate' => 'Intermediate', 'advanced' => 'Advanced']" />
                    <x-form.number name="price" label="Harga (Rp)" :value="$course->price" :min="0" :step="1000"
                        :format="true" hint="Isi 0 untuk kelas gratis" />
                    <x-form.select name="status" label="Status" :selected="$course->status" :options="['draft' => 'Draft', 'published' => 'Published']" />

                    {{-- Thumbnail --}}
                    <x-media-picker name="thumbnail" label="Thumbnail" type="image" :value="$course->thumbnail" />

                    <x-btn type="submit" class="w-full justify-center">Simpan Perubahan</x-btn>
                </div>
            </div>
        </div>
    </form>
@endsection
