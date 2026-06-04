@extends('layouts.admin')

@section('title', 'Kelas')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Kelas</h1>
            <p class="page-desc">Kelola semua kelas e-learning</p>
        </div>
        <x-btn href="{{ route('admin.courses.create') }}" wire:navigate>
            <i class="fas fa-plus"></i> Tambah Kelas
        </x-btn>
    </div>

    <livewire:admin.course-table />
@endsection
