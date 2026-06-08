@extends('layouts.landing')

@section('title', 'Paket Go Online – Website Profesional Mulai 800rb | Delix Studio')
@section('meta_description',
    'Paket jasa pembuatan website profesional mulai Rp 800.000. Sudah termasuk hosting, domain,
    desain premium, revisi, dan support. Garansi uang kembali 100%.')

@section('content')

    {{-- ============================================================ --}}
    {{-- 1. HERO SECTION                                               --}}
    {{-- ============================================================ --}}
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden px-5">

        {{-- Background grid + glow --}}
        <div class="absolute inset-0 pointer-events-none">
            {{-- Grid overlay --}}
            <div class="absolute inset-0 opacity-[0.03]"
                style="background-image: linear-gradient(rgba(255,255,255,.5) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.5) 1px, transparent 1px); background-size: 40px 40px;">
            </div>
            {{-- Glow center --}}
            <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[400px] rounded-full opacity-10 blur-[120px]"
                style="background: radial-gradient(ellipse, #ffffff 0%, transparent 70%);">
            </div>
        </div>

        <div class="relative z-10 max-w-3xl mx-auto text-center">
            {{-- Badge --}}
            <div class="anim inline-flex items-center gap-2 mb-6">
                <span class="badge badge-secondary text-xs px-3 py-1">
                    <i class="fas fa-bolt text-yellow-400"></i>
                    Paket Terbatas — Hanya Rp 800.000
                </span>
            </div>

            {{-- Headline --}}
            <h1 class="anim anim-delay-1 text-4xl sm:text-5xl md:text-6xl font-bold tracking-tight leading-[1.15] mb-5">
                Bisnis Kamu Belum Online?<br>
                <span class="text-white/40">Kamu Sudah Kehilangan</span><br>
                <span class="relative inline-block">
                    Ratusan Calon Pelanggan.
                    <span class="absolute -bottom-1 left-0 right-0 h-[3px] bg-white/20 rounded-full"></span>
                </span>
            </h1>

            {{-- Sub --}}
            <p class="anim anim-delay-2 text-white/50 text-base sm:text-lg max-w-xl mx-auto mb-8 leading-relaxed">
                Satu paket lengkap — website profesional siap tayang dalam hitungan hari.
                Tanpa ribet, tanpa teknis, tanpa menguras kantong.
            </p>

            {{-- CTA Buttons --}}
            <div class="anim anim-delay-3 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="#cta"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white text-black font-semibold text-sm px-8 py-3.5 rounded-xl hover:bg-white/90 transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] shadow-lg shadow-white/10">
                    <i class="fas fa-rocket"></i>
                    Mulai Sekarang — Rp 800.000
                </a>
                <a href="#fitur"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 border border-white/15 text-white/70 text-sm px-6 py-3.5 rounded-xl hover:bg-white/5 hover:text-white transition-all duration-200">
                    Lihat Apa yang Kamu Dapat
                    <i class="fas fa-arrow-down text-xs"></i>
                </a>
            </div>

            {{-- Trust bar --}}
            <div class="anim mt-10 flex flex-wrap items-center justify-center gap-5 text-white/30 text-xs">
                <span class="flex items-center gap-1.5"><i class="fas fa-shield-halved text-green-400/60"></i> Garansi Uang
                    Kembali 100%</span>
                <span class="text-white/10">•</span>
                <span class="flex items-center gap-1.5"><i class="fas fa-star text-yellow-400/60"></i> 50+ Klien Puas</span>
                <span class="text-white/10">•</span>
                <span class="flex items-center gap-1.5"><i class="fas fa-bolt text-blue-400/60"></i> Launching dalam 5–7
                    Hari</span>
            </div>
        </div>

        {{-- Scroll indicator --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1.5 text-white/20 text-xs">
            <span>Scroll</span>
            <div class="w-px h-8 bg-gradient-to-b from-white/20 to-transparent animate-pulse"></div>
        </div>
    </section>


    {{-- ============================================================ --}}
    {{-- 2. SOCIAL PROOF – TESTIMONI                                   --}}
    {{-- ============================================================ --}}
    <section id="testimoni" class="py-20 px-5 border-t border-white/5">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-12 anim">
                <p class="section-label">Testimoni Klien</p>
                <h2 class="section-title text-2xl sm:text-3xl">Mereka Sudah Merasakannya</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                {{-- Testimoni 1 --}}
                <div class="anim card card-body flex flex-col gap-4">
                    <div class="flex gap-0.5 text-yellow-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-white/60 text-sm leading-relaxed">
                        "Serius kagum. Dalam 5 hari website toko saya udah live dan langsung ada yang order dari Google.
                        Worth banget harganya."
                    </p>
                    <div class="flex items-center gap-3 mt-auto pt-3 border-t border-white/5">
                        <div
                            class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-xs font-semibold">
                            A</div>
                        <div>
                            <p class="text-sm font-medium text-white">Andi Saputra</p>
                            <p class="text-xs text-white/30">Toko Spare Part, Bekasi</p>
                        </div>
                    </div>
                </div>

                {{-- Testimoni 2 --}}
                <div class="anim anim-delay-1 card card-body flex flex-col gap-4">
                    <div class="flex gap-0.5 text-yellow-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-white/60 text-sm leading-relaxed">
                        "Harga segini udah dapet hosting, domain, desain? Dikira mahal tapi ternyata sangat terjangkau. Puas
                        banget sama hasilnya."
                    </p>
                    <div class="flex items-center gap-3 mt-auto pt-3 border-t border-white/5">
                        <div
                            class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-xs font-semibold">
                            R</div>
                        <div>
                            <p class="text-sm font-medium text-white">Rina Maharani</p>
                            <p class="text-xs text-white/30">Bisnis Kue, Bandung</p>
                        </div>
                    </div>
                </div>

                {{-- Testimoni 3 --}}
                <div class="anim anim-delay-2 card card-body flex flex-col gap-4">
                    <div class="flex gap-0.5 text-yellow-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-white/60 text-sm leading-relaxed">
                        "Responsif, cepat, dan profesional. Support-nya juga fast response. Highly recommended buat yang
                        butuh website cepat dan murah."
                    </p>
                    <div class="flex items-center gap-3 mt-auto pt-3 border-t border-white/5">
                        <div
                            class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-xs font-semibold">
                            F</div>
                        <div>
                            <p class="text-sm font-medium text-white">Fajar Nugroho</p>
                            <p class="text-xs text-white/30">Konsultan IT, Jakarta</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- ============================================================ --}}
    {{-- 2B. PORTFOLIO                                                 --}}
    {{-- ============================================================ --}}
    <section id="portfolio" class="py-16 px-5 border-t border-white/5">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-10 anim">
                <p class="section-label">Portfolio</p>
                <h2 class="section-title text-2xl sm:text-3xl">Hasil Kerja Kami</h2>
                <p class="text-white/40 text-sm mt-2">Website nyata yang sudah live dan menghasilkan</p>
            </div>

            @php
                $portfolios = [
                    [
                        'image' => '/images/portfolio/portfolio-1.webp', // ganti path gambar
                        'name' => 'Albatross',
                        'meta' => 'Industri • Jakarta',
                        'url' => 'https://alti.co.id', // ganti URL website klien
                    ],
                    [
                        'image' => '/images/portfolio/portfolio-2.webp',
                        'name' => 'KBIHU Raudhotussalafiyah',
                        'meta' => 'Industri • Banten',
                        'url' => 'https://kbihu.roudhatussalafiyah.com',
                    ],
                    [
                        'image' => '/images/portfolio/portfolio-3.webp',
                        'name' => 'Gendhis Refleksi',
                        'meta' => 'Industri • Yogyakarta',
                        'url' => 'https://pijatpanggilanjogja24jam.com',
                    ],
                    [
                        'image' => '/images/portfolio/portfolio-4.webp',
                        'name' => 'We Clean',
                        'meta' => 'Industri • Malaysia',
                        'url' => 'https://www.weclean.my',
                    ],
                    [
                        'image' => '/images/portfolio/portfolio-5.webp',
                        'name' => 'Pani at 3AM',
                        'meta' => 'Industri • Banten',
                        'url' => 'https://panicat3am.com',
                    ],
                    [
                        'image' => '/images/portfolio/portfolio-6.webp',
                        'name' => 'Manaf',
                        'meta' => 'Industri • Arab Saudi',
                        'url' => 'https://manaf.id/id',
                    ],
                ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($portfolios as $item)
                    <a href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer"
                        class="anim group card overflow-hidden hover:border-white/20 transition-colors">
                        <div class="aspect-[4/3] bg-white/5 relative overflow-hidden">
                            @if ($item['image'])
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center gap-2">
                                    <i class="fas fa-image text-white/10 text-2xl"></i>
                                    <span class="text-white/20 text-xs">Coming soon</span>
                                </div>
                            @endif
                            <div
                                class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="text-white text-xs font-medium flex items-center gap-1.5">
                                    <i class="fas fa-external-link-alt text-xs"></i> Lihat Website
                                </span>
                            </div>
                        </div>
                        <div class="p-4">
                            <p class="text-sm font-medium text-white">{{ $item['name'] }}</p>
                            <p class="text-xs text-white/30 mt-0.5">{{ $item['meta'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>


    {{-- ============================================================ --}}
    {{-- 3. GARANSI UANG KEMBALI                                       --}}
    {{-- ============================================================ --}}
    <section class="py-16 px-5 border-t border-white/5">
        <div class="max-w-3xl mx-auto">
            <div class="anim card p-8 sm:p-10 text-center relative overflow-hidden">
                <div class="absolute inset-0 opacity-5 pointer-events-none"
                    style="background: radial-gradient(ellipse at center, #22c55e 0%, transparent 70%);">
                </div>
                <div class="relative z-10">
                    <div
                        class="w-16 h-16 rounded-2xl bg-green-500/10 border border-green-500/20 flex items-center justify-center mx-auto mb-5">
                        <i class="fas fa-shield-halved text-green-400 text-2xl"></i>
                    </div>
                    <span class="badge badge-success mb-4 text-xs px-3 py-1">Garansi 100%</span>
                    <h2 class="text-2xl sm:text-3xl font-bold text-white mb-3 tracking-tight">
                        Tidak Cocok? Uang Kembali Penuh.
                    </h2>
                    <p class="text-white/50 text-sm sm:text-base leading-relaxed max-w-lg mx-auto">
                        Kami yakin dengan kualitas kerja kami. Jika kamu tidak puas dengan hasil akhir website yang kami
                        buat
                        — <strong class="text-white">kami kembalikan 100% pembayaranmu</strong>. Tanpa syarat berbelit,
                        tanpa drama.
                    </p>
                    <p class="mt-4 text-white/25 text-xs">
                        Berlaku selama masa pengerjaan, sebelum website di-launch.
                    </p>
                </div>
            </div>
        </div>
    </section>


    {{-- ============================================================ --}}
    {{-- 4. KENAPA PILIH KAMI                                          --}}
    {{-- ============================================================ --}}
    <section id="kenapa" class="py-20 px-5 border-t border-white/5">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-12 anim">
                <p class="section-label">Kenapa Delix Studio?</p>
                <h2 class="section-title text-2xl sm:text-3xl">Bukan Sekadar Tampil — Tapi Menghasilkan</h2>
                <p class="text-white/40 text-sm mt-2 max-w-lg mx-auto">
                    Banyak yang bisa buat website. Tapi tidak banyak yang peduli apakah website itu benar-benar bekerja
                    untuk bisnis kamu.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div class="anim card p-6 flex gap-4">
                    <div
                        class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-clock text-white/60 text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-white mb-1">Launching dalam 5–7 Hari Kerja</h3>
                        <p class="text-xs text-white/40 leading-relaxed">Tidak perlu tunggu berminggu-minggu. Bisnis kamu
                            butuh online sekarang, bukan bulan depan.</p>
                    </div>
                </div>

                <div class="anim anim-delay-1 card p-6 flex gap-4">
                    <div
                        class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-mobile-screen-button text-white/60 text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-white mb-1">Desain Mobile-First</h3>
                        <p class="text-xs text-white/40 leading-relaxed">80% calon pelanggan kamu mengakses dari HP.
                            Website kami tampil sempurna di semua ukuran layar.</p>
                    </div>
                </div>

                <div class="anim anim-delay-2 card p-6 flex gap-4">
                    <div
                        class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-magnifying-glass text-white/60 text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-white mb-1">Dioptimasi untuk Google</h3>
                        <p class="text-xs text-white/40 leading-relaxed">SEO dasar sudah termasuk — biar calon pelanggan
                            bisa nemuin bisnis kamu saat mereka butuh.</p>
                    </div>
                </div>

                <div class="anim anim-delay-3 card p-6 flex gap-4">
                    <div
                        class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-comments text-white/60 text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-white mb-1">Komunikasi Langsung, Tanpa Perantara</h3>
                        <p class="text-xs text-white/40 leading-relaxed">Kamu ngobrol langsung sama yang ngerjain. Tidak
                            ada miskomunikasi, tidak ada waktu terbuang.</p>
                    </div>
                </div>

                <div class="anim card p-6 flex gap-4">
                    <div
                        class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-layer-group text-white/60 text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-white mb-1">Desain yang Bangun Kepercayaan</h3>
                        <p class="text-xs text-white/40 leading-relaxed">Tampilan profesional = calon pelanggan langsung
                            yakin. First impression menentukan apakah mereka beli atau kabur.</p>
                    </div>
                </div>

                <div class="anim anim-delay-1 card p-6 flex gap-4">
                    <div
                        class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-headset text-white/60 text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-white mb-1">Support After-Launch</h3>
                        <p class="text-xs text-white/40 leading-relaxed">Tidak ditinggal begitu website live. Ada support 1
                            minggu penuh untuk memastikan semuanya berjalan lancar.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- ============================================================ --}}
    {{-- 5. FITUR / BONUS                                              --}}
    {{-- ============================================================ --}}
    <section id="fitur" class="py-20 px-5 border-t border-white/5">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12 anim">
                <p class="section-label">Yang Kamu Dapatkan</p>
                <h2 class="section-title text-2xl sm:text-3xl">Satu Harga, Semua Lengkap</h2>
                <p class="text-white/40 text-sm mt-2">Biasanya kamu harus bayar ini semua terpisah. Di sini, semuanya sudah
                    termasuk.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">

                {{-- Hosting --}}
                <div class="anim card p-5 group hover:border-white/20 transition-colors">
                    <div class="flex items-start gap-4">
                        <div
                            class="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-server text-blue-400 text-sm"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="text-sm font-semibold text-white">Hosting 1 Tahun</h3>
                                <span
                                    class="badge bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[10px] px-1.5 py-0.5">~Rp
                                    300rb/thn</span>
                            </div>
                            <p class="text-xs text-white/40 leading-relaxed">Server cepat dengan uptime 99.9%. Website kamu
                                online 24 jam, 7 hari seminggu.</p>
                        </div>
                    </div>
                </div>

                {{-- Domain --}}
                <div class="anim anim-delay-1 card p-5 group hover:border-white/20 transition-colors">
                    <div class="flex items-start gap-4">
                        <div
                            class="w-10 h-10 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-globe text-purple-400 text-sm"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="text-sm font-semibold text-white">Domain .com / .id</h3>
                                <span
                                    class="badge bg-purple-500/10 text-purple-400 border border-purple-500/20 text-[10px] px-1.5 py-0.5">~Rp
                                    200rb/thn</span>
                            </div>
                            <p class="text-xs text-white/40 leading-relaxed">Nama domain profesional pilihan kamu. Lebih
                                terpercaya daripada pakai subdomain gratis.</p>
                        </div>
                    </div>
                </div>

                {{-- Desain Premium --}}
                <div class="anim anim-delay-2 card p-5 group hover:border-white/20 transition-colors">
                    <div class="flex items-start gap-4">
                        <div
                            class="w-10 h-10 rounded-xl bg-pink-500/10 border border-pink-500/20 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-palette text-pink-400 text-sm"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="text-sm font-semibold text-white">Desain Premium</h3>
                                <span
                                    class="badge bg-pink-500/10 text-pink-400 border border-pink-500/20 text-[10px] px-1.5 py-0.5">~Rp
                                    700rb</span>
                            </div>
                            <p class="text-xs text-white/40 leading-relaxed">Desain custom yang disesuaikan dengan brand
                                dan target pasar bisnis kamu. Bukan template murahan.</p>
                        </div>
                    </div>
                </div>

                {{-- Revisi --}}
                <div class="anim anim-delay-3 card p-5 group hover:border-white/20 transition-colors">
                    <div class="flex items-start gap-4">
                        <div
                            class="w-10 h-10 rounded-xl bg-yellow-500/10 border border-yellow-500/20 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-pen-to-square text-yellow-400 text-sm"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="text-sm font-semibold text-white">Revisi 1x</h3>
                                <span
                                    class="badge bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 text-[10px] px-1.5 py-0.5">Gratis</span>
                            </div>
                            <p class="text-xs text-white/40 leading-relaxed">Ada yang kurang pas? Tenang, kamu punya 1 kali
                                revisi setelah draft pertama selesai.</p>
                        </div>
                    </div>
                </div>

                {{-- Support --}}
                <div class="anim card p-5 group hover:border-white/20 transition-colors">
                    <div class="flex items-start gap-4">
                        <div
                            class="w-10 h-10 rounded-xl bg-green-500/10 border border-green-500/20 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-headset text-green-400 text-sm"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="text-sm font-semibold text-white">Support 1 Minggu</h3>
                                <span
                                    class="badge bg-green-500/10 text-green-400 border border-green-500/20 text-[10px] px-1.5 py-0.5">After
                                    Launch</span>
                            </div>
                            <p class="text-xs text-white/40 leading-relaxed">7 hari support penuh setelah website live. Ada
                                bug atau pertanyaan? Kami siap bantu via WhatsApp.</p>
                        </div>
                    </div>
                </div>

                {{-- Bonus: Basic SEO --}}
                <div class="anim anim-delay-1 card p-5 group hover:border-white/20 transition-colors relative">
                    <div class="absolute top-2 right-2">
                        <span class="badge bg-white text-black text-[10px] px-1.5 py-0.5">BONUS</span>
                    </div>
                    <div class="flex items-start gap-4">
                        <div
                            class="w-10 h-10 rounded-xl bg-orange-500/10 border border-orange-500/20 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-chart-line text-orange-400 text-sm"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="text-sm font-semibold text-white">Basic SEO Setup</h3>
                                <span
                                    class="badge bg-orange-500/10 text-orange-400 border border-orange-500/20 text-[10px] px-1.5 py-0.5">~Rp
                                    300rb</span>
                            </div>
                            <p class="text-xs text-white/40 leading-relaxed">Meta tag, sitemap, dan Google Search Console —
                                pondasi agar website kamu bisa ditemukan di Google.</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Total value banner --}}
            <div class="anim card p-6 bg-white/[0.02] text-center">
                <p class="text-white/40 text-sm mb-1">Total nilai yang kamu dapat:</p>
                <p class="text-3xl font-bold text-white line-through decoration-white/30">Rp 1.500.000+</p>
                <p class="text-white/40 text-sm mt-1">Kamu bayar hanya <strong class="text-white text-base">Rp
                        800.000</strong></p>
            </div>
        </div>
    </section>


    {{-- ============================================================ --}}
    {{-- 6. SOCIAL PROOF #2 – ANGKA & KEPERCAYAAN                      --}}
    {{-- ============================================================ --}}
    <section class="py-16 px-5 border-t border-white/5">
        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-12">
                <div class="anim card p-6 text-center">
                    <p class="text-3xl font-bold text-white mb-1">50+</p>
                    <p class="text-xs text-white/40">Website Diluncurkan</p>
                </div>
                <div class="anim anim-delay-1 card p-6 text-center">
                    <p class="text-3xl font-bold text-white mb-1">100%</p>
                    <p class="text-xs text-white/40">Klien Puas</p>
                </div>
                <div class="anim anim-delay-2 card p-6 text-center">
                    <p class="text-3xl font-bold text-white mb-1">5–7</p>
                    <p class="text-xs text-white/40">Hari Launching</p>
                </div>
                <div class="anim anim-delay-3 card p-6 text-center">
                    <p class="text-3xl font-bold text-white mb-1">0</p>
                    <p class="text-xs text-white/40">Refund Diminta</p>
                </div>
            </div>

            {{-- Testimoni tambahan --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="anim card p-6">
                    <div class="flex gap-0.5 text-yellow-400 text-xs mb-3">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-white/60 text-sm leading-relaxed mb-4">
                        "Dulu nggak punya website, ngandalin medsos doang. Sekarang udah ada yang DM dari Google. Nggak
                        nyangka secepat ini."
                    </p>
                    <div class="flex items-center gap-3 pt-3 border-t border-white/5">
                        <div
                            class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-xs font-semibold">
                            D</div>
                        <div>
                            <p class="text-sm font-medium text-white">Dian Permata</p>
                            <p class="text-xs text-white/30">Salon & Spa, Surabaya</p>
                        </div>
                    </div>
                </div>

                <div class="anim anim-delay-1 card p-6">
                    <div class="flex gap-0.5 text-yellow-400 text-xs mb-3">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-white/60 text-sm leading-relaxed mb-4">
                        "Prosesnya gampang banget. Tinggal kasih info bisnis, 5 hari kemudian website sudah jadi. Desainnya
                        lebih bagus dari yang saya bayangkan."
                    </p>
                    <div class="flex items-center gap-3 pt-3 border-t border-white/5">
                        <div
                            class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-xs font-semibold">
                            H</div>
                        <div>
                            <p class="text-sm font-medium text-white">Hendra Wijaya</p>
                            <p class="text-xs text-white/30">Kontraktor, Semarang</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- ============================================================ --}}
    {{-- 7. HARGA                                                      --}}
    {{-- ============================================================ --}}
    <section id="harga" class="py-20 px-5 border-t border-white/5">
        <div class="max-w-xl mx-auto">
            <div class="text-center mb-10 anim">
                <p class="section-label">Harga</p>
                <h2 class="section-title text-2xl sm:text-3xl">Transparan. Satu Harga. Semua Termasuk.</h2>
            </div>

            <div class="anim card relative overflow-hidden">
                {{-- Glow --}}
                <div class="absolute inset-0 opacity-5 pointer-events-none"
                    style="background: radial-gradient(ellipse at top, #ffffff 0%, transparent 60%);">
                </div>

                <div class="card-body relative z-10 p-8">
                    {{-- Badge --}}
                    <div class="flex justify-center mb-6">
                        <span class="badge badge-warning px-3 py-1 text-xs">
                            <i class="fas fa-fire-flame-curved"></i>
                            Harga Promo Terbatas
                        </span>
                    </div>

                    {{-- Package name --}}
                    <h3 class="text-center text-lg font-semibold text-white mb-1">Paket <span
                            class="font-display tracking-wider">GO ONLINE</span></h3>
                    <p class="text-center text-white/40 text-xs mb-6">Semua yang kamu butuhkan untuk mulai</p>

                    {{-- Price --}}
                    <div class="text-center mb-6">
                        <p class="text-white/30 text-sm line-through mb-0.5">Rp 1.500.000</p>
                        <p class="text-5xl font-bold text-white tracking-tight">Rp 800.000</p>
                        <p class="text-green-400 text-sm mt-1.5">
                            <i class="fas fa-tag text-xs"></i>
                            Hemat Rp 700.000 (47% off)
                        </p>
                    </div>

                    {{-- Checklist --}}
                    <ul class="space-y-3 mb-8">
                        @php
                            $features = [
                                ['icon' => 'fa-server', 'color' => 'text-blue-400', 'text' => 'Hosting 1 tahun'],
                                ['icon' => 'fa-globe', 'color' => 'text-purple-400', 'text' => 'Domain .com / .id'],
                                ['icon' => 'fa-palette', 'color' => 'text-pink-400', 'text' => 'Desain premium custom'],
                                [
                                    'icon' => 'fa-pen-to-square',
                                    'color' => 'text-yellow-400',
                                    'text' => 'Revisi 1x gratis',
                                ],
                                [
                                    'icon' => 'fa-headset',
                                    'color' => 'text-green-400',
                                    'text' => 'Support 1 minggu after launch',
                                ],
                                [
                                    'icon' => 'fa-chart-line',
                                    'color' => 'text-orange-400',
                                    'text' => 'Basic SEO setup (bonus)',
                                ],
                                [
                                    'icon' => 'fa-shield-halved',
                                    'color' => 'text-green-400',
                                    'text' => 'Garansi uang kembali 100%',
                                ],
                            ];
                        @endphp
                        @foreach ($features as $f)
                            <li class="flex items-center gap-3 text-sm text-white/70">
                                <div
                                    class="w-5 h-5 rounded-full bg-white/5 flex items-center justify-center flex-shrink-0">
                                    <i class="fas {{ $f['icon'] }} {{ $f['color'] }} text-[10px]"></i>
                                </div>
                                {{ $f['text'] }}
                            </li>
                        @endforeach
                    </ul>

                    {{-- DP Info --}}
                    <div class="bg-white/5 border border-white/10 rounded-xl p-4 mb-5 text-sm">
                        <p class="text-white font-semibold mb-2 flex items-center gap-2">
                            <i class="fas fa-wallet text-yellow-400 text-xs"></i>
                            Sistem Pembayaran
                        </p>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-white/50 text-xs">DP di awal (50%)</span>
                                <span class="text-white font-semibold text-xs">Rp 400.000</span>
                            </div>
                            <div class="w-full h-px bg-white/5"></div>
                            <div class="flex items-center justify-between">
                                <span class="text-white/50 text-xs">Pelunasan setelah selesai (50%)</span>
                                <span class="text-white font-semibold text-xs">Rp 400.000</span>
                            </div>
                        </div>
                        <p class="text-white/30 text-[11px] mt-3 leading-relaxed">
                            Pengerjaan dimulai setelah DP diterima. Pelunasan dilakukan sebelum website di-launch.
                        </p>
                    </div>

                    <a href="#cta"
                        class="block w-full text-center bg-white text-black font-semibold text-sm py-3.5 rounded-xl hover:bg-white/90 transition-all duration-200 hover:scale-[1.01] active:scale-[0.99]">
                        Pesan Sekarang — Mulai dari Rp 400.000
                    </a>

                    <p class="text-center text-white/25 text-xs mt-3">
                        <i class="fas fa-lock text-[10px]"></i> DP 50% • Pelunasan setelah website jadi • Garansi uang
                        kembali
                    </p>
                </div>
            </div>
        </div>
    </section>


    {{-- ============================================================ --}}
    {{-- 8. CTA + COUNTDOWN                                            --}}
    {{-- ============================================================ --}}
    <section id="cta" class="py-20 px-5 border-t border-white/5">
        <div class="max-w-2xl mx-auto text-center">
            <div class="anim">
                <p class="section-label">Penawaran Terbatas</p>
                <h2 class="text-3xl sm:text-4xl font-bold text-white tracking-tight mb-3">
                    Harga Ini Tidak Akan Bertahan Lama
                </h2>
                <p class="text-white/50 text-sm mb-8">
                    Penawaran Rp 800.000 ini hanya berlaku <strong class="text-white">24 jam</strong> sejak kamu pertama
                    membuka halaman ini.
                    Setelah itu, harga kembali ke Rp 1.500.000.
                </p>

                {{-- Countdown --}}
                <div class="flex items-center justify-center gap-3 mb-10" x-data="countdown()"
                    x-init="init()">
                    <div class="card w-20 py-4 text-center">
                        <p class="text-3xl font-bold text-white tabular-nums" x-text="hours">00</p>
                        <p class="text-[10px] text-white/30 mt-1 uppercase tracking-widest">Jam</p>
                    </div>
                    <span class="text-white/20 text-2xl font-light">:</span>
                    <div class="card w-20 py-4 text-center">
                        <p class="text-3xl font-bold text-white tabular-nums" x-text="minutes">00</p>
                        <p class="text-[10px] text-white/30 mt-1 uppercase tracking-widest">Menit</p>
                    </div>
                    <span class="text-white/20 text-2xl font-light">:</span>
                    <div class="card w-20 py-4 text-center">
                        <p class="text-3xl font-bold text-white tabular-nums" x-text="seconds">00</p>
                        <p class="text-[10px] text-white/30 mt-1 uppercase tracking-widest">Detik</p>
                    </div>
                </div>

                {{-- CTA Button --}}
                <a href="http://lynk.id/delixstudio/xej1zn7g34wr/checkout" target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center justify-center gap-2.5 bg-white text-black font-bold text-base px-10 py-4 rounded-xl hover:bg-white/90 transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] shadow-xl shadow-white/10 mb-3">
                    <i class="fas fa-rocket text-blue-500 text-lg"></i>
                    Ya! Saya Mau Pesan Sekarang
                </a>

                <p class="text-white/40 text-xs mb-1">
                    <i class="fas fa-wallet text-yellow-400/70 text-[10px]"></i>
                    Mulai dengan DP <strong class="text-white">Rp 400.000</strong> — pelunasan setelah website jadi
                </p>
                <p class="text-white/25 text-xs">
                    Klik untuk langsung chat via WhatsApp • Respon dalam 1 jam
                </p>
            </div>
        </div>
    </section>


    {{-- ============================================================ --}}
    {{-- 9. FAQ                                                        --}}
    {{-- ============================================================ --}}
    <section id="faq" class="py-20 px-5 border-t border-white/5">
        <div class="max-w-2xl mx-auto">
            <div class="text-center mb-10 anim">
                <p class="section-label">FAQ</p>
                <h2 class="section-title text-2xl sm:text-3xl">Pertanyaan yang Sering Ditanya</h2>
            </div>

            @php
                $faqs = [
                    [
                        'q' => 'Apakah saya bisa minta desain sesuai keinginan saya?',
                        'a' =>
                            'Tentu! Di awal proses, kami akan tanya soal brand, warna, dan referensi desain yang kamu suka. Desain disesuaikan dengan bisnis kamu — bukan template copy-paste.',
                    ],
                    [
                        'q' => 'Berapa lama website selesai?',
                        'a' =>
                            'Rata-rata 5–7 hari kerja setelah semua informasi dan konten dari kamu sudah lengkap. Semakin lengkap bahan yang kamu siapkan, semakin cepat prosesnya.',
                    ],
                    [
                        'q' => 'Kalau saya tidak puas, bagaimana proses refund-nya?',
                        'a' =>
                            'Jika kamu tidak puas dengan draft pertama, kami beri 1x revisi. Jika setelah revisi masih tidak cocok dan website belum di-launch, kami kembalikan 100% pembayaran kamu. Tanpa pertanyaan aneh.',
                    ],
                    [
                        'q' => 'Apakah hosting dan domain sudah benar-benar termasuk?',
                        'a' =>
                            'Ya, sudah termasuk semua dalam harga Rp 800.000. Hosting 1 tahun + domain .com atau .id pilihan kamu (tergantung ketersediaan). Tidak ada biaya tersembunyi.',
                    ],
                    [
                        'q' => 'Setelah 1 tahun, bagaimana untuk perpanjangan hosting dan domain?',
                        'a' =>
                            'Setelah masa hosting/domain habis (1 tahun), kamu perlu perpanjang secara mandiri dengan harga normal provider. Kami akan bantu dan arahkan prosesnya.',
                    ],
                    [
                        'q' => 'Jenis website apa yang bisa dibuat?',
                        'a' =>
                            'Paket Go Online cocok untuk website company profile, landing page bisnis, portfolio, toko online sederhana, atau website jasa/layanan. Jika butuh yang lebih kompleks, kami bisa diskusi harga custom.',
                    ],
                    [
                        'q' => 'Apakah saya perlu punya pengetahuan teknis?',
                        'a' =>
                            'Sama sekali tidak. Kamu hanya perlu kasih info bisnis kamu, dan biarkan kami yang urus semuanya dari A sampai Z.',
                    ],
                ];
            @endphp

            <div class="space-y-3" x-data="{ open: null }">
                @foreach ($faqs as $idx => $faq)
                    <div class="anim card overflow-hidden">
                        <button @click="open = open === {{ $idx }} ? null : {{ $idx }}"
                            class="w-full flex items-center justify-between gap-4 px-5 py-4 text-left hover:bg-white/[0.02] transition-colors">
                            <span class="text-sm font-medium text-white">{{ $faq['q'] }}</span>
                            <i class="fas fa-chevron-down text-white/30 text-xs flex-shrink-0 transition-transform duration-200"
                                :class="open === {{ $idx }} ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open === {{ $idx }}" x-collapse>
                            <div class="px-5 pb-4 text-sm text-white/50 leading-relaxed border-t border-white/5 pt-3">
                                {{ $faq['a'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    {{-- ============================================================ --}}
    {{-- 10. FOOTER                                                    --}}
    {{-- ============================================================ --}}
    <footer class="border-t border-white/5 py-10 px-5">
        <div class="max-w-5xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-white/25">
            <div class="flex items-center gap-2">
                <img src="/favicon.png" alt="Delix Studio" class="w-5 h-5 rounded opacity-50">
                <span>© {{ date('Y') }} Delix Studio. All rights reserved.</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('privacy') }}" class="hover:text-white/50 transition-colors">Kebijakan Privasi</a>
                <a href="{{ route('terms') }}" class="hover:text-white/50 transition-colors">Syarat & Ketentuan</a>
                <a href="{{ route('contact') }}" class="hover:text-white/50 transition-colors">Kontak</a>
            </div>
        </div>
    </footer>

    {{-- SOCIAL PROOF POPUP --}}
    <div id="proof-popup" class="fixed bottom-5 left-5 z-50 max-w-[280px] w-full pointer-events-none"
        style="transform: translateY(120%); opacity: 0; transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s ease;">
        <div class="card p-3.5 flex items-center gap-3 pointer-events-auto shadow-2xl shadow-black/50">
            <div id="proof-avatar"
                class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0 bg-white/10 text-white">
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs text-white font-semibold truncate" id="proof-name"></p>
                <p class="text-[11px] text-white/50 leading-snug mt-0.5">
                    membeli <span class="text-white/70">Paket Go Online</span>
                </p>
                <p class="text-[10px] text-white/30 mt-0.5" id="proof-time"></p>
            </div>
            <button onclick="hideProof()"
                class="text-white/20 hover:text-white/50 transition-colors flex-shrink-0 text-xs">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Scroll animation
        const animObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.anim').forEach(el => animObserver.observe(el));

        // Countdown — 24 jam per visitor, disimpan di localStorage
        function countdown() {
            return {
                hours: '24',
                minutes: '00',
                seconds: '00',
                interval: null,

                init() {
                    const STORAGE_KEY = 'go_online_deadline';
                    let deadline = localStorage.getItem(STORAGE_KEY);

                    if (!deadline) {
                        deadline = Date.now() + 24 * 60 * 60 * 1000;
                        localStorage.setItem(STORAGE_KEY, deadline);
                    } else {
                        deadline = parseInt(deadline);
                        // Jika sudah lewat, reset
                        if (Date.now() > deadline) {
                            deadline = Date.now() + 24 * 60 * 60 * 1000;
                            localStorage.setItem(STORAGE_KEY, deadline);
                        }
                    }

                    this.interval = setInterval(() => {
                        const diff = deadline - Date.now();
                        if (diff <= 0) {
                            this.hours = '00';
                            this.minutes = '00';
                            this.seconds = '00';
                            clearInterval(this.interval);
                            return;
                        }
                        const h = Math.floor(diff / 3600000);
                        const m = Math.floor((diff % 3600000) / 60000);
                        const s = Math.floor((diff % 60000) / 1000);
                        this.hours = String(h).padStart(2, '0');
                        this.minutes = String(m).padStart(2, '0');
                        this.seconds = String(s).padStart(2, '0');
                    }, 1000);
                }
            }
        }

        // Social Proof Popup
        const proofData = [{
                name: 'Andi S.',
                city: 'Jakarta',
                menit: 2
            },
            {
                name: 'Rina M.',
                city: 'Bandung',
                menit: 7
            },
            {
                name: 'Fajar N.',
                city: 'Surabaya',
                menit: 15
            },
            {
                name: 'Dewi R.',
                city: 'Semarang',
                menit: 23
            },
            {
                name: 'Hendra W.',
                city: 'Medan',
                menit: 34
            },
            {
                name: 'Siti A.',
                city: 'Yogyakarta',
                menit: 45
            },
            {
                name: 'Budi P.',
                city: 'Makassar',
                menit: 58
            },
            {
                name: 'Lina K.',
                city: 'Palembang',
                menit: 71
            },
            {
                name: 'Rizky F.',
                city: 'Depok',
                menit: 89
            },
            {
                name: 'Nurul H.',
                city: 'Bogor',
                menit: 102
            },
            {
                name: 'Dimas A.',
                city: 'Bekasi',
                menit: 3
            },
            {
                name: 'Mega S.',
                city: 'Tangerang',
                menit: 19
            },
            {
                name: 'Agus T.',
                city: 'Balikpapan',
                menit: 41
            },
            {
                name: 'Yuni P.',
                city: 'Malang',
                menit: 66
            },
            {
                name: 'Rahmat D.',
                city: 'Pekanbaru',
                menit: 88
            },
        ];

        const avatarColors = [{
                bg: 'rgba(59,130,246,0.3)',
                color: '#93c5fd'
            },
            {
                bg: 'rgba(168,85,247,0.3)',
                color: '#d8b4fe'
            },
            {
                bg: 'rgba(236,72,153,0.3)',
                color: '#f9a8d4'
            },
            {
                bg: 'rgba(34,197,94,0.3)',
                color: '#86efac'
            },
            {
                bg: 'rgba(234,179,8,0.3)',
                color: '#fde047'
            },
            {
                bg: 'rgba(249,115,22,0.3)',
                color: '#fdba74'
            },
        ];

        let proofIndex = Math.floor(Math.random() * proofData.length);
        let proofTimeout = null;
        let proofHideTimeout = null;

        function showProof() {
            const data = proofData[proofIndex % proofData.length];
            proofIndex++;

            const popup = document.getElementById('proof-popup');
            const avatar = document.getElementById('proof-avatar');
            const name = document.getElementById('proof-name');
            const time = document.getElementById('proof-time');
            const color = avatarColors[Math.floor(Math.random() * avatarColors.length)];

            avatar.className = 'w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0';
            avatar.style.backgroundColor = color.bg;
            avatar.style.color = color.color;
            avatar.textContent = data.name.charAt(0);
            name.textContent = `${data.name} dari ${data.city}`;

            const menit = data.menit;
            time.textContent = menit < 60 ?
                `${menit} menit yang lalu` :
                `${Math.floor(menit / 60)} jam yang lalu`;

            popup.style.transform = 'translateY(0)';
            popup.style.opacity = '1';

            clearTimeout(proofHideTimeout);
            proofHideTimeout = setTimeout(() => hideProof(), 5000);

            clearTimeout(proofTimeout);
            proofTimeout = setTimeout(() => showProof(), 12000);
        }

        function hideProof() {
            const popup = document.getElementById('proof-popup');
            popup.style.transform = 'translateY(120%)';
            popup.style.opacity = '0';
        }

        setTimeout(() => showProof(), 4000);
    </script>
@endpush
