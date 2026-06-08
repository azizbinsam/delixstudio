<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Go Online – Delix Studio')</title>
    <meta name="description" content="@yield('meta_description', 'Paket jasa pembuatan website profesional mulai Rp 800.000 – desain premium, domain, hosting, dan support langsung.')">
    <link rel="icon" type="image/png" href="/favicon.png">

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

    @livewireScripts
    @stack('scripts')
</body>

</html>
