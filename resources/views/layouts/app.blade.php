<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! TwitterCard::generate() !!}

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-DMJB823BE3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-DMJB823BE3');
    </script>

    <title>{{ config('app.name', 'Delix Studio Store') }} - @yield('title', 'Home')</title>
    <link rel="icon" type="image/png" href="/favicon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-zinc-950 text-white antialiased">
    {{-- Promo Banner --}}
    @include('partials.promo-banner')

    {{-- Navbar --}}
    @include('partials.navbar')

    {{-- Flash Messages --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed right-4 z-[150] alert-success shadow-lg max-w-sm" style="top: 5rem;">
            <i class="fas fa-check-circle text-green-600"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed right-4 z-[150] alert-error shadow-lg max-w-sm" style="top: 5rem;">
            <i class="fas fa-exclamation-circle text-red-600"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @livewireScripts

    @stack('scripts')

    <x-confirm-dialog />

    <x-search-modal />

    {{-- WhatsApp Button --}}
    @if (isset($whatsappNumber) && $whatsappNumber)
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsappNumber) }}?text={{ urlencode('Halo, saya ingin bertanya tentang Delix Studio') }}"
            target="_blank"
            class="fixed bottom-6 right-6 z-[90] group flex items-center gap-2.5 transition-all duration-300"
            x-data="{ show: false }" x-init="setTimeout(() => show = true, 1000)" x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100">

            {{-- Label tooltip --}}
            <span
                class="hidden sm:block bg-[#0D0D0D] border border-white/10 text-white/60 text-[11px] font-medium px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-all duration-200 whitespace-nowrap shadow-lg">
                Chat via WhatsApp
            </span>

            {{-- Button --}}
            <div
                class="w-12 h-12 bg-green-500 hover:bg-green-400 rounded-full flex items-center justify-center shadow-lg shadow-green-500/25 hover:shadow-green-500/40 transition-all duration-200 hover:scale-110">
                <i class="fab fa-whatsapp text-white text-[1.8rem]"></i>
            </div>
        </a>
    @endif
</body>

</html>
