@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Produk</h1>
        </div>
        <x-btn variant="outline" href="{{ route('admin.products.index') }}" wire:navigate>
            <i class="fas fa-arrow-left"></i> Kembali
        </x-btn>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data"
        x-data="{ type: '{{ old('type', $product->type) }}' }" novalidate>
        @csrf @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            {{-- Main --}}
            <div class="lg:col-span-2 space-y-4">
                <div class="card card-body space-y-4">
                    <x-form.input name="title" label="Judul Produk" :value="$product->title" required />
                    <x-form.textarea name="description" label="Deskripsi" :value="$product->description" :rows="5" required />
                    <x-form.input name="demo_url" label="Link Demo" :value="$product->demo_url" placeholder="https://demo.example.com"
                        hint="URL ke halaman demo produk (opsional)" />

                    <x-form.input name="tutorial_url" label="Link Tutorial Install" :value="$product->tutorial_url"
                        placeholder="https://youtube.com/watch?v=... atau link lainnya"
                        hint="Bisa link YouTube, Google Drive, atau link custom (opsional)" />
                </div>

                {{-- File Produk --}}
                <div class="card p-5" x-show="type === 'file'">
                    <p class="text-xs font-medium text-white/40 uppercase tracking-widest mb-4">File Produk</p>

                    {{-- File yang sudah ada --}}
                    @if ($product->files->count() > 0)
                        <div class="mb-4 space-y-2">
                            <p class="text-xs text-white/30 mb-2">File saat ini:</p>
                            @foreach ($product->files as $file)
                                <div class="flex items-center justify-between bg-white/5 rounded-lg px-3 py-2">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-file text-xs text-white/30"></i>
                                        <span class="text-xs text-white/50">{{ $file->file_name }}</span>
                                    </div>
                                </div>
                            @endforeach
                            <p class="text-[11px] text-white/20">Pilih file baru untuk mengganti file yang ada.</p>
                        </div>
                    @endif

                    <x-media-picker name="product_file" label="Ganti File Produk (ZIP)" type="file" :value="$product->files->first()?->file_path" />
                </div>

                {{-- Info Lisensi --}}
                <div class="card p-5" x-show="type === 'license'">
                    <p class="text-xs font-medium text-white/40 uppercase tracking-widest mb-4">Info Lisensi</p>
                    <div class="alert-info text-xs">
                        <i class="fas fa-info-circle mt-0.5"></i>
                        <span>Produk lisensi tidak perlu upload file. User akan mengisi data WP-Admin saat checkout.</span>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-4">
                <div class="card card-body space-y-4">
                    <x-form.select name="category_id" label="Kategori" required :selected="$product->category_id" :options="$categories->pluck('name', 'id')->toArray()" />

                    <x-form.select name="type" label="Tipe Produk" :selected="$product->type" x-model="type" :options="['file' => 'File Download', 'license' => 'Lisensi']" />

                    <x-form.number name="price" label="Harga (Rp)" :value="$product->price" :min="0"
                        :step="1000" :format="true" hint="Isi 0 untuk produk gratis" />

                    <x-form.select name="status" label="Status" :selected="$product->status" :options="['draft' => 'Draft', 'published' => 'Published']" />

                    {{-- Thumbnail --}}
                    <x-media-picker name="thumbnail" label="Thumbnail" type="image" :value="$product->thumbnail" />

                    <x-btn type="submit" class="w-full justify-center">Simpan Perubahan</x-btn>
                </div>
            </div>
        </div>
    </form>
@endsection
