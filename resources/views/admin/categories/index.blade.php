@extends('layouts.admin')

@section('title', 'Kategori')

@section('content')
    <div x-data="{ showCreate: false, showEdit: false, editData: {} }">

        <div class="page-header">
            <div>
                <h1 class="page-title">Kategori</h1>
                <p class="page-desc">Kelola kategori kelas dan produk</p>
            </div>
            <x-btn @click="showCreate = true">
                <i class="fas fa-plus"></i> Tambah
            </x-btn>
        </div>

        <livewire:admin.category-table />

        {{-- Modal Create --}}
        <x-modal show="showCreate" title="Tambah Kategori">
            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-3">
                @csrf
                <x-form.input name="name" label="Nama Kategori" placeholder="Nama kategori" required />
                <x-form.select name="type" label="Tipe" placeholder="Pilih tipe" required :options="['course' => 'Kelas', 'product' => 'Produk']" />
                <x-form.input name="icon" label="Icon (Font Awesome class)" placeholder="fas fa-tag"
                    hint="Cari icon di fontawesome.com" />
                <div class="flex gap-2 pt-2">
                    <x-btn variant="outline" class="flex-1" @click="showCreate = false">Batal</x-btn>
                    <x-btn type="submit" class="flex-1">Simpan</x-btn>
                </div>
            </form>
        </x-modal>

        {{-- Modal Edit --}}
        <x-modal show="showEdit" title="Edit Kategori">
            <form :action="`/admin/categories/${editData.id}`" method="POST" class="space-y-3">
                @csrf @method('PUT')
                <div class="space-y-1.5">
                    <label class="label">Nama Kategori</label>
                    <input type="text" name="name" :value="editData.name" class="input" required>
                </div>
                <div class="space-y-1.5">
                    <label class="label">Tipe</label>
                    <select name="type" class="input">
                        <option value="course" :selected="editData.type === 'course'">Kelas</option>
                        <option value="product" :selected="editData.type === 'product'">Produk</option>
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label class="label">Icon</label>
                    <input type="text" name="icon" :value="editData.icon" class="input" placeholder="fas fa-tag">
                </div>
                <div class="flex gap-2 pt-2">
                    <x-btn variant="outline" class="flex-1" @click="showEdit = false">Batal</x-btn>
                    <x-btn type="submit" class="flex-1">Simpan</x-btn>
                </div>
            </form>
        </x-modal>
    </div>
@endsection
