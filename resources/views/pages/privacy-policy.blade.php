@extends('layouts.app')

@section('title', 'Kebijakan Privasi')

@section('content')
    <div class="max-w-6xl mx-auto px-6 py-20">

        {{-- Header --}}
        <div class="mb-12">
            <p class="text-xs font-medium text-white/30 uppercase tracking-widest mb-3">Legal</p>
            <h1 class="text-4xl font-semibold text-white mb-4">Kebijakan Privasi</h1>
            <p class="text-white/30 text-sm">Terakhir diperbarui: {{ date('d F Y') }}</p>
        </div>

        <div class="border-t border-white/5 mb-12"></div>

        {{-- Content --}}
        <div class="prose prose-invert prose-sm max-w-none space-y-10 text-white/50 leading-relaxed">

            <section>
                <p>
                    Delix Studio ("kami", "kita", atau "platform") berkomitmen untuk melindungi privasi pengguna.
                    Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi
                    informasi pribadi kamu saat menggunakan layanan kami di <strong
                        class="text-white/70">delixstudio.com</strong>.
                </p>
            </section>

            <section>
                <h2 class="text-base font-semibold text-white mb-3">1. Informasi yang Kami Kumpulkan</h2>
                <p class="mb-4">Kami mengumpulkan informasi yang kamu berikan secara langsung kepada kami, antara lain:</p>
                <ul class="space-y-2 pl-4">
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Nama lengkap
                        dan alamat email saat mendaftar akun</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Informasi
                        pembayaran yang diproses melalui payment gateway (Midtrans)</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Data
                        aktivitas penggunaan platform (kursus yang diakses, produk yang dibeli)</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Informasi
                        teknis seperti alamat IP, jenis browser, dan perangkat yang digunakan</li>
                </ul>
            </section>

            <section>
                <h2 class="text-base font-semibold text-white mb-3">2. Bagaimana Kami Menggunakan Informasi</h2>
                <ul class="space-y-2 pl-4">
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Memproses
                        transaksi pembelian kursus dan produk digital</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Mengirimkan
                        konfirmasi pesanan dan informasi akun via email</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Memberikan
                        akses ke konten yang telah dibeli</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Meningkatkan
                        kualitas layanan dan pengalaman pengguna</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Mengirimkan
                        informasi promosi (dengan persetujuan kamu)</li>
                </ul>
            </section>

            <section>
                <h2 class="text-base font-semibold text-white mb-3">3. Keamanan Pembayaran</h2>
                <p>
                    Semua transaksi pembayaran diproses melalui <strong class="text-white/70">Midtrans</strong>,
                    penyedia layanan payment gateway yang telah tersertifikasi PCI-DSS. Kami tidak menyimpan
                    data kartu kredit/debit kamu di server kami. Data pembayaran dienkripsi dan dikelola
                    sepenuhnya oleh Midtrans sesuai standar keamanan industri.
                </p>
            </section>

            <section>
                <h2 class="text-base font-semibold text-white mb-3">4. Berbagi Informasi dengan Pihak Ketiga</h2>
                <p class="mb-4">Kami tidak menjual atau menyewakan data pribadi kamu kepada pihak ketiga. Informasi hanya
                    dibagikan kepada:</p>
                <ul class="space-y-2 pl-4">
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> <strong
                            class="text-white/60">Midtrans</strong> – untuk memproses pembayaran</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> <strong
                            class="text-white/60">Penyedia email</strong> – untuk mengirimkan notifikasi transaksi</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> <strong
                            class="text-white/60">Pihak berwenang</strong> – jika diwajibkan oleh hukum yang berlaku di
                        Indonesia</li>
                </ul>
            </section>

            <section>
                <h2 class="text-base font-semibold text-white mb-3">5. Cookies</h2>
                <p>
                    Kami menggunakan cookies untuk menjaga sesi login kamu, menyimpan preferensi, dan
                    menganalisis penggunaan platform. Kamu dapat menonaktifkan cookies melalui pengaturan
                    browser, namun beberapa fitur mungkin tidak berfungsi optimal.
                </p>
            </section>

            <section>
                <h2 class="text-base font-semibold text-white mb-3">6. Hak Kamu</h2>
                <p class="mb-4">Kamu memiliki hak untuk:</p>
                <ul class="space-y-2 pl-4">
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Mengakses dan
                        memperbarui data pribadi melalui halaman profil</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Meminta
                        penghapusan akun dan data pribadi kamu</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Membatalkan
                        berlangganan email pemasaran kapan saja</li>
                </ul>
            </section>

            <section>
                <h2 class="text-base font-semibold text-white mb-3">7. Perubahan Kebijakan</h2>
                <p>
                    Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu. Perubahan signifikan
                    akan diinformasikan melalui email atau notifikasi di platform. Penggunaan layanan yang
                    berkelanjutan setelah perubahan dianggap sebagai persetujuan terhadap kebijakan yang diperbarui.
                </p>
            </section>

            <section>
                <h2 class="text-base font-semibold text-white mb-3">8. Hubungi Kami</h2>
                <p>
                    Jika kamu memiliki pertanyaan mengenai Kebijakan Privasi ini, silakan hubungi kami di
                    <a href="mailto:support@delixstudio.com"
                        class="text-white/70 hover:text-white underline transition-colors">support@delixstudio.com</a>
                    atau melalui <a href="{{ route('contact') }}" wire:navigate
                        class="text-white/70 hover:text-white underline transition-colors">halaman kontak</a>.
                </p>
            </section>

        </div>

        {{-- Bottom nav --}}
        <div class="border-t border-white/5 mt-16 pt-8 flex flex-wrap gap-4">
            <a href="{{ route('terms') }}" wire:navigate class="text-xs text-white/30 hover:text-white transition-colors">
                Syarat & Ketentuan &rarr;
            </a>
            <a href="{{ route('contact') }}" wire:navigate class="text-xs text-white/30 hover:text-white transition-colors">
                Hubungi Kami &rarr;
            </a>
        </div>

    </div>
@endsection
