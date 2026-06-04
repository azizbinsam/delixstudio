<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('code') — @yield('title') | {{ config('app.name', 'Delix Studio Store') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#010101] text-white antialiased min-h-screen flex flex-col items-center justify-center p-6">

    {{-- Background grid subtle --}}
    <div class="fixed inset-0 pointer-events-none"
        style="background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px); background-size: 48px 48px;">
    </div>

    {{-- Glow di tengah --}}
    <div class="fixed inset-0 pointer-events-none flex items-center justify-center">
        <div class="w-[600px] h-[600px] rounded-full opacity-[0.03]"
            style="background: radial-gradient(circle, @yield('glow-color', '#ffffff') 0%, transparent 70%);">
        </div>
    </div>

    <div class="relative z-10 w-full max-w-md text-center">

        {{-- Kode besar di belakang --}}
        <div class="relative select-none mb-2">
            <p class="font-display text-[140px] leading-none text-white/[0.04] tracking-widest">
                @yield('code')
            </p>
            {{-- Icon overlay di tengah angka --}}
            <div class="absolute inset-0 flex items-center justify-center">
                <div
                    class="w-14 h-14 rounded-2xl flex items-center justify-center border border-white/10 bg-white/5 backdrop-blur-sm">
                    @yield('icon')
                </div>
            </div>
        </div>

        {{-- Teks --}}
        <h1 class="text-lg font-semibold text-white tracking-tight mb-2">
            @yield('title')
        </h1>
        <p class="text-sm text-white/35 leading-relaxed mb-8 max-w-xs mx-auto">
            @yield('description')
        </p>

        {{-- Divider tipis --}}
        <div class="flex items-center gap-3 mb-8">
            <div class="flex-1 h-px bg-white/5"></div>
            <span class="text-[10px] text-white/20 font-medium tracking-widest uppercase">
                @yield('code') Error
            </span>
            <div class="flex-1 h-px bg-white/5"></div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-center gap-2 flex-wrap">
            @yield('actions')
        </div>

        {{-- App name --}}
        <p class="mt-12 text-[11px] text-white/15">
            &copy; {{ date('Y') }} {{ config('app.name', 'Delix Studio') }}
        </p>

    </div>

</body>

</html>
