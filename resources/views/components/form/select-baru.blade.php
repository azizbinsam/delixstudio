@props([
    'name' => null,
    'label' => null,
    'options' => [],
    'placeholder' => null,
    'selected' => null,
    'error' => null,
    'hint' => null,
    'required' => false,
    'wireModel' => null,
])

@php
    $id = $name ?? 'select-' . uniqid();
    $current = $name ? old($name, $selected) : $selected;
    $hasError = $error ?? ($errors->has($name ?? '') ? $errors->first($name) : null);
    $allOptions = $placeholder ? ['' => $placeholder] + $options : $options;
    $initialLabel = $placeholder ?? (collect($options)->first() ?? '');
    if ($current && isset($options[$current])) {
        $initialLabel = $options[$current];
    }
@endphp

<div class="space-y-1.5">
    @if ($label)
        <label class="label">
            {{ $label }}
            @if ($required)
                <span class="text-red-400">*</span>
            @endif
        </label>
    @endif

    {{-- Hidden native select untuk form biasa (non-Livewire) --}}
    @if ($name && !$wireModel)
        <select name="{{ $name }}" id="{{ $id }}" class="hidden"
            @if ($required) required @endif>
            @foreach ($allOptions as $val => $optLabel)
                <option value="{{ $val }}" @selected($current == $val)>{{ $optLabel }}</option>
            @endforeach
            {{ $slot ?? '' }}
        </select>
    @endif

    <div x-data="{
        open: false,
        selected: '{{ $current ?? '' }}',
        label: '{{ $initialLabel }}',
        options: {{ Js::from($allOptions) }},
        pick(val, label) {
            this.selected = val;
            this.label = label;
            this.open = false;
            @if ($wireModel) $wire.set('{{ $wireModel }}', val);
                @elseif($name)
                    document.getElementById('{{ $id }}').value = val; @endif
        }
    }" x-on:click.outside="open = false" class="relative"
        {{ $attributes->only(['class', 'wire:key']) }}>
        {{-- Trigger button --}}
        <button type="button" x-on:click="open = !open"
            class="input w-full flex items-center justify-between gap-2 text-left"
            :class="{ 'input-error': {{ $hasError ? 'true' : 'false' }} }">
            <span x-text="label" class="truncate" :class="selected === '' ? 'text-white/40' : 'text-white'">
            </span>
            <i class="fas fa-chevron-down text-[10px] text-white/40 transition-transform duration-150"
                :class="open ? 'rotate-180' : ''"></i>
        </button>

        {{-- Dropdown --}}
        <div x-show="open" x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
            class="absolute z-50 mt-1 w-full rounded-lg border border-white/10 bg-[#252525] p-1 shadow-xl"
            style="display: none">
            <template x-for="(optLabel, val) in options" :key="val">
                <button type="button" x-on:click="pick(val, optLabel)"
                    class="flex w-full items-center gap-2 rounded-md px-3 py-1.5 text-left text-sm text-white/70 hover:bg-white/8 hover:text-white"
                    :class="selected === val ? 'text-white bg-white/5' : ''" x-text="optLabel"></button>
            </template>
        </div>
    </div>

    @if ($hint && !$hasError)
        <p class="text-[11px] text-white/30">{{ $hint }}</p>
    @endif
    @if ($hasError)
        <p class="text-[11px] text-red-400">{{ $hasError }}</p>
    @endif
</div>
