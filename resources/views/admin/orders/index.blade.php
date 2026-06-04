@extends('layouts.admin')

@section('title', 'Pesanan')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Pesanan</h1>
            <p class="page-desc">Kelola semua transaksi</p>
        </div>
    </div>

    <livewire:admin.order-table />
@endsection
