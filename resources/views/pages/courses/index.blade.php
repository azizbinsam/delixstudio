@extends('layouts.app')

@section('title', 'Kelas')

@section('content')
    <x-section-header label="E-Learning" title="Semua Kelas"
        description="Tingkatkan skillmu dengan kelas-kelas premium dari instruktur berpengalaman." />
    <div class="pb-20">
        <div class="max-w-6xl mx-auto px-6">

            {{-- Filter Kategori --}}
            <div class="flex flex-wrap items-center gap-2 mb-8">
                <a href="{{ route('courses.index') }}" wire:navigate
                    class="px-3 py-1.5 rounded-md text-xs font-medium transition-colors
        {{ !request('category') && !request('price') ? 'bg-white text-black' : 'text-white/40 hover:text-white hover:bg-white/5 border border-white/10' }}">
                    Semua
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('courses.index', ['category' => $category->slug]) }}" wire:navigate
                        class="px-3 py-1.5 rounded-md text-xs font-medium transition-colors
            {{ request('category') === $category->slug ? 'bg-white text-black' : 'text-white/40 hover:text-white hover:bg-white/5 border border-white/10' }}">
                        {{ $category->name }}
                    </a>
                @endforeach

                {{-- Divider --}}
                <div class="w-px h-4 bg-white/10 mx-1"></div>

                {{-- Filter Harga --}}
                <a href="{{ route('courses.index', array_merge(request()->query(), ['price' => 'free'])) }}" wire:navigate
                    class="px-3 py-1.5 rounded-md text-xs font-medium transition-colors
        {{ request('price') === 'free' ? 'bg-white text-black' : 'text-white/40 hover:text-white hover:bg-white/5 border border-white/10' }}">
                    Gratis
                </a>
                <a href="{{ route('courses.index', array_merge(request()->query(), ['price' => 'paid'])) }}" wire:navigate
                    class="px-3 py-1.5 rounded-md text-xs font-medium transition-colors
        {{ request('price') === 'paid' ? 'bg-white text-black' : 'text-white/40 hover:text-white hover:bg-white/5 border border-white/10' }}">
                    Berbayar
                </a>
            </div>

            {{-- Grid --}}
            @if ($courses->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($courses as $course)
                        <a href="{{ route('courses.show', $course->slug) }}" wire:navigate
                            class="group card hover:border-white/20 transition-all duration-200">

                            {{-- Thumbnail --}}
                            <div class="aspect-video bg-white/5 overflow-hidden rounded-t-xl relative">
                                @if ($course->thumbnail)
                                    <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}"
                                        class="w-full h-full object-cover opacity-80 group-hover:opacity-100 group-hover:scale-105 transition-all duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-play-circle text-2xl text-white/10"></i>
                                    </div>
                                @endif

                                {{-- Level --}}
                                <div class="absolute top-2.5 right-2.5">
                                    <span
                                        class="text-[10px] px-2 py-0.5 rounded-md font-medium bg-black/60 text-white/60 backdrop-blur-sm">
                                        {{ ucfirst($course->level) }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-4">
                                <div class="flex items-center gap-1.5 mb-2.5">
                                    <span class="badge-secondary">{{ $course->category->name ?? '-' }}</span>
                                </div>

                                <h3
                                    class="text-sm font-medium text-white group-hover:text-white/70 transition-colors line-clamp-2 mb-1.5">
                                    {{ $course->title }}
                                </h3>

                                <p class="text-xs text-white/30 line-clamp-2 leading-relaxed mb-4">
                                    {{ $course->description }}
                                </p>

                                <div class="flex items-center justify-between pt-3 border-t border-white/5">
                                    <span class="text-sm font-semibold text-white">
                                        @if ($course->price == 0)
                                            Gratis
                                        @else
                                            Rp {{ number_format($course->price, 0, ',', '.') }}
                                        @endif
                                    </span>
                                    <span class="text-[11px] text-white/25">
                                        <i class="fas fa-layer-group mr-1"></i>{{ $course->sections->count() }} section
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-10">
                    {{ $courses->links() }}
                </div>
            @else
                <div class="text-center py-20 border border-white/5 rounded-xl">
                    <i class="fas fa-play-circle text-3xl text-white/10 mb-3 block"></i>
                    <p class="text-xs text-white/30">Belum ada kelas tersedia</p>
                </div>
            @endif
        </div>
    </div>
@endsection
