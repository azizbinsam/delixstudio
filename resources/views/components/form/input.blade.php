@props([
    'name',
    'label' => null,
    'type' => 'text',
    'placeholder' => '',
    'value' => null,
    'error' => null,
    'hint' => null,
    'required' => false,
])

@php
    $id = $name;
    $val = old($name, $value);
    $hasError = $error ?? $errors->first($name);
@endphp

<div class="space-y-1.5">
    @if ($label)
        <label for="{{ $id }}" class="label">
            {{ $label }}
            @if ($required)
                <span class="text-red-400">*</span>
            @endif
        </label>
    @endif

    <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}" placeholder="{{ $placeholder }}"
        @if ($val !== null) value="{{ $val }}" @endif
        @if ($required) required @endif
        {{ $attributes->merge(['class' => 'input' . ($hasError ? ' input-error' : '')]) }}>

    @if ($hint && !$hasError)
        <p class="text-[11px] text-white/30">{{ $hint }}</p>
    @endif

    @if ($hasError)
        <p class="text-[11px] text-red-400">{{ $hasError }}</p>
    @endif
</div>
