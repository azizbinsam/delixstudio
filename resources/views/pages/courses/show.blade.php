@extends('layouts.app')

@section('title', $course->title)

@section('content')
    <div class="pt-10 pb-20">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                {{-- Left --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- Breadcrumb --}}
                    <div class="flex items-center gap-2 text-xs text-white/30">
                        <a href="{{ route('courses.index') }}" wire:navigate
                            class="hover:text-white transition-colors">Kelas</a>
                        <i class="fas fa-chevron-right text-[10px]"></i>
                        <span class="text-white/50 truncate">{{ $course->title }}</span>
                    </div>

                    {{-- Overview Video --}}
                    @if ($course->overview_video)
                        <div x-data="{ playing: false }">
                            <div class="aspect-video rounded-xl overflow-hidden bg-black relative">
                                @php
                                    $url = $course->overview_video;
                                    $videoId = null;

                                    if (
                                        preg_match(
                                            '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&\n?#]+)/',
                                            $url,
                                            $matches,
                                        )
                                    ) {
                                        $videoId = $matches[1];
                                    } elseif (preg_match('/^[a-zA-Z0-9_-]{11}$/', trim($url))) {
                                        $videoId = trim($url);
                                    }
                                @endphp
                                {{-- Thumbnail (custom system) --}}
                                <template x-if="!playing">
                                    <div class="relative w-full h-full cursor-pointer" @click="playing = true">
                                        <img src="{{ $course->thumbnail ? Storage::url($course->thumbnail) : 'https://img.youtube.com/vi/' . $videoId . '/hqdefault.jpg' }}"
                                            class="w-full h-full object-cover opacity-80" alt="Video Thumbnail">

                                        {{-- overlay dark --}}
                                        <div class="absolute inset-0 bg-black/40"></div>

                                        {{-- play button --}}
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <button
                                                class="w-16 h-16 rounded-full bg-black/50 hover:bg-black/40 flex items-center justify-center backdrop-blur transition">
                                                <i class="fas fa-play text-white/50 text-xl ml-1"></i>
                                            </button>
                                        </div>
                                    </div>
                                </template>

                                {{-- YouTube iframe (after click) --}}
                                <template x-if="playing">
                                    <iframe src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1"
                                        class="w-full h-full" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                                </template>

                            </div>
                        </div>
                    @endif

                    {{-- Meta --}}
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="badge-secondary">{{ $course->category->name ?? '-' }}</span>
                            <span class="badge-secondary capitalize">{{ $course->level }}</span>
                        </div>
                        <h1 class="text-2xl font-semibold tracking-tight text-white mb-3">{{ $course->title }}</h1>
                        <p class="text-sm text-white/40 leading-relaxed">{{ $course->description }}</p>
                    </div>

                    {{-- Tools --}}
                    @if ($course->tools->count() > 0)
                        <div>
                            <p class="text-xs font-medium text-white/40 uppercase tracking-widest mb-3">Tools yang Digunakan
                            </p>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($course->tools as $tool)
                                    @if ($tool->url)
                                        <a href="{{ $tool->url }}" target="_blank" rel="noopener noreferrer"
                                            class="flex items-center gap-1.5 bg-white/5 border border-white/10 hover:border-white/20 hover:bg-white/10 px-3 py-1.5 rounded-md transition-all group">
                                            @if ($tool->icon)
                                                <i
                                                    class="{{ $tool->icon }} text-xs text-white/50 group-hover:text-white/70 transition-colors"></i>
                                            @endif
                                            <span
                                                class="text-xs text-white/60 group-hover:text-white/80 transition-colors">{{ $tool->name }}</span>
                                            <i
                                                class="fas fa-external-link-alt text-[9px] text-white/20 group-hover:text-white/40 transition-colors"></i>
                                        </a>
                                    @else
                                        <div
                                            class="flex items-center gap-1.5 bg-white/5 border border-white/10 px-3 py-1.5 rounded-md">
                                            @if ($tool->icon)
                                                <i class="{{ $tool->icon }} text-xs text-white/50"></i>
                                            @endif
                                            <span class="text-xs text-white/60">{{ $tool->name }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Curriculum --}}
                    <div>
                        <p class="text-xs font-medium text-white/40 uppercase tracking-widest mb-3">Kurikulum</p>
                        <div class="space-y-2" x-data="{ openSection: 0 }">
                            @foreach ($course->sections as $index => $section)
                                <div class="border border-white/10 rounded-xl overflow-hidden">
                                    <button
                                        @click="openSection = openSection === {{ $index }} ? null : {{ $index }}"
                                        class="w-full flex items-center justify-between px-4 py-3 text-left hover:bg-white/5 transition-colors">
                                        <div class="flex items-center gap-3">
                                            <span class="text-xs text-white/20 font-mono w-4">{{ $index + 1 }}</span>
                                            <span class="text-sm font-medium text-white">{{ $section->title }}</span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="text-[11px] text-white/25">{{ $section->chapters->count() }}
                                                chapter</span>
                                            <i class="fas fa-chevron-down text-[10px] text-white/30 transition-transform duration-200"
                                                :class="openSection === {{ $index }} ? 'rotate-180' : ''"></i>
                                        </div>
                                    </button>

                                    <div x-show="openSection === {{ $index }}"
                                        x-transition:enter="transition ease-out duration-150"
                                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                        class="border-t border-white/5">
                                        @foreach ($section->chapters as $ch)
                                            <div
                                                class="flex items-center justify-between px-5 py-2.5 hover:bg-white/5 transition-colors">
                                                <div class="flex items-center gap-3">
                                                    @if ($hasPurchased || $ch->is_free)
                                                        <a href="{{ route('courses.learn', [$course->slug, $ch->id]) }}"
                                                            wire:navigate class="flex items-center gap-3 group">
                                                            <i
                                                                class="fas fa-play-circle text-[11px] text-white/40 group-hover:text-white transition-colors"></i>
                                                            <span
                                                                class="text-xs text-white/50 group-hover:text-white transition-colors">{{ $ch->title }}</span>
                                                        </a>
                                                    @else
                                                        <i class="fas fa-lock text-[11px] text-white/20"></i>
                                                        <span class="text-xs text-white/30">{{ $ch->title }}</span>
                                                    @endif
                                                    @if ($ch->is_free)
                                                        <span class="badge-success text-[10px]">Gratis</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Right: Sticky Card --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-24 card">

                        {{-- Thumbnail --}}
                        @if ($course->thumbnail)
                            <div class="aspect-video rounded-t-xl overflow-hidden">
                                <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}"
                                    class="w-full h-full object-cover opacity-80">
                            </div>
                        @endif

                        <div class="p-5">
                            {{-- Price --}}
                            <div class="text-2xl font-semibold text-white mb-5">
                                @if ($course->price == 0)
                                    Gratis
                                @else
                                    Rp {{ number_format($course->price, 0, ',', '.') }}
                                @endif
                            </div>

                            @if ($hasPurchased)
                                <div class="alert-success mb-3 text-xs">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Kamu sudah memiliki kelas ini</span>
                                </div>

                                {{-- Tombol Mulai Belajar --}}
                                @php
                                    $firstChapter = $course->sections->first()?->chapters->first();
                                @endphp
                                @if ($firstChapter)
                                    <a href="{{ route('courses.learn', [$course->slug, $firstChapter->id]) }}"
                                        wire:navigate class="w-full btn-primary btn btn-lg justify-center mb-3">
                                        <i class="fas fa-play-circle"></i> Mulai Belajar
                                    </a>
                                @endif

                                @if ($course->whatsapp_group)
                                    <a href="{{ $course->whatsapp_group }}" target="_blank"
                                        class="w-full flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white text-xs font-medium py-2 rounded-lg transition-colors">
                                        <i class="fab fa-whatsapp"></i> Gabung Grup Diskusi
                                    </a>
                                @endif
                            @else
                                @auth
                                    <a href="{{ route('user.checkout.course', $course) }}" wire:navigate
                                        class="w-full btn-primary btn btn-lg justify-center">
                                        Gabung Kelas
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" wire:navigate
                                        class="w-full btn-primary btn btn-lg justify-center">
                                        Masuk untuk Membeli
                                    </a>
                                @endauth
                            @endif

                            {{-- Info --}}
                            <div class="mt-5 pt-5 border-t border-white/5 space-y-2.5">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-white/30">Total Section</span>
                                    <span class="text-xs text-white/60">{{ $course->sections->count() }} section</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-white/30">Total Chapter</span>
                                    <span class="text-xs text-white/60">
                                        {{ $course->sections->sum(fn($s) => $s->chapters->count()) }} chapter
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-white/30">Level</span>
                                    <span class="text-xs text-white/60 capitalize">{{ $course->level }}</span>
                                </div>
                                @if ($course->whatsapp_group)
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-white/30">Diskusi</span>
                                        <span class="text-xs text-green-400 flex items-center gap-1">
                                            <i class="fab fa-whatsapp"></i> WhatsApp Group
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
