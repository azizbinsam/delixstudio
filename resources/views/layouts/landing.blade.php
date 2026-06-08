<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Go Online – Delix Studio')</title>
    <meta name="description" content="@yield('meta_description', 'Paket jasa pembuatan website profesional mulai Rp 800.000 – desain premium, domain, hosting, dan support langsung.')">
    <link rel="icon" type="image/png" href="/favicon.png">

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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    @stack('head')
</head>

<body class="bg-background text-foreground antialiased">

    {{-- Landing Navbar --}}
    <header class="fixed top-0 left-0 right-0 z-50 border-b border-white/5 bg-background/80 backdrop-blur-md">
        <div class="max-w-5xl mx-auto px-5 h-14 flex items-center justify-between">
            <a href="{{ url('/') }}"
                class="flex items-center gap-2 text-white font-semibold text-sm tracking-tight">
                <img src="/favicon.png" alt="Delix Studio" class="w-6 h-6 rounded">
                <span>Delix Studio</span>
            </a>
            <a href="#cta" class="btn btn-primary btn-lg text-sm px-5 py-2">
                Pesan Sekarang
            </a>
        </div>
    </header>

    <main class="pt-4">
        @yield('content')
    </main>

    {{-- SOCIAL PROOF POPUP --}}
    <div id="proof-popup" class="fixed z-50 pointer-events-none"
        style="bottom: 20px; left: 20px; width: 280px; transform: translateY(150%); opacity: 0; transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s ease;">
        <div
            style="display:flex; align-items:center; gap:12px; padding:14px 16px; background:#111; border:1px solid rgba(255,255,255,0.1); border-radius:14px; box-shadow:0 20px 40px rgba(0,0,0,0.6);">
            <div id="proof-avatar"
                style="width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:700; flex-shrink:0; background:rgba(255,255,255,0.1); color:white;">
            </div>
            <div style="flex:1; min-width:0;">
                <p id="proof-name"
                    style="font-size:12px; font-weight:600; color:white; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin:0;">
                </p>
                <p style="font-size:11px; color:rgba(255,255,255,0.5); margin:3px 0 0 0;">membeli <span
                        style="color:rgba(255,255,255,0.75);">Paket Go Online</span></p>
                <p id="proof-time" style="font-size:10px; color:rgba(255,255,255,0.3); margin:2px 0 0 0;"></p>
            </div>
            <button onclick="hideProof()"
                style="color:rgba(255,255,255,0.25); flex-shrink:0; background:none; border:none; cursor:pointer; font-size:12px; padding:4px; line-height:1;">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    @livewireScripts
    @stack('scripts')
</body>

</html>
