@props(['name', 'label' => null, 'value' => '1', 'checked' => false, 'hint' => null])

@php
    $id = $name . '_' . $value;
    $isChecked = old($name, $checked);
    $hasWireModel = $attributes->whereStartsWith('wire:model')->isNotEmpty();
@endphp

<div class="space-y-1">
    <div class="flex items-center gap-2">
        @if (!$hasWireModel)
            <input type="hidden" name="{{ $name }}" value="0">
        @endif

        <input type="checkbox" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}"
            @if (!$hasWireModel && $isChecked) checked @endif {{ $attributes->merge(['class' => 'sr-only peer']) }}
            @if ($hasWireModel) x-bind:checked="$wire.{{ $attributes->whereStartsWith('wire:model')->first() ? 'selectAll' : '' }}" @endif>


        <label for="{{ $id }}"
            class="w-3.5 h-3.5 rounded-sm border border-white/20 bg-white/5
            peer-checked:bg-white peer-checked:border-white
            peer-checked:bg-[url('data:image/svg+xml,%3Csvg%20viewBox%3D%220%200%2010%2010%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M1.5%205l2.5%202.5%204.5-4.5%22%20stroke%3D%22%23000%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20fill%3D%22none%22%2F%3E%3C%2Fsvg%3E')]
            peer-checked:bg-center peer-checked:bg-no-repeat peer-checked:bg-[length:10px_10px]
            transition-all duration-150 cursor-pointer flex-shrink-0">
        </label>

        @if ($label)
            <label for="{{ $id }}" class="text-xs text-white/50 cursor-pointer select-none">
                {{ $label }}
            </label>
        @endif
    </div>

    @if ($hint)
        <p class="text-[11px] text-white/30 pl-5">{{ $hint }}</p>
    @endif
</div>
