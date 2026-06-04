<nav class="sticky top-0 z-[100] bg-zinc-950 backdrop-blur-sm border-b border-white/5" x-data="{ mobileOpen: false }">
    <div class="max-w-6xl mx-auto px-6">
        <div class="relative flex items-center justify-between h-14">

            {{-- Logo --}}
            <a href="{{ route('home') }}" wire:navigate class="text-sm font-semibold text-white tracking-tight">
                delix<span class="text-white/40">studio</span>
            </a>

            {{-- Desktop Menu --}}
            <div class="hidden md:flex items-center gap-0.5 absolute left-1/2 -translate-x-1/2">
                <a href="{{ route('home') }}" wire:navigate
                    class="px-3 py-1.5 rounded-md text-xs transition-colors
                    {{ request()->routeIs('home') ? 'text-white bg-white/10' : 'text-white/40 hover:text-white hover:bg-white/5' }}">
                    Home
                </a>
                <a href="{{ route('courses.index') }}" wire:navigate
                    class="px-3 py-1.5 rounded-md text-xs transition-colors
                    {{ request()->routeIs('courses.*') ? 'text-white bg-white/10' : 'text-white/40 hover:text-white hover:bg-white/5' }}">
                    Kelas
                </a>
                <a href="{{ route('products.index') }}" wire:navigate
                    class="px-3 py-1.5 rounded-md text-xs transition-colors
                    {{ request()->routeIs('products.*') ? 'text-white bg-white/10' : 'text-white/40 hover:text-white hover:bg-white/5' }}">
                    Produk
                </a>
            </div>

            {{-- Right --}}
            <div class="hidden md:flex items-center gap-2">

                {{-- Search --}}
                <button @click="$dispatch('open-search')"
                    class="flex items-center gap-2 w-40 px-2.5 py-1.5 rounded-md bg-white/5 border border-white/10 
           hover:bg-white/10 hover:border-white/20 transition-all group">
                    <i class="fas fa-search text-[10px] text-white/40 group-hover:text-white/60 transition-colors"></i>
                    <span
                        class="text-xs text-white/30 group-hover:text-white/50 transition-colors flex-1 text-left">Cari...</span>
                    <kbd
                        class="text-[9px] text-white/25 bg-white/5 border border-white/10 rounded px-1.5 py-0.5 font-sans leading-none">⌘K</kbd>
                </button>

                @auth
                    {{-- Cart --}}
                    <a href="{{ route('user.cart.index') }}" wire:navigate
                        class="relative p-1.5 rounded-md text-white/40 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fas fa-shopping-cart text-xs"></i>
                        @if (count(session('cart', [])) > 0)
                            <span
                                class="absolute -top-0.5 -right-0.5 w-3.5 h-3.5 bg-white text-black rounded-full text-[9px] flex items-center justify-center font-bold">
                                {{ count(session('cart', [])) }}
                            </span>
                        @endif
                    </a>

                    {{-- User Dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-md border border-white/10 hover:bg-white/5 transition-colors">
                            <div
                                class="w-4 h-4 rounded-full bg-white flex items-center justify-center text-black text-[9px] font-bold">
                                @if (Auth::user()->profile_avatar)
                                    <img src="{{ Auth::user()->profile_avatar }}"
                                        class="w-full h-full object-cover rounded-full">
                                @else
                                    <span>{{ substr(Auth::user()->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <span class="text-xs text-white/70">{{ Str::limit(Auth::user()->name, 12) }}</span>
                            <i class="fas fa-chevron-down text-[9px] text-white/30 transition-transform duration-150"
                                :class="open ? 'rotate-180' : ''"></i>
                        </button>

                        {{-- Dropdown: pakai x-show + x-cloak, tanpa x-transition --}}
                        <div x-show="open" x-cloak @click.outside="open = false"
                            class="absolute right-0 mt-1.5 w-48 bg-[#0D0D0D] border border-white/10 rounded-xl shadow-2xl py-1 z-50
                                   transition-all duration-150 ease-out"
                            :class="open ? 'opacity-100 scale-100 translate-y-0' : 'opacity-0 scale-95 -translate-y-1'">

                            <div class="px-3 py-2 border-b border-white/5 mb-1">
                                <p class="text-xs font-medium text-white">{{ Auth::user()->name }}</p>
                                <p class="text-[11px] text-white/30 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <a href="{{ route('user.dashboard') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-1.5 text-xs text-white/50 hover:text-white hover:bg-white/5 transition-colors">
                                <i class="fas fa-th-large w-3"></i> Dashboard
                            </a>
                            <a href="{{ route('user.profile') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-1.5 text-xs text-white/50 hover:text-white hover:bg-white/5 transition-colors">
                                <i class="fas fa-user w-3"></i> Profile
                            </a>
                            <a href="{{ route('user.orders.index') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-1.5 text-xs text-white/50 hover:text-white hover:bg-white/5 transition-colors">
                                <i class="fas fa-receipt w-3"></i> Pesanan Saya
                            </a>

                            @if (Auth::user()->is_admin)
                                <div class="border-t border-white/5 my-1"></div>
                                <a href="{{ route('admin.dashboard') }}" wire:navigate
                                    class="flex items-center gap-2 px-3 py-1.5 text-xs text-white hover:bg-white/5 transition-colors">
                                    <i class="fas fa-shield-alt w-3"></i> Admin Panel
                                </a>
                            @endif

                            <div class="border-t border-white/5 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-2 px-3 py-1.5 text-xs text-red-400 hover:bg-red-500/10 transition-colors">
                                    <i class="fas fa-sign-out-alt w-3"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" wire:navigate
                        class="text-xs text-white/40 hover:text-white px-3 py-1.5 transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" wire:navigate class="btn-primary btn">
                        Daftar
                    </a>
                @endauth
            </div>

            {{-- Mobile Toggle --}}
            <div class="flex items-center gap-1 md:hidden">
                <button @click="$dispatch('open-search')"
                    class="p-1.5 rounded-md text-white/40 hover:text-white hover:bg-white/5 transition-colors">
                    <i class="fas fa-search text-sm"></i>
                </button>
                <button @click="mobileOpen = !mobileOpen"
                    class="p-1.5 rounded-md text-white/40 hover:text-white hover:bg-white/5 transition-colors">
                    <i class="fas text-sm" :class="mobileOpen ? 'fa-times' : 'fa-bars'"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileOpen" x-cloak x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
        class="md:hidden border-t border-white/5 bg-[#010101] px-4 py-3 space-y-0.5">

        {{-- Nav Links --}}
        <a href="{{ route('home') }}" wire:navigate
            class="block px-3 py-2 rounded-md text-xs text-white/40 hover:text-white hover:bg-white/5">Home</a>
        <a href="{{ route('courses.index') }}" wire:navigate
            class="block px-3 py-2 rounded-md text-xs text-white/40 hover:text-white hover:bg-white/5">Kelas</a>
        <a href="{{ route('products.index') }}" wire:navigate
            class="block px-3 py-2 rounded-md text-xs text-white/40 hover:text-white hover:bg-white/5">Produk</a>

        <div class="border-t border-white/5 pt-2 mt-2">
            @auth
                {{-- User Info --}}
                <div class="px-3 py-2 mb-1">
                    <p class="text-xs font-medium text-white">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] text-white/30 truncate">{{ Auth::user()->email }}</p>
                </div>

                {{-- Menu Items --}}
                <a href="{{ route('user.dashboard') }}" wire:navigate
                    class="flex items-center gap-2 px-3 py-2 rounded-md text-xs text-white/40 hover:text-white hover:bg-white/5">
                    <i class="fas fa-th-large w-3"></i> Dashboard
                </a>
                <a href="{{ route('user.profile') }}" wire:navigate
                    class="flex items-center gap-2 px-3 py-2 rounded-md text-xs text-white/40 hover:text-white hover:bg-white/5">
                    <i class="fas fa-user w-3"></i> Profile
                </a>
                <a href="{{ route('user.orders.index') }}" wire:navigate
                    class="flex items-center gap-2 px-3 py-2 rounded-md text-xs text-white/40 hover:text-white hover:bg-white/5">
                    <i class="fas fa-receipt w-3"></i> Pesanan Saya
                </a>
                <a href="{{ route('user.cart.index') }}" wire:navigate
                    class="flex items-center gap-2 px-3 py-2 rounded-md text-xs text-white/40 hover:text-white hover:bg-white/5">
                    <i class="fas fa-shopping-cart w-3"></i>
                    Keranjang
                    @if (count(session('cart', [])) > 0)
                        <span
                            class="ml-auto w-4 h-4 bg-white text-black rounded-full text-[9px] flex items-center justify-center font-bold">
                            {{ count(session('cart', [])) }}
                        </span>
                    @endif
                </a>

                @if (Auth::user()->is_admin)
                    <div class="border-t border-white/5 my-1"></div>
                    <a href="{{ route('admin.dashboard') }}" wire:navigate
                        class="flex items-center gap-2 px-3 py-2 rounded-md text-xs text-white hover:bg-white/5">
                        <i class="fas fa-shield-alt w-3"></i> Admin Panel
                    </a>
                @endif

                <div class="border-t border-white/5 my-1 mt-2"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-2 px-3 py-2 rounded-md text-xs text-red-400 hover:bg-red-500/10 transition-colors">
                        <i class="fas fa-sign-out-alt w-3"></i> Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" wire:navigate
                    class="block px-3 py-2 rounded-md text-xs text-white/40 hover:text-white">Masuk</a>
                <a href="{{ route('register') }}" wire:navigate
                    class="block mt-1 btn-primary btn w-full justify-center">Daftar</a>
            @endauth
        </div>
    </div>
</nav>
