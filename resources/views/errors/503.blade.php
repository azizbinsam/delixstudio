@extends('errors.layout')

@section('code', '503')
@section('title', 'Sedang Maintenance')
@section('description', $exception?->getMessage() ?: 'Kami sedang melakukan pemeliharaan rutin. Sebentar lagi semua
    kembali normal.')
@section('glow-color', '#3b82f6')

@section('icon')
    <i class="fas fa-wrench text-white/30 text-lg"></i>
@endsection

@section('actions')
    <button onclick="window.location.reload()" class="btn btn-primary">
        <i class="fas fa-rotate-right text-[10px]"></i>
        Refresh
    </button>
@endsection
