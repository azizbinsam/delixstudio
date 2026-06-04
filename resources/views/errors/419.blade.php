@extends('errors.layout')

@section('code', '419')
@section('title', 'Sesi Kedaluwarsa')
@section('description', 'Sesi kamu telah berakhir karena tidak aktif terlalu lama. Silakan muat ulang halaman dan coba
    lagi.')
@section('glow-color', '#8b5cf6')

@section('icon')
    <i class="fas fa-clock text-white/30 text-lg"></i>
@endsection

@section('actions')
    <button onclick="window.location.reload()" class="btn btn-primary">
        <i class="fas fa-rotate-right text-[10px]"></i>
        Muat Ulang
    </button>
    <a href="{{ url('/') }}" class="btn btn-outline">
        <i class="fas fa-house text-[10px]"></i>
        Ke Beranda
    </a>
@endsection
