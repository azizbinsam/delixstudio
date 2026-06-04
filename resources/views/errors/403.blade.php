@extends('errors.layout')

@section('code', '403')
@section('title', 'Akses Ditolak')
@section('description', $exception?->getMessage() ?: 'Kamu tidak memiliki izin untuk mengakses halaman ini.')
@section('glow-color', '#ef4444')

@section('icon')
    <i class="fas fa-lock text-white/30 text-lg"></i>
@endsection

@section('actions')
    @auth
        @php
            $prev = url()->previous();
            $curr = url()->current();
            $hasPrev = $prev && $prev !== $curr;
        @endphp

        @if ($hasPrev)
            <a href="{{ $prev }}" class="btn btn-outline">
                <i class="fas fa-arrow-left text-[10px]"></i>
                Kembali
            </a>
        @endif

        <a href="{{ url('/') }}" class="btn btn-primary">
            <i class="fas fa-house text-[10px]"></i>
            Ke Home
        </a>
    @else
        <a href="{{ route('login') }}" class="btn btn-primary">
            <i class="fas fa-right-to-bracket text-[10px]"></i>
            Login
        </a>
        <a href="{{ url('/') }}" class="btn btn-outline">
            <i class="fas fa-house text-[10px]"></i>
            Ke Home
        </a>
    @endauth
@endsection
