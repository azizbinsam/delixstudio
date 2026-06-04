@extends('layouts.app')

@section('title', 'Home')

@section('content')

    {{-- Hero --}} 
    <section class="pt-14 pb-20">
        <div class="max-w-6xl mx-auto px-6">
            <div class="max-w-2xl">

                {{-- Label --}}
                <div class="inline-flex items-center gap-2 text-xs text-white/40 mb-6">
                    <span class="w-1 h-1 bg-white/40 rounded-full"></span>
                    Platform E-Learning & E-Commerce WordPress
                </div>

                {{-- Headline --}}
                <h1 class="text-4xl md:text-5xl font-semibold tracking-tight text-white leading-[1.15] mb-5 anim">
                    Kuasai WordPress,<br>
                    <span class="text-white/30">tingkatkan bisnismu.</span>
                </h1>

                <p class="text-sm text-white/40 leading-relaxed max-w-lg mb-8">
                    Belajar dari kelas premium dan dapatkan tema & plugin WordPress terbaik.
                    Semua dalam satu platform untuk developer Indonesia.
                </p>

                {{-- CTA --}}
                <div class="flex items-center gap-3">
                    <a href="{{ route('courses.index') }}" wire:navigate class="btn-primary btn btn-lg">
                        Lihat Kelas
                    </a>
                    <a href="{{ route('products.index') }}" wire:navigate class="btn-outline btn btn-lg">
                        Lihat Produk
                    </a>
                </div>

                {{-- Stats --}}
                <div class="flex items-center gap-8 mt-12 pt-8 border-t border-white/5">
                    <div>
                        <div class="text-lg font-semibold text-white">50+</div>
                        <div class="text-xs text-white/30 mt-0.5">Kelas Tersedia</div>
                    </div>
                    <div class="w-px h-8 bg-white/5"></div>
                    <div>
                        <div class="text-lg font-semibold text-white">100+</div>
                        <div class="text-xs text-white/30 mt-0.5">Produk Premium</div>
                    </div>
                    <div class="w-px h-8 bg-white/5"></div>
                    <div>
                        <div class="text-lg font-semibold text-white">1K+</div>
                        <div class="text-xs text-white/30 mt-0.5">Member Aktif</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Featured Courses --}}
    <section class="py-16">
        <div class="max-w-6xl mx-auto px-6">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <p class="section-label">E-Learning</p>
                    <h2 class="section-title">Kelas Terbaru</h2>
                </div>
                <a href="{{ route('courses.index') }}" wire:navigate
                    class="text-xs text-white/30 hover:text-white transition-colors flex items-center gap-1">
                    Lihat semua <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            @if ($featuredCourses->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($featuredCourses as $course)
                        <a href="{{ route('courses.show', $course->slug) }}" wire:navigate
                            class="group card hover:border-white/20 transition-all duration-200">

                            {{-- Thumbnail --}}
                            <div class="aspect-video bg-white/5 overflow-hidden rounded-t-xl">
                                @if ($course->thumbnail)
                                    <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 opacity-80 group-hover:opacity-100">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-play-circle text-2xl text-white/10"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="p-4">
                                {{-- Badges --}}
                                <div class="flex items-center gap-1.5 mb-2.5">
                                    <span class="badge-secondary">{{ $course->category->name ?? '-' }}</span>
                                    <span class="badge-secondary capitalize">{{ $course->level }}</span>
                                </div>

                                <h3
                                    class="text-sm font-medium text-white group-hover:text-white/80 transition-colors line-clamp-2 mb-1.5">
                                    {{ $course->title }}
                                </h3>

                                <p class="text-xs text-white/30 line-clamp-2 mb-4 leading-relaxed">
                                    {{ $course->description }}
                                </p>

                                <div class="flex items-center justify-between pt-3 border-t border-white/5">
                                    <span class="text-sm font-semibold text-white">
                                        @if ($course->price == 0)
                                            Gratis
                                        @else
                                            Rp {{ number_format($course->price, 0, ',', '.') }}
                                        @endif
                                    </span>
                                    <span class="text-[11px] text-white/25">
                                        {{ $course->sections->count() }} section
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 border border-white/5 rounded-xl">
                    <i class="fas fa-play-circle text-2xl text-white/10 mb-3 block"></i>
                    <p class="text-xs text-white/30">Belum ada kelas tersedia</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Divider --}}
    <div class="max-w-6xl mx-auto px-6">
        <div class="border-t border-white/5"></div>
    </div>

    {{-- Featured Products --}}
    <section class="py-16">
        <div class="max-w-6xl mx-auto px-6">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <p class="section-label">E-Commerce</p>
                    <h2 class="section-title">Produk Terbaru</h2>
                </div>
                <a href="{{ route('products.index') }}" wire:navigate
                    class="text-xs text-white/30 hover:text-white transition-colors flex items-center gap-1">
                    Lihat semua <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            @if ($featuredProducts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($featuredProducts as $product)
                        <a href="{{ route('products.show', $product->slug) }}" wire:navigate
                            class="group card hover:border-white/20 transition-all duration-200">

                            {{-- Thumbnail --}}
                            <div class="aspect-video bg-white/5 overflow-hidden rounded-t-xl">
                                @if ($product->thumbnail)
                                    <img src="{{ Storage::url($product->thumbnail) }}" alt="{{ $product->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 opacity-80 group-hover:opacity-100">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-box text-2xl text-white/10"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="p-4">
                                {{-- Badges --}}
                                <div class="flex items-center gap-1.5 mb-2.5">
                                    <span class="badge-secondary">{{ $product->category->name ?? '-' }}</span>
                                    <span
                                        class="badge-secondary">{{ $product->type === 'file' ? 'File' : 'Lisensi' }}</span>
                                </div>

                                <h3
                                    class="text-sm font-medium text-white group-hover:text-white/80 transition-colors line-clamp-2 mb-1.5">
                                    {{ $product->title }}
                                </h3>

                                <p class="text-xs text-white/30 line-clamp-2 mb-4 leading-relaxed">
                                    {{ $product->description }}
                                </p>

                                <div class="flex items-center justify-between pt-3 border-t border-white/5">
                                    <span class="text-sm font-semibold text-white">
                                        @if ($product->price == 0)
                                            Gratis
                                        @else
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        @endif
                                    </span>
                                    <span class="text-[11px] text-white/25 flex items-center gap-1">
                                        <i class="fas fa-{{ $product->type === 'file' ? 'download' : 'key' }}"></i>
                                        {{ $product->type === 'file' ? 'Download' : 'Lisensi' }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 border border-white/5 rounded-xl">
                    <i class="fas fa-box text-2xl text-white/10 mb-3 block"></i>
                    <p class="text-xs text-white/30">Belum ada produk tersedia</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Divider --}}
    <div class="max-w-6xl mx-auto px-6">
        <div class="border-t border-white/5"></div>
    </div>

    {{-- Why Us --}}
    <section class="py-16">
        <div class="max-w-6xl mx-auto px-6">
            <div class="mb-10">
                <p class="section-label">Kenapa Delix Studio?</p>
                <h2 class="section-title max-w-sm">Platform terlengkap untuk developer WordPress</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @php
                    $features = [
                        [
                            'icon' => 'fas fa-play-circle',
                            'title' => 'Kelas Video Premium',
                            'desc' =>
                                'Belajar dari instruktur berpengalaman dengan materi yang terstruktur dan to the point.',
                        ],
                        [
                            'icon' => 'fas fa-box',
                            'title' => 'Produk Siap Pakai',
                            'desc' => 'Tema & plugin WordPress premium yang siap digunakan untuk project klienmu.',
                        ],
                        [
                            'icon' => 'fab fa-whatsapp',
                            'title' => 'Komunitas Aktif',
                            'desc' =>
                                'Bergabung dengan komunitas developer WordPress Indonesia yang aktif di WhatsApp Group.',
                        ],
                    ];
                @endphp

                @foreach ($features as $feature)
                    <div class="card p-5">
                        <div class="w-8 h-8 bg-white/5 rounded-lg flex items-center justify-center mb-4">
                            <i class="{{ $feature['icon'] }} text-xs text-white/50"></i>
                        </div>
                        <h3 class="text-sm font-medium text-white mb-1.5">{{ $feature['title'] }}</h3>
                        <p class="text-xs text-white/30 leading-relaxed">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Divider --}}
    <div class="max-w-6xl mx-auto px-6">
        <div class="border-t border-white/5"></div>
    </div>

    {{-- Testimoni --}}
    <x-testimonial-scroll :testimonials="[
        [
            'name' => 'Budi Santoso',
            'role' => 'Freelance Developer',
            'review' =>
                'Materinya sangat praktis dan to the point. Langsung bisa diterapkan ke project klien tanpa perlu riset panjang.',
        ],
        [
            'name' => 'Rina Kusuma',
            'role' => 'WordPress Specialist',
            'review' =>
                'Tema yang dibeli kualitasnya premium banget. Dokumentasinya lengkap, support-nya juga responsif.',
        ],
        [
            'name' => 'Ahmad Fauzi',
            'role' => 'Web Designer',
            'review' => 'Sudah 3 plugin yang saya beli, semuanya tidak mengecewakan. Worth every rupiah!',
        ],
        [
            'name' => 'Siti Marlina',
            'role' => 'Digital Agency Owner',
            'review' => 'Platform-nya rapi dan mudah digunakan. Proses pembelian sampai download sangat lancar.',
        ],
        [
            'name' => 'Denny Wijaya',
            'role' => 'Full Stack Dev',
            'review' => 'Kelas WordPress-nya detail banget. Saya yang sudah 2 tahun coding pun masih dapat ilmu baru.',
        ],
        [
            'name' => 'Lestari Putri',
            'role' => 'Blogger & Content Creator',
            'review' => 'Akhirnya ada platform lokal yang serius ngurusin kebutuhan WordPress developer Indonesia.',
        ],
        [
            'name' => 'Hendra Gunawan',
            'role' => 'IT Consultant',
            'review' => 'Harga sangat terjangkau dibanding beli plugin langsung dari luar. Lisensinya juga resmi.',
        ],
        [
            'name' => 'Mega Saraswati',
            'role' => 'UI/UX + WordPress Dev',
            'review' => 'Support-nya luar biasa. Ada kendala langsung dibantu, tidak dibiarkan bingung sendiri.',
        ],
        [
            'name' => 'Fajar Ramadan',
            'role' => 'Backend Developer',
            'review' => 'Plugin-nya ringan dan well-coded. Tidak bikin website berat sama sekali.',
        ],
    ]" />

    {{-- Divider --}}
    <div class="max-w-6xl mx-auto px-6">
        <div class="border-t border-white/5"></div>
    </div>

    {{-- CTA --}}
    <section class="py-16">
        <div class="max-w-6xl mx-auto px-6">
            <div
                class="bg-blue-700 border border-white/10 rounded-2xl p-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div>
                    <h2 class="text-xl font-semibold text-white mb-1.5 anim">Siap mulai perjalananmu?</h2>
                    <p class="text-xs text-white/60 max-w-sm leading-relaxed">
                        Bergabung dengan ribuan developer WordPress Indonesia yang sudah belajar bersama Delix Studio.
                    </p>
                </div>
                @guest
                    <a href="{{ route('register') }}" wire:navigate class="btn-primary btn btn-lg flex-shrink-0">
                        Daftar Sekarang
                    </a>
                @else
                    <a href="{{ route('courses.index') }}" wire:navigate class="btn-primary btn btn-lg flex-shrink-0">
                        Mulai Belajar
                    </a>
                @endguest
            </div>
        </div>
    </section>

@endsection
