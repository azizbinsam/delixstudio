@extends('errors.layout')

@section('code', '404')
@section('title', 'Halaman Tidak Ditemukan')
@section('description', 'Halaman yang kamu cari tidak ada, sudah dipindahkan, atau mungkin kamu salah ketik URL.')
@section('glow-color', '#ffffff')

@section('icon')
    <i class="fas fa-compass text-white/30 text-lg"></i>
@endsection

@section('actions')
    @php
        $prev = url()->previous();
        $curr = url()->current();
        $hasPrev = $prev && $prev !== $curr && $prev !== url('/');
    @endphp

    @if ($hasPrev)
        <a href="{{ $prev }}" class="btn btn-outline">
            <i class="fas fa-arrow-left text-[10px]"></i>
            Kembali
        </a>
    @endif

    <a href="{{ url('/') }}" class="btn btn-primary">
        <i class="fas fa-house text-[10px]"></i>
        Ke Beranda
    </a>
@endsection
