@props(['name', 'label' => null, 'checked' => false, 'hint' => null])

@php
    $isChecked = old($name, $checked);
    $hasWireModel = $attributes->whereStartsWith('wire:model')->isNotEmpty();
@endphp

<div class="flex items-center justify-between gap-4">
    @if ($label)
        <div>
            <p class="text-xs font-medium text-white/60">{{ $label }}</p>
            @if ($hint)
                <p class="text-[11px] text-white/30 mt-0.5">{{ $hint }}</p>
            @endif
        </div>
    @endif

    <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
        @if (!$hasWireModel)
            <input type="hidden" name="{{ $name }}" value="0">
        @endif

        <input type="checkbox" name="{{ $name }}" value="1" class="sr-only peer"
            @if (!$hasWireModel && $isChecked) checked @endif {{ $attributes }}>

        <div
            class="w-9 h-5 rounded-full transition-colors duration-200
            bg-white/10 peer-checked:bg-white
            after:content-[''] after:absolute after:top-0.5 after:left-0.5
            after:bg-black after:rounded-full after:h-4 after:w-4
            after:transition-all after:duration-200
            peer-checked:after:translate-x-4">
        </div>
    </label>
</div>
