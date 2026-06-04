@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Produk</h1>
        </div>
        <x-btn variant="outline" href="{{ route('admin.products.index') }}" wire:navigate>
            <i class="fas fa-arrow-left"></i> Kembali
        </x-btn>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" x-data="{ type: '{{ old('type', 'file') }}' }"
        novalidate>
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            {{-- Main --}}
            <div class="lg:col-span-2 space-y-4">
                <div class="card card-body space-y-4">
                    <x-form.input name="title" label="Judul Produk" placeholder="Judul produk" required />
                    <x-form.textarea name="description" label="Deskripsi" placeholder="Deskripsi produk" :rows="5"
                        required />
                    <x-form.input name="demo_url" label="Link Demo" placeholder="https://demo.example.com"
                        hint="URL ke halaman demo produk (opsional)" />

                    <x-form.input name="tutorial_url" label="Link Tutorial Install"
                        placeholder="https://youtube.com/watch?v=... atau link lainnya"
                        hint="Bisa link YouTube, Google Drive, atau link custom (opsional)" />
                </div>

                {{-- File Produk --}}
                <div class="card p-5" x-show="type === 'file'">
                    <p class="text-xs font-medium text-white/40 uppercase tracking-widest mb-4">File Produk</p>
                    <div class="alert-info mb-4 text-xs">
                        <i class="fas fa-info-circle mt-0.5"></i>
                        <span>Upload file ZIP atau format lainnya untuk produk tipe file.</span>
                    </div>
                    <x-media-picker name="product_file" label="File Produk (ZIP)" type="file" />
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
                    <x-form.select name="category_id" label="Kategori" placeholder="Pilih kategori" required
                        :options="$categories->pluck('name', 'id')->toArray()" />

                    <x-form.select name="type" label="Tipe Produk" x-model="type" :options="['file' => 'File Download', 'license' => 'Lisensi']" />

                    <x-form.number name="price" label="Harga (Rp)" value="0" :min="0" :step="1000"
                        :format="true" hint="Isi 0 untuk kelas gratis" />

                    <x-form.select name="status" label="Status" :options="['draft' => 'Draft', 'published' => 'Published']" />

                    {{-- Thumbnail --}}
                    <x-media-picker name="thumbnail" label="Thumbnail" type="image" />

                    <x-btn type="submit" class="w-full justify-center">Simpan Produk</x-btn>
                </div>
            </div>
        </div>
    </form>
@endsection
