@props([
    'name',
    'label' => null,
    'placeholder' => '',
    'value' => null,
    'rows' => 4,
    'error' => null,
    'hint' => null,
    'required' => false,
    'resize' => false,
])

@php
    $id = $name;
    $val = old($name, $value);
    $hasError = $error ?? $errors->first($name);
    $resizeClass = $resize ? '' : 'resize-none';
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

    <textarea id="{{ $id }}" name="{{ $name }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}"
        @if ($required) required @endif
        {{ $attributes->merge(['class' => "input $resizeClass" . ($hasError ? ' input-error' : '')]) }}>{{ $val }}</textarea>

    @if ($hint && !$hasError)
        <p class="text-[11px] text-white/30">{{ $hint }}</p>
    @endif

    @if ($hasError)
        <p class="text-[11px] text-red-400">{{ $hasError }}</p>
    @endif
</div>
