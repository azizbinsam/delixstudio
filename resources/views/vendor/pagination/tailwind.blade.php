@if ($paginator->hasPages())
    <nav class="flex items-center justify-between" role="navigation">

        {{-- Info --}}
        <div class="text-xs text-white/30">
            Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }}
            dari {{ $paginator->total() }} data
        </div>

        {{-- Links --}}
        <div class="flex items-center gap-1">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="px-2.5 py-1.5 rounded-md text-xs text-white/20 cursor-not-allowed">
                    <i class="fas fa-chevron-left text-[10px]"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="px-2.5 py-1.5 rounded-md text-xs text-white/40 hover:text-white hover:bg-white/5 transition-colors">
                    <i class="fas fa-chevron-left text-[10px]"></i>
                </a>
            @endif

            {{-- Pages --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-2.5 py-1.5 text-xs text-white/20">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-2.5 py-1.5 rounded-md text-xs bg-white text-black font-medium">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                                class="px-2.5 py-1.5 rounded-md text-xs text-white/40 hover:text-white hover:bg-white/5 transition-colors">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="px-2.5 py-1.5 rounded-md text-xs text-white/40 hover:text-white hover:bg-white/5 transition-colors">
                    <i class="fas fa-chevron-right text-[10px]"></i>
                </a>
            @else
                <span class="px-2.5 py-1.5 rounded-md text-xs text-white/20 cursor-not-allowed">
                    <i class="fas fa-chevron-right text-[10px]"></i>
                </span>
            @endif
        </div>
    </nav>
@endif
