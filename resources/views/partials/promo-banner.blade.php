@php
    $activePromo = \App\Models\PromoCode::where('is_active', true)
        ->where('show_in_banner', true)
        ->where(function ($q) {
            $q->whereNull('expired_at')->orWhere('expired_at', '>', now());
        })
        ->where(function ($q) {
            $q->whereNull('max_usage')->orWhereColumn('used_count', '<', 'max_usage');
        })
        ->first();
@endphp

@if ($activePromo)
    <div id="promo-banner" x-data="{ show: false }" x-init="show = !sessionStorage.getItem('promo_dismissed_{{ $activePromo->code }}')" x-show="show" x-cloak
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0" class="bg-white/5 border-b border-white/5">
        <div class="max-w-6xl mx-auto px-6 py-2 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 flex-1 justify-center flex-wrap">
                <span class="text-[11px] text-white/40">Promo aktif</span>

                <div class="flex items-center gap-1.5" x-data="{ copied: false }"
                    @click="
        const code = '{{ $activePromo->code }}';
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(code).then(() => {
                copied = true;
                setTimeout(() => copied = false, 2000);
            });
        } else {
            const el = document.createElement('textarea');
            el.value = code;
            el.style.position = 'fixed';
            el.style.opacity = '0';
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
            copied = true;
            setTimeout(() => copied = false, 2000);
        }
    ">
                    <span
                        class="text-xs font-mono font-semibold text-white bg-white/10 border border-white/10 px-2 py-0.5 rounded-md cursor-pointer hover:bg-white/15 transition-colors">
                        {{ $activePromo->code }}
                    </span>
                    <span x-show="!copied" class="text-[11px] text-white/30 cursor-pointer">
                        <i class="fas fa-copy text-[10px]"></i>
                    </span>
                    <span x-show="copied" class="text-[11px] text-green-400">
                        <i class="fas fa-check text-[10px]"></i> Disalin!
                    </span>
                </div>

                <span class="text-[11px] text-white/60">
                    hemat
                    <span class="text-white font-medium">
                        {{ $activePromo->type === 'percentage'
                            ? $activePromo->value . '%'
                            : 'Rp ' . number_format($activePromo->value, 0, ',', '.') }}
                    </span>
                </span>

                @if ($activePromo->expired_at)
                    <span class="text-[11px] text-white/30 hidden sm:block">
                        · Berakhir {{ $activePromo->expired_at->diffForHumans() }}
                    </span>
                @endif
            </div>

            <button @click="show = false; sessionStorage.setItem('promo_dismissed_{{ $activePromo->code }}', '1')"
                class="text-white/20 hover:text-white transition-colors flex-shrink-0 p-1">
                <i class="fas fa-times text-[10px]"></i>
            </button>
        </div>
    </div>
@endif
