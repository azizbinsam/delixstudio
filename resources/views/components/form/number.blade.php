@props([
    'name',
    'label' => null,
    'value' => 0,
    'min' => null,
    'max' => null,
    'step' => 1,
    'hint' => null,
    'error' => null,
    'required' => false,
    'format' => false, // aktifkan formatting
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

    <div x-data="{
        raw: {{ $val }},
        fmt: @json($format),
        step: {{ $step }},
        min: {{ $min ?? 0 }},
        max: {{ $max !== null ? $max : 'Infinity' }},
    
        get formatted() {
            if (!this.fmt || this.fmt === 'false') return String(this.raw);
            return new Intl.NumberFormat('id-ID').format(this.raw);
        },
    
        increment() {
            this.raw = this.max !== Infinity ?
                Math.min(this.max, Number(this.raw) + this.step) :
                Number(this.raw) + this.step;
        },
    
        decrement() {
            this.raw = Math.max(this.min, Number(this.raw) - this.step);
        },
    
        onInput(e) {
            const clean = e.target.value.replace(/\D/g, '');
            this.raw = clean === '' ? 0 : Number(clean);
        }
    }"
        class="flex items-stretch border border-white/10 rounded-md overflow-hidden bg-white/5 
    focus-within:ring-1 focus-within:ring-white/30 focus-within:border-white/20 transition-all">

        {{-- Hidden input untuk nilai asli --}}
        <input type="hidden" name="{{ $name }}" :value="raw">

        {{-- Display Input --}}
        <input type="text" id="{{ $id }}" x-ref="display" x-effect="$el.value = formatted"
            @input="onInput($event)" @if ($required) required @endif
            {{ $attributes->merge(['class' => 'flex-1 bg-transparent text-sm text-white px-3 py-1.5 outline-none w-full ' . ($hasError ? 'text-red-400' : '')]) }}>


        {{-- Minus --}}
        <button type="button" @click="decrement()"
            class="px-3 flex items-center justify-center text-white/30 hover:text-white hover:bg-white/5 transition-colors flex-shrink-0 border-l border-white/10">
            <i class="fas fa-minus text-[10px]"></i>
        </button>

        {{-- Plus --}}
        <button type="button" @click="increment()"
            class="px-3 flex items-center justify-center text-white/30 hover:text-white hover:bg-white/5 transition-colors flex-shrink-0 border-l border-white/10">
            <i class="fas fa-plus text-[10px]"></i>
        </button>
    </div>

    @if ($hint && !$hasError)
        <p class="text-[11px] text-white/30">{{ $hint }}</p>
    @endif

    @if ($hasError)
        <p class="text-[11px] text-red-400">{{ $hasError }}</p>
    @endif
</div>

<style>
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
