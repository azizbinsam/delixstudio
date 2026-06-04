<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — @yield('title', 'Dashboard') | {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">

    @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js', 'resources/js/admin.js'])
    @livewireStyles
</head>

<body class="bg-zinc-950 text-white antialiased text-sm" x-data="{ sidebarOpen: true }">

    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        <aside :class="sidebarOpen ? 'w-52' : 'w-14'"
            class="bg-[#0A0A0A] border-r border-white/5 flex flex-col transition-all duration-300 flex-shrink-0 overflow-hidden">

            {{-- Logo --}}
            <div class="h-14 flex items-center px-4 border-b border-white/5 flex-shrink-0">
                <a href="{{ route('admin.dashboard') }}" wire:navigate class="overflow-hidden">
                    <span x-show="sidebarOpen" x-cloak x-transition
                        class="text-sm font-semibold text-white tracking-tight whitespace-nowrap">
                        delix<span class="text-white/30">admin</span>
                    </span>
                    <span x-show="!sidebarOpen" x-cloak class="text-sm font-bold text-white">D</span>
                </a>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 p-2 space-y-0.5 overflow-y-auto">
                @php
                    $navItems = [
                        ['route' => 'admin.dashboard', 'icon' => 'fas fa-th-large', 'label' => 'Dashboard'],
                        ['route' => 'admin.courses.index', 'icon' => 'fas fa-play-circle', 'label' => 'Kelas'],
                        ['route' => 'admin.products.index', 'icon' => 'fas fa-box', 'label' => 'Produk'],
                        ['route' => 'admin.categories.index', 'icon' => 'fas fa-tag', 'label' => 'Kategori'],
                        ['route' => 'admin.media.index', 'icon' => 'fas fa-photo-video', 'label' => 'Media'],
                        ['route' => 'admin.orders.index', 'icon' => 'fas fa-receipt', 'label' => 'Pesanan'],
                        ['route' => 'admin.promo-codes.index', 'icon' => 'fas fa-ticket-alt', 'label' => 'Kode Promo'],
                        ['route' => 'admin.users.index', 'icon' => 'fas fa-users', 'label' => 'Users'],
                        [
                            'route' => 'admin.payment-settings.index',
                            'icon' => 'fas fa-credit-card',
                            'label' => 'Pembayaran',
                        ],
                    ];
                @endphp

                @foreach ($navItems as $item)
                    <a href="{{ route($item['route']) }}" wire:navigate
                        class="sidebar-link {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                        <i class="{{ $item['icon'] }} w-3.5 flex-shrink-0 text-center text-xs"></i>
                        <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            {{-- Bottom --}}
            <div class="p-2 border-t border-white/5">
                <a href="{{ route('home') }}" wire:navigate class="sidebar-link">
                    <i class="fas fa-arrow-left w-3.5 flex-shrink-0 text-center text-xs"></i>
                    <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Ke Website</span>
                </a>
            </div>
        </aside>

        {{-- Main --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- Topbar --}}
            <header
                class="h-14 bg-[#0A0A0A] border-b border-white/5 flex items-center justify-between px-5 flex-shrink-0">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="p-1.5 rounded-md text-white/30 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fas fa-bars text-xs"></i>
                    </button>
                    <span class="text-xs font-medium text-white/60">@yield('title', 'Dashboard')</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <div
                        class="w-6 h-6 rounded-full bg-white flex items-center justify-center text-black text-[10px] font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <span class="text-xs text-white/50 hidden sm:block">{{ Auth::user()->name }}</span>
                </div>
            </header>

            {{-- Flash Messages --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="mx-5 mt-4 alert-success">
                    <i class="fas fa-check-circle text-xs"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="mx-5 mt-4 alert-error">
                    <i class="fas fa-exclamation-circle text-xs"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- Content --}}
            <main class="flex-1 overflow-y-auto p-5 bg-zinc-950">
                @yield('content')
            </main>
        </div>
    </div>

    @include('components.confirm-dialog')
    @livewireScripts
    @stack('scripts')

</body>

</html>
