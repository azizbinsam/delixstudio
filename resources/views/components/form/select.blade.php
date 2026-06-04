@props([
    'name',
    'label' => null,
    'options' => [],
    'placeholder' => null,
    'selected' => null,
    'error' => null,
    'hint' => null,
    'required' => false,
])

@php
    $id = $name;
    $current = old($name, $selected);
    $hasError = $error ?? $errors->first($name);
    $hasWireModel = $attributes->whereStartsWith('wire:model')->isNotEmpty();
@endphp

{{-- <div class="space-y-1.5">
    @if ($label)
        <label for="{{ $id }}" class="label">
            {{ $label }}
            @if ($required)
                <span class="text-red-400">*</span>
            @endif
        </label>
    @endif

    <select id="{{ $id }}" name="{{ $name }}" @if ($required) required @endif
        {{ $attributes->merge(['class' => 'select' . ($hasError ? ' input-error' : '')]) }}>
        @if ($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif

        @foreach ($options as $val => $label)
            <option value="{{ $val }}" @if (!$hasWireModel) @selected($current == $val) @endif>
                {{ $label }}
            </option>
        @endforeach

        
        {{ $slot ?? '' }}
    </select>

    @if ($hint && !$hasError)
        <p class="text-[11px] text-white/30">{{ $hint }}</p>
    @endif

    @if ($hasError)
        <p class="text-[11px] text-red-400">{{ $hasError }}</p>
    @endif
</div> --}}

<div class="space-y-1.5">
    @if ($label)
        <label for="{{ $id }}" class="label">
            {{ $label }}
            @if ($required)
                <span class="text-red-400">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <select id="{{ $id }}" name="{{ $name }}" @if ($required) required @endif
            {{ $attributes->merge(['class' => 'select' . ($hasError ? ' input-error' : '')]) }}>
            @if ($placeholder)
                <option value="">{{ $placeholder }}</option>
            @endif

            @foreach ($options as $val => $label)
                <option value="{{ $val }}"
                    @if (!$hasWireModel) @selected($current == $val) @endif>
                    {{ $label }}
                </option>
            @endforeach

            {{ $slot ?? '' }}
        </select>

        <i
            class="fas fa-chevron-down pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-white/30">
        </i>
    </div>

    @if ($hint && !$hasError)
        <p class="text-[11px] text-white/30">{{ $hint }}</p>
    @endif

    @if ($hasError)
        <p class="text-[11px] text-red-400">{{ $hasError }}</p>
    @endif
</div>
