@extends('layouts.app')

@section('title', 'Kontak')

@section('content')
    <div class="max-w-6xl mx-auto px-6 py-20">

        {{-- Header --}}
        <div class="mb-16">
            <p class="text-xs font-medium text-white/30 uppercase tracking-widest mb-3">Kontak</p>
            <h1 class="text-4xl md:text-5xl font-semibold tracking-tight text-white leading-[1.15] mb-5 anim">
                Ada yang ingin<br>
                <span class="text-white/30">kamu tanyakan?</span>
            </h1>
            <p class="text-sm text-white/40 leading-relaxed max-w-lg mb-8">
                Kami siap membantu kamu. Hubungi kami melalui salah satu channel di bawah ini
                dan kami akan merespons secepat mungkin.
            </p>
        </div>

        <div class="border-t border-white/5 mb-16"></div>

        <div class="grid md:grid-cols-2 gap-12">

            {{-- Informasi Kontak --}}
            <div class="space-y-8">
                <h2 class="text-sm font-medium text-white/50 uppercase tracking-widest">Hubungi Kami</h2>

                {{-- Email --}}
                <div class="flex items-start gap-4">
                    <div
                        class="w-9 h-9 bg-white/[0.05] border border-white/[0.07] rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="fas fa-envelope text-white/40 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-xs text-white/30 mb-0.5">Email</p>
                        <a href="mailto:support@delixstudio.com"
                            class="text-sm text-white hover:text-white/70 transition-colors">
                            support@delixstudio.com
                        </a>
                        <p class="text-xs text-white/20 mt-1">Respons dalam 1x24 jam hari kerja</p>
                    </div>
                </div>

                {{-- WhatsApp --}}
                <div class="flex items-start gap-4">
                    <div
                        class="w-9 h-9 bg-white/[0.05] border border-white/[0.07] rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="fab fa-whatsapp text-white/40 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-xs text-white/30 mb-0.5">WhatsApp</p>
                        <a href="https://wa.me/628816864125?text=Halo%20Delix%20Studio%2C%20saya%20ingin%20bertanya."
                            target="_blank" rel="noopener noreferrer"
                            class="text-sm text-white hover:text-white/70 transition-colors">
                            +62 881-6864-125
                        </a>
                        <p class="text-xs text-white/20 mt-1">Senin – Jumat, 09.00 – 17.00 WIB</p>
                    </div>
                </div>

                {{-- Instagram --}}
                <div class="flex items-start gap-4">
                    <div
                        class="w-9 h-9 bg-white/[0.05] border border-white/[0.07] rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="fab fa-instagram text-white/40 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-xs text-white/30 mb-0.5">Instagram</p>
                        <a href="https://instagram.com/delixstudio28" target="_blank" rel="noopener noreferrer"
                            class="text-sm text-white hover:text-white/70 transition-colors">
                            @delixstudio28
                        </a>
                        <p class="text-xs text-white/20 mt-1">DM untuk pertanyaan umum</p>
                    </div>
                </div>

                {{-- Alamat --}}
                <div class="flex items-start gap-4">
                    <div
                        class="w-9 h-9 bg-white/[0.05] border border-white/[0.07] rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="fas fa-map-marker-alt text-white/40 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-xs text-white/30 mb-0.5">Alamat</p>
                        <p class="text-sm text-white leading-relaxed">
                            Banten, Indonesia
                        </p>
                    </div>
                </div>

            </div>

            {{-- Form Kontak --}}
            <div>
                <h2 class="text-sm font-medium text-white/50 uppercase tracking-widest mb-8">Kirim Pesan</h2>

                @if (session('success'))
                    <div
                        class="bg-green-500/10 border border-green-500/20 text-green-400 text-sm rounded-lg px-4 py-3 mb-6">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST" class="space-y-5" novalidate>
                    @csrf

                    <x-form.input name="name" label="Nama Lengkap" placeholder="Masukkan nama kamu" required />

                    <x-form.input name="email" type="email" label="Email" placeholder="email@kamu.com" required />

                    <x-form.input name="subject" label="Subjek" placeholder="Tentang apa pesan kamu?" required />

                    <x-form.textarea name="message" label="Pesan" placeholder="Tulis pesan kamu di sini..."
                        :rows="5" required />

                    <x-btn type="submit" variant="primary" class="w-full">
                        Kirim Pesan
                    </x-btn>
                </form>
            </div>
        </div>

    </div>
@endsection
