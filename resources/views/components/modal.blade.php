{{--
    Penggunaan:
    <x-modal show="showCreate" title="Tambah Kategori" max-width="sm">
        ...konten...
    </x-modal>

    Props:
    - show       : nama variable Alpine yang mengontrol visibility (string)
    - title      : judul modal
    - max-width  : sm | md | lg (default: sm)
--}}

@props([
    'show' => 'show',
    'title' => '',
    'maxWidth' => 'sm',
])

@php
    $width = match ($maxWidth) {
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        default => 'max-w-sm',
    };
@endphp

<div x-show="{{ $show }}" x-transition:enter="transition ease-out duration-150"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed inset-0 z-[200] flex items-center justify-center p-4"
    style="display: none;">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="{{ $show }} = false"></div>

    {{-- Panel --}}
    <div class="relative w-full {{ $width }} card p-6 z-10" x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0">
        {{-- Header --}}
        @if ($title)
            <div class="flex items-center justify-between mb-5">
                <p class="text-sm font-semibold text-white">{{ $title }}</p>
                <button type="button" @click="{{ $show }} = false"
                    class="p-1 rounded-md text-white/30 hover:text-white hover:bg-white/5 transition-colors">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
        @endif

        {{-- Content --}}
        {{ $slot }}
    </div>
</div>
