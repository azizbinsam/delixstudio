@extends('errors.layout')

@section('code', '500')
@section('title', 'Terjadi Kesalahan Server')
@section('description', 'Server mengalami masalah yang tidak terduga. Tim kami sedang menanganinya — coba beberapa saat
    lagi.')
@section('glow-color', '#f59e0b')

@section('icon')
    <i class="fas fa-triangle-exclamation text-white/30 text-lg"></i>
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
