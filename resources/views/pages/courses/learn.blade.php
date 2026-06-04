@extends('layouts.learn')

@section('title', $chapter->title . ' — ' . $course->title)

@section('content')
    @php
        $totalChapters = $course->sections->sum(fn($s) => $s->chapters->count());
        $completedCount = count($completedChapterIds);
        $progressPercent = $totalChapters > 0 ? round(($completedCount / $totalChapters) * 100) : 0;
        $isCurrentCompleted = in_array($chapter->id, $completedChapterIds);
        $activeSectionIndex = $course->sections->search(fn($s) => $s->chapters->contains('id', $chapter->id)) ?? 0;

        $url = $chapter->youtube_url ?? '';
        $videoId = null;
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&\n?#]+)/', $url, $matches)) {
            $videoId = $matches[1];
        } elseif (preg_match('/^[a-zA-Z0-9_-]{11}$/', trim($url))) {
            $videoId = trim($url);
        }
    @endphp

    {{-- Main wrapper dengan Alpine untuk bottom sheet --}}
    <div x-data="{ openSection: {{ $activeSectionIndex }}, showChapters: false }">

        {{-- Breadcrumb --}}
        <div class="border-b border-white/[0.06] bg-[#010101]">
            <div class="max-w-6xl mx-auto px-4 lg:px-6 h-9 flex items-center gap-2">
                <a href="{{ route('courses.index') }}" wire:navigate
                    class="text-[11px] text-white/25 hover:text-white/60 transition-colors hidden sm:block">Kelas</a>
                <i class="fas fa-chevron-right text-[8px] text-white/15 hidden sm:block"></i>
                <a href="{{ route('courses.show', $course->slug) }}" wire:navigate
                    class="text-[11px] text-white/25 hover:text-white/60 transition-colors truncate max-w-[120px] sm:max-w-[180px]">
                    {{ $course->title }}
                </a>
                <i class="fas fa-chevron-right text-[8px] text-white/15"></i>
                <span class="text-[11px] text-white/50 truncate max-w-[120px] sm:max-w-[200px]">{{ $chapter->title }}</span>
            </div>
        </div>

        {{-- Layout --}}
        <div class="max-w-6xl mx-auto px-4 lg:px-6 py-4 lg:py-6">
            <div class="flex gap-6 items-start">

                {{-- ========================
                 SIDEBAR — Desktop Only
            ======================== --}}
                <aside x-data="{ openSection: {{ $activeSectionIndex }} }" class="hidden lg:block w-72 flex-shrink-0 sticky top-6"
                    style="max-height: calc(100vh - 7rem); overflow-y: auto;">

                    {{-- Header card --}}
                    <div class="card mb-3 p-4">
                        <a href="{{ route('courses.show', $course->slug) }}" wire:navigate
                            class="inline-flex items-center gap-1.5 text-[11px] text-white/30 hover:text-white/60 transition-colors mb-3">
                            <i class="fas fa-arrow-left text-[9px]"></i> Kembali ke kelas
                        </a>
                        <p class="text-xs font-semibold text-white/80 leading-snug line-clamp-2 mb-3">
                            {{ $course->title }}
                        </p>
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-[10px] text-white/25">Progress</span>
                                <span class="text-[10px] font-medium text-white/45 tabular-nums">
                                    {{ $completedCount }}/{{ $totalChapters }}
                                </span>
                            </div>
                            <div class="h-[3px] bg-white/[0.06] rounded-full overflow-hidden">
                                <div class="h-full bg-white/50 rounded-full transition-all duration-700"
                                    style="width: {{ $progressPercent }}%"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Sections & Chapters --}}
                    <div class="card overflow-hidden">
                        @foreach ($course->sections as $index => $section)
                            @php
                                $sectionChapterIds = $section->chapters->pluck('id')->toArray();
                                $sectionCompleted = count(array_intersect($sectionChapterIds, $completedChapterIds));
                                $sectionTotal = count($sectionChapterIds);
                                $sectionDone = $sectionCompleted === $sectionTotal && $sectionTotal > 0;
                            @endphp
                            <div class="{{ $index > 0 ? 'border-t border-white/[0.05]' : '' }}">
                                <button
                                    @click="openSection = openSection === {{ $index }} ? null : {{ $index }}"
                                    class="w-full flex items-center justify-between px-4 py-3 hover:bg-white/[0.03] transition-colors text-left">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <span
                                            class="text-[10px] text-white/20 font-mono w-4 flex-shrink-0 text-right tabular-nums">
                                            {{ $index + 1 }}
                                        </span>
                                        <span class="text-[11px] font-medium text-white/55 truncate">
                                            {{ $section->title }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2 flex-shrink-0 ml-2">
                                        @if ($sectionDone)
                                            <i class="fas fa-check-circle text-[10px] text-green-400/70"></i>
                                        @else
                                            <span class="text-[10px] text-white/20 tabular-nums">
                                                {{ $sectionCompleted }}/{{ $sectionTotal }}
                                            </span>
                                        @endif
                                        <i class="fas fa-chevron-right text-[9px] text-white/15 transition-transform duration-200"
                                            :class="openSection === {{ $index }} ? 'rotate-90' : ''"></i>
                                    </div>
                                </button>
                                <div x-show="openSection === {{ $index }}"
                                    x-transition:enter="transition ease-out duration-150"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                                    @foreach ($section->chapters as $ch)
                                        @php $isCompleted = in_array($ch->id, $completedChapterIds); @endphp
                                        <a href="{{ route('courses.learn', [$course->slug, $ch->id]) }}" wire:navigate
                                            class="flex items-center gap-3 pl-9 pr-4 py-2.5 transition-all relative border-t border-white/[0.03]
                                        {{ $ch->id === $chapter->id
                                            ? 'bg-white/[0.06] text-white'
                                            : 'text-white/30 hover:bg-white/[0.03] hover:text-white/55' }}">
                                            @if ($ch->id === $chapter->id)
                                                <span
                                                    class="absolute left-0 top-1/2 -translate-y-1/2 w-[3px] h-5 bg-white/70 rounded-r-full"></span>
                                            @endif
                                            <div class="flex-shrink-0 w-3 flex items-center justify-center">
                                                @if ($isCompleted)
                                                    <i class="fas fa-check-circle text-[10px] text-green-400/80"></i>
                                                @elseif($ch->id === $chapter->id)
                                                    <i class="fas fa-play text-[8px] text-white ml-0.5"></i>
                                                @elseif($hasPurchased || $ch->is_free)
                                                    <i class="fas fa-play text-[8px] opacity-15 ml-0.5"></i>
                                                @else
                                                    <i class="fas fa-lock text-[9px] opacity-15"></i>
                                                @endif
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p
                                                    class="text-[11px] leading-snug line-clamp-2
                                                {{ $isCompleted ? 'line-through decoration-white/15 text-white/25' : '' }}">
                                                    {{ $ch->title }}
                                                </p>
                                                @if ($ch->is_free && !$hasPurchased)
                                                    <span class="text-[10px] text-green-400/70 mt-0.5 block">Gratis</span>
                                                @endif
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </aside>

                {{-- ========================
                 MAIN CONTENT
            ======================== --}}
                <div class="flex-1 min-w-0">

                    {{-- Video --}}
                    <div class="rounded-xl overflow-hidden bg-black mb-4 border border-white/[0.06]">
                        @if ($videoId)
                            <div class="aspect-video w-full">
                                <iframe
                                    src="https://www.youtube.com/embed/{{ $videoId }}?rel=0&modestbranding=1&color=white"
                                    class="w-full h-full" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        @else
                            <div class="aspect-video w-full flex items-center justify-center bg-white/[0.02]">
                                <div class="text-center">
                                    <i class="fas fa-video-slash text-2xl text-white/10 mb-3 block"></i>
                                    <p class="text-xs text-white/20">Video tidak tersedia</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Navigasi + Tandai Selesai --}}
                    <div class="flex items-center justify-between gap-3 flex-wrap mb-5">
                        <div class="flex items-center gap-2">
                            @if ($prevChapter)
                                <a href="{{ route('courses.learn', [$course->slug, $prevChapter->id]) }}" wire:navigate
                                    class="btn btn-outline btn-sm">
                                    <i class="fas fa-chevron-left text-[9px]"></i>
                                    <span>Sebelumnya</span>
                                </a>
                            @endif
                            @if ($nextChapter)
                                <a href="{{ route('courses.learn', [$course->slug, $nextChapter->id]) }}" wire:navigate
                                    class="btn btn-primary btn-sm">
                                    <span>Berikutnya</span>
                                    <i class="fas fa-chevron-right text-[9px]"></i>
                                </a>
                            @endif
                        </div>

                        {{-- Tandai Selesai --}}
                        <div x-data="{ completed: {{ $isCurrentCompleted ? 'true' : 'false' }}, loading: false }">
                            <button
                                @click="
                                if (!completed) {
                                    loading = true;
                                    fetch('{{ route('user.courses.progress', [$course->slug, $chapter->id]) }}', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json',
                                        }
                                    })
                                    .then(r => r.json())
                                    .then(d => { if (d.success) { completed = true; loading = false; } })
                                    .catch(() => { loading = false; });
                                }
                            "
                                :disabled="completed || loading"
                                :class="completed
                                    ?
                                    'bg-green-500/10 border border-green-500/20 text-green-400 cursor-default' :
                                    'btn-outline hover:border-green-500/40 hover:text-green-400'"
                                class="btn btn-sm gap-1.5 transition-all">
                                <template x-if="loading">
                                    <i class="fas fa-spinner fa-spin text-[10px]"></i>
                                </template>
                                <template x-if="!loading && completed">
                                    <i class="fas fa-check-circle text-[10px]"></i>
                                </template>
                                <template x-if="!loading && !completed">
                                    <i class="fas fa-circle text-[10px]"></i>
                                </template>
                                <span x-text="completed ? 'Selesai' : 'Tandai Selesai'"></span>
                            </button>
                        </div>
                    </div>

                    {{-- Judul & Deskripsi --}}
                    <div class="mb-5">
                        <p class="text-[11px] text-white/25 mb-1">{{ $course->title }}</p>
                        <h1 class="text-base font-semibold text-white tracking-tight mb-2">
                            {{ $chapter->title }}
                        </h1>
                        @if ($chapter->description)
                            <p class="text-sm text-white/40 leading-relaxed">{{ $chapter->description }}</p>
                        @endif
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

                    {{-- WhatsApp Group --}}
                    @if ($course->whatsapp_group && $hasPurchased)
                        <div
                            class="flex items-center justify-between p-4 bg-white/[0.03] border border-white/[0.06] rounded-xl">
                            <div>
                                <p class="text-xs font-medium text-white">Ada pertanyaan?</p>
                                <p class="text-[11px] text-white/35 mt-0.5">Diskusi di grup bersama instruktur & member</p>
                            </div>
                            <a href="{{ $course->whatsapp_group }}" target="_blank"
                                class="flex items-center gap-1.5 px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-lg transition-colors flex-shrink-0 ml-4">
                                <i class="fab fa-whatsapp"></i>
                                <span class="hidden sm:inline">Grup Diskusi</span>
                            </a>
                        </div>
                    @endif

                    {{-- Spacer untuk floating button mobile --}}
                    <div class="h-20 lg:hidden"></div>
                    <div class="h-12 hidden lg:block"></div>
                </div>
            </div>
        </div>

        {{-- ========================
         MOBILE: Floating Button
    ======================== --}}
        <div class="lg:hidden fixed bottom-4 left-1/2 -translate-x-1/2 z-[200]">
            <button @click="showChapters = true"
                class="flex items-center gap-2.5 px-4 py-2.5 bg-[#0D0D0D] border border-white/15 rounded-full shadow-2xl text-xs font-medium text-white/70 hover:text-white hover:border-white/25 transition-all">
                <div class="flex items-center gap-1.5">
                    <i class="fas fa-list text-[10px]"></i>
                    <span>Materi Kelas</span>
                </div>
                <div class="w-px h-3 bg-white/10"></div>
                <div class="flex items-center gap-1">
                    <span
                        class="text-[10px] text-white/40 tabular-nums">{{ $completedCount }}/{{ $totalChapters }}</span>
                </div>
                {{-- Progress mini --}}
                <div class="w-16 h-1 bg-white/10 rounded-full overflow-hidden">
                    <div class="h-full bg-white/50 rounded-full" style="width: {{ $progressPercent }}%"></div>
                </div>
            </button>
        </div>

        {{-- ========================
         MOBILE: Bottom Sheet Modal
    ======================== --}}
        <div class="lg:hidden" x-show="showChapters" style="display: none;">

            {{-- Backdrop --}}
            <div class="fixed inset-0 z-[210] bg-black/60 backdrop-blur-sm"
                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="showChapters = false">
            </div>

            {{-- Bottom Sheet --}}
            <div class="fixed bottom-0 left-0 right-0 z-[215] bg-[#0D0D0D] border-t border-white/10 rounded-t-2xl"
                style="height: 60vh;" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-y-0"
                x-transition:leave-end="translate-y-full">

                {{-- Handle --}}
                <div class="flex justify-center pt-3 pb-1">
                    <div class="w-10 h-1 bg-white/20 rounded-full"></div>
                </div>

                {{-- Header --}}
                <div class="px-4 py-3 border-b border-white/5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-white/80 line-clamp-1">{{ $course->title }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            <div class="h-1 w-24 bg-white/10 rounded-full overflow-hidden">
                                <div class="h-full bg-white/50 rounded-full" style="width: {{ $progressPercent }}%">
                                </div>
                            </div>
                            <span class="text-[10px] text-white/30 tabular-nums">
                                {{ $completedCount }}/{{ $totalChapters }} selesai
                            </span>
                        </div>
                    </div>
                    <button @click="showChapters = false"
                        class="p-1.5 rounded-lg text-white/30 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>

                {{-- Scrollable Content --}}
                <div class="overflow-y-auto h-[calc(60vh-80px)]" x-data="{ openSection: {{ $activeSectionIndex }} }">
                    @foreach ($course->sections as $index => $section)
                        @php
                            $sectionChapterIds = $section->chapters->pluck('id')->toArray();
                            $sectionCompleted = count(array_intersect($sectionChapterIds, $completedChapterIds));
                            $sectionTotal = count($sectionChapterIds);
                            $sectionDone = $sectionCompleted === $sectionTotal && $sectionTotal > 0;
                        @endphp
                        <div class="{{ $index > 0 ? 'border-t border-white/[0.05]' : '' }}">

                            {{-- Section Toggle --}}
                            <button
                                @click="openSection = openSection === {{ $index }} ? null : {{ $index }}"
                                class="w-full flex items-center justify-between px-4 py-3 hover:bg-white/[0.03] transition-colors text-left">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <span
                                        class="text-[10px] text-white/20 font-mono w-4 flex-shrink-0 text-right tabular-nums">
                                        {{ $index + 1 }}
                                    </span>
                                    <span class="text-[11px] font-medium text-white/55 truncate">
                                        {{ $section->title }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2 flex-shrink-0 ml-2">
                                    @if ($sectionDone)
                                        <i class="fas fa-check-circle text-[10px] text-green-400/70"></i>
                                    @else
                                        <span class="text-[10px] text-white/20 tabular-nums">
                                            {{ $sectionCompleted }}/{{ $sectionTotal }}
                                        </span>
                                    @endif
                                    <i class="fas fa-chevron-right text-[9px] text-white/15 transition-transform duration-200"
                                        :class="openSection === {{ $index }} ? 'rotate-90' : ''"></i>
                                </div>
                            </button>

                            {{-- Chapters --}}
                            <div x-show="openSection === {{ $index }}"
                                x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100">
                                @foreach ($section->chapters as $ch)
                                    @php $isCompleted = in_array($ch->id, $completedChapterIds); @endphp
                                    <a href="{{ route('courses.learn', [$course->slug, $ch->id]) }}" wire:navigate
                                        @click="showChapters = false"
                                        class="flex items-center gap-3 pl-9 pr-4 py-3 transition-all relative border-t border-white/[0.03]
                                    {{ $ch->id === $chapter->id
                                        ? 'bg-white/[0.06] text-white'
                                        : 'text-white/30 hover:bg-white/[0.03] hover:text-white/55' }}">

                                        @if ($ch->id === $chapter->id)
                                            <span
                                                class="absolute left-0 top-1/2 -translate-y-1/2 w-[3px] h-6 bg-white/70 rounded-r-full"></span>
                                        @endif

                                        <div class="flex-shrink-0 w-3 flex items-center justify-center">
                                            @if ($isCompleted)
                                                <i class="fas fa-check-circle text-[10px] text-green-400/80"></i>
                                            @elseif($ch->id === $chapter->id)
                                                <i class="fas fa-play text-[8px] text-white ml-0.5"></i>
                                            @elseif($hasPurchased || $ch->is_free)
                                                <i class="fas fa-play text-[8px] opacity-15 ml-0.5"></i>
                                            @else
                                                <i class="fas fa-lock text-[9px] opacity-15"></i>
                                            @endif
                                        </div>

                                        <div class="min-w-0 flex-1">
                                            <p
                                                class="text-[11px] leading-snug line-clamp-2
                                            {{ $isCompleted ? 'line-through decoration-white/15 text-white/25' : '' }}">
                                                {{ $ch->title }}
                                            </p>
                                            @if ($ch->is_free && !$hasPurchased)
                                                <span class="text-[10px] text-green-400/70 mt-0.5 block">Gratis</span>
                                            @endif
                                        </div>

                                        @if ($ch->id === $chapter->id)
                                            <span class="text-[10px] text-white/30 flex-shrink-0">Sedang diputar</span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
