@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
    <div class="max-w-6xl mx-auto px-6 py-20">

        {{-- Header --}}
        <div class="mb-16">
            <p class="text-xs font-medium text-white/30 uppercase tracking-widest mb-3">Tentang Kami</p>
            <h1 class="text-4xl md:text-5xl font-semibold tracking-tight text-white leading-[1.15] mb-5 anim">
                Membangun ekosistem<br>
                <span class="text-white/30">developer Indonesia.</span>
            </h1>
            <p class="text-sm text-white/40 leading-relaxed max-w-lg mb-8">
                Delix Studio adalah platform belajar dan belanja aset digital untuk developer dan kreator Indonesia.
                Kami menyediakan kursus berkualitas, tema WordPress, plugin, dan berbagai produk digital
                yang membantu kamu tumbuh sebagai developer profesional.
            </p>
        </div>

        {{-- Divider --}}
        <div class="border-t border-white/5 mb-16"></div>

        {{-- Visi Misi --}}
        <div class="grid md:grid-cols-2 gap-10 mb-16">
            <div>
                <h2 class="text-lg font-semibold text-white mb-3">Visi</h2>
                <p class="text-white/40 text-sm leading-relaxed">
                    Menjadi platform terpercaya bagi developer Indonesia dalam belajar, berkarya,
                    dan mengembangkan kemampuan digital mereka.
                </p>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-white mb-3">Misi</h2>
                <ul class="text-white/40 text-sm leading-relaxed space-y-2">
                    <li class="flex items-start gap-2">
                        <span class="text-white/20 mt-0.5">—</span>
                        Menyediakan konten belajar berkualitas tinggi dengan harga terjangkau
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-white/20 mt-0.5">—</span>
                        Menghadirkan produk digital yang siap pakai dan mudah dikustomisasi
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-white/20 mt-0.5">—</span>
                        Membangun komunitas developer yang saling mendukung
                    </li>
                </ul>
            </div>
        </div>

        {{-- Divider --}}
        <div class="border-t border-white/5 mb-16"></div>

        {{-- Produk --}}
        <div class="mb-16">
            <h2 class="section-title max-w-sm mb-10">Apa yang kami jual?</h2>
            <div class="grid sm:grid-cols-3 gap-4">
                <div class="bg-white/[0.03] border border-white/[0.06] rounded-xl p-5">
                    <div class="w-8 h-8 bg-white/[0.06] rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-graduation-cap text-white/50 text-sm"></i>
                    </div>
                    <h3 class="text-sm font-medium text-white mb-1">Kursus Online</h3>
                    <p class="text-xs text-white/30 leading-relaxed">
                        Kursus pemrograman dan pengembangan web yang terstruktur dan praktis.
                    </p>
                </div>
                <div class="bg-white/[0.03] border border-white/[0.06] rounded-xl p-5">
                    <div class="w-8 h-8 bg-white/[0.06] rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-paint-brush text-white/50 text-sm"></i>
                    </div>
                    <h3 class="text-sm font-medium text-white mb-1">Tema WordPress</h3>
                    <p class="text-xs text-white/30 leading-relaxed">
                        Tema WordPress premium yang modern, responsif, dan mudah dikustomisasi.
                    </p>
                </div>
                <div class="bg-white/[0.03] border border-white/[0.06] rounded-xl p-5">
                    <div class="w-8 h-8 bg-white/[0.06] rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-plug text-white/50 text-sm"></i>
                    </div>
                    <h3 class="text-sm font-medium text-white mb-1">Plugin & Aset Digital</h3>
                    <p class="text-xs text-white/30 leading-relaxed">
                        Plugin WordPress dan berbagai aset digital untuk kebutuhan proyek kamu.
                    </p>
                </div>
            </div>
        </div>

        {{-- Divider --}}
        <div class="border-t border-white/5 mb-16"></div>

        {{-- Kontak CTA --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-white mb-1.5 anim">Ada pertanyaan?</h2>
                <p class="text-xs text-white/30 max-w-sm leading-relaxed">Hubungi kami melalui halaman kontak atau email
                    langsung.</p>
            </div>
            <a href="{{ route('contact') }}" wire:navigate
                class="text-xs font-medium text-white bg-white/[0.07] hover:bg-white/[0.1] border border-white/10 px-5 py-2.5 rounded-lg transition-colors whitespace-nowrap">
                Hubungi Kami &rarr;
            </a>
        </div>

    </div>
@endsection
