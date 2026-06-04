@extends('layouts.admin')

@section('title', 'Produk')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Produk</h1>
        <p class="page-desc">Kelola semua tema & plugin WordPress</p>
    </div>
    <x-btn href="{{ route('admin.products.create') }}" wire:navigate>
        <i class="fas fa-plus"></i> Tambah Produk
    </x-btn>
</div>

<livewire:admin.product-table />
@endsection