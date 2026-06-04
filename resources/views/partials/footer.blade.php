<footer class="border-t border-white/5 mt-6">
    <div class="max-w-6xl mx-auto px-6 py-12">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-8">

            {{-- Brand --}}
            <div class="col-span-2">
                <a href="{{ route('home') }}" wire:navigate class="text-sm font-semibold text-white tracking-tight">
                    delix<span class="text-white/30">studio</span>
                </a>
                <p class="text-white/30 text-xs leading-relaxed mt-3 max-w-xs">
                    Platform belajar dan belanja tema & plugin WordPress untuk developer Indonesia.
                </p>
                {{-- Social Icons --}}
                <div class="flex items-center gap-3 mt-4">
                    <a href="#" target="_blank" rel="noopener noreferrer"
                        class="text-white/20 hover:text-white transition-colors" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                        </svg>
                    </a>
                    <a href="#" target="_blank" rel="noopener noreferrer"
                        class="text-white/20 hover:text-white transition-colors" aria-label="Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Platform --}}
            <div>
                <p class="text-xs font-medium text-white/50 mb-3">Platform</p>
                <ul class="space-y-2">
                    <li><a href="{{ route('courses.index') }}" wire:navigate
                            class="text-white/30 text-xs hover:text-white transition-colors">Kelas</a></li>
                    <li><a href="{{ route('products.index') }}" wire:navigate
                            class="text-white/30 text-xs hover:text-white transition-colors">Produk</a></li>
                </ul>
            </div>

            {{-- Akun --}}
            <div>
                <p class="text-xs font-medium text-white/50 mb-3">Akun</p>
                <ul class="space-y-2">
                    @auth
                        <li><a href="{{ route('user.dashboard') }}" wire:navigate
                                class="text-white/30 text-xs hover:text-white transition-colors">Dashboard</a></li>
                        <li><a href="{{ route('user.orders.index') }}" wire:navigate
                                class="text-white/30 text-xs hover:text-white transition-colors">Pesanan</a></li>
                    @else
                        <li><a href="{{ route('login') }}" wire:navigate
                                class="text-white/30 text-xs hover:text-white transition-colors">Masuk</a></li>
                        <li><a href="{{ route('register') }}" wire:navigate
                                class="text-white/30 text-xs hover:text-white transition-colors">Daftar</a></li>
                    @endauth
                </ul>
            </div>

            {{-- Legal --}}
            <div>
                <p class="text-xs font-medium text-white/50 mb-3">Info</p>
                <ul class="space-y-2">
                    <li><a href="{{ route('about') }}" wire:navigate
                            class="text-white/30 text-xs hover:text-white transition-colors">Tentang Kami</a></li>
                    <li><a href="{{ route('contact') }}" wire:navigate
                            class="text-white/30 text-xs hover:text-white transition-colors">Kontak</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/5 mt-10 pt-6 flex flex-col md:flex-row items-center justify-between gap-3">
            <p class="text-white/20 text-xs">© {{ date('Y') }} <a href="https://delixstudio.com" target="blank"
                    class="text-white/40">Delix Studio</a>. All
                rights reserved.</p>
            <div class="flex flex-col items-center gap-2 md:flex-row md:items-center md:gap-0">
                <p class="text-white/20 text-xs">Made by: <span class="text-white/40">Abdul Aziz bin Sambas</span></p>

                <span class="hidden md:block text-white/10 mx-3">|</span>

                <div class="flex items-center gap-3">
                    <a href="{{ route('privacy') }}" wire:navigate
                        class="text-white/30 text-xs hover:text-white transition-colors">Kebijakan Privasi</a>
                    <span class="text-white/10">|</span>
                    <a href="{{ route('terms') }}" wire:navigate
                        class="text-white/30 text-xs hover:text-white transition-colors">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </div>
</footer>
