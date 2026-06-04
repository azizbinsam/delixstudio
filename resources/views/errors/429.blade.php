@extends('errors.layout')

@section('code', '429')
@section('title', 'Terlalu Banyak Permintaan')
@section('description', 'Kamu mengirim terlalu banyak permintaan dalam waktu singkat. Tunggu sebentar sebelum mencoba
    lagi.')
@section('glow-color', '#f97316')

@section('icon')
    <i class="fas fa-bolt text-white/30 text-lg"></i>
@endsection

@section('actions')
    <button onclick="window.location.reload()" class="btn btn-outline">
        <i class="fas fa-rotate-right text-[10px]"></i>
        Coba Lagi
    </button>
    <a href="{{ url('/') }}" class="btn btn-primary">
        <i class="fas fa-house text-[10px]"></i>
        Ke Beranda
    </a>
@endsection
