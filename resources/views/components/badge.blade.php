@props([
    'variant' => 'secondary',
])

@php
    $v = match ($variant) {
        'primary' => 'badge-primary',
        'success' => 'badge-success',
        'warning' => 'badge-warning',
        'destructive' => 'badge-destructive',
        default => 'badge-secondary',
    };
@endphp

<span {{ $attributes->merge(['class' => $v]) }}>{{ $slot }}</span>
