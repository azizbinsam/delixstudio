<div class="relative overflow-hidden pt-10 pb-5 mb-5 border-b border-white/5 bg-zinc-900/30">
    <!-- Blur Background -->
    <div
        class="absolute left-[50px] top-1/2 -translate-y-1/2
                w-[500px] h-[500px] rounded-full
                bg-blue-500/20 blur-[120px]">
    </div>
    <div class="relative z-10 max-w-6xl mx-auto px-6">
        <div class="mb-5">
            <div class="relative z-10">
                <p class="section-label">{{ $label }}</p>
                <h1 class="text-2xl font-semibold tracking-tight text-white mb-2">{{ $title }}</h1>
                <p class="text-xs text-white/30 max-w-md leading-relaxed">{{ $description }}</p>
            </div>
        </div>
    </div>
</div>
