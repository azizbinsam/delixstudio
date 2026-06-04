@extends('layouts.admin')

@section('title', 'Users')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Users</h1>
            <p class="page-desc">Kelola semua member</p>
        </div>
    </div>

    <livewire:admin.user-table />
@endsection
