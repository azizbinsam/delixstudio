@props([
    'testimonials' => [],
])

@php
    $col1 = [$testimonials[0], $testimonials[3], $testimonials[6]];
    $col2 = [$testimonials[1], $testimonials[4], $testimonials[7]];
    $col3 = [$testimonials[2], $testimonials[5], $testimonials[8]];

    $renderCard = function ($t) {
        $initials = strtoupper(substr($t['name'], 0, 1) . substr(strrchr($t['name'], ' '), 1, 1));
        return ['initials' => $initials, 't' => $t];
    };
@endphp

<section class="py-16">
    <div class="max-w-6xl mx-auto px-6 mb-10">
        <p class="section-label">Testimoni</p>
        <h2 class="section-title">Dipercaya developer WordPress Indonesia</h2>
    </div>

    <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4"
            style="
        height: 480px;
        overflow: hidden;
        mask: linear-gradient(to bottom, transparent, black 10%, black 90%, transparent);
        -webkit-mask: linear-gradient(to bottom, transparent, black 10%, black 90%, transparent);
    ">
            @foreach ([['cards' => $col1, 'speed' => 'col-fast'], ['cards' => $col2, 'speed' => 'col-slow'], ['cards' => $col3, 'speed' => 'col-fast']] as $index => $col)
                <div class="testimonial-col {{ $col['speed'] }} {{ $index > 0 ? 'hidden md:flex' : '' }}">
                    @foreach (array_merge($col['cards'], $col['cards'], $col['cards']) as $t)
                        @php $initials = strtoupper(substr($t['name'], 0, 1) . substr(strrchr($t['name'], ' '), 1, 1)) @endphp
                        <div class="testimonial-card">
                            <p class="text-xs text-white/40 leading-relaxed mb-3">"{{ $t['review'] }}"</p>
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-7 h-7 rounded-full bg-white/10 flex items-center justify-center text-[10px] font-medium text-white/50 flex-shrink-0">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-white leading-none">{{ $t['name'] }}</p>
                                    <p class="text-[11px] text-white/30 mt-0.5">{{ $t['role'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</section>
@push('scripts')
    <script>
        // Simpan controller agar tidak numpuk
        if (window._testimonialController) {
            window._testimonialController.abort();
        }
        window._testimonialController = new AbortController();

        function initTestimonial() {
            document.querySelectorAll('.testimonial-col').forEach(col => {
                // Reset animasi lama dulu
                col.style.animation = '';

                if (getComputedStyle(col).display === 'none') return;

                const cards = col.querySelectorAll('.testimonial-card');
                const setSize = cards.length / 3;
                const gap = 12;

                let setHeight = 0;
                for (let i = 0; i < setSize; i++) {
                    setHeight += cards[i].offsetHeight + gap;
                }

                const duration = col.classList.contains('col-slow') ? 22 : 14;
                const id = 'kf_' + Math.random().toString(36).slice(2, 8);

                const style = document.createElement('style');
                style.textContent = `
                @keyframes ${id} {
                    from { transform: translateY(0); }
                    to   { transform: translateY(-${setHeight}px); }
                }
            `;
                document.head.appendChild(style);
                col.style.animation = `${id} ${duration}s linear infinite`;
            });
        }

        // Pertama load
        initTestimonial();

        // Saat wire:navigate
        document.addEventListener('livewire:navigated', () => {
            initTestimonial();
        }, {
            signal: window._testimonialController.signal
        });
    </script>
@endpush
