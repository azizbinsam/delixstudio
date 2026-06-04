@extends('layouts.app')

@section('title', 'Syarat & Ketentuan')

@section('content')
    <div class="max-w-6xl mx-auto px-6 py-20">

        {{-- Header --}}
        <div class="mb-12">
            <p class="text-xs font-medium text-white/30 uppercase tracking-widest mb-3">Legal</p>
            <h1 class="text-4xl font-semibold text-white mb-4">Syarat &amp; Ketentuan</h1>
            <p class="text-white/30 text-sm">Terakhir diperbarui: {{ date('d F Y') }}</p>
        </div>

        <div class="border-t border-white/5 mb-12"></div>

        <div class="space-y-10 text-white/50 text-sm leading-relaxed">

            <section>
                <p>
                    Dengan menggunakan layanan Delix Studio ("platform"), kamu menyatakan telah membaca,
                    memahami, dan menyetujui Syarat &amp; Ketentuan ini. Jika kamu tidak menyetujui ketentuan
                    ini, mohon hentikan penggunaan layanan kami.
                </p>
            </section>

            <section>
                <h2 class="text-base font-semibold text-white mb-3">1. Definisi</h2>
                <ul class="space-y-2 pl-4">
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> <strong
                            class="text-white/60">Platform</strong>: Situs web Delix Studio (delixstudio.com)</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> <strong
                            class="text-white/60">Pengguna</strong>: Individu yang mendaftar dan menggunakan layanan
                        platform</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> <strong
                            class="text-white/60">Produk Digital</strong>: Kursus online, tema, plugin, dan aset digital
                        lainnya yang tersedia di platform</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> <strong
                            class="text-white/60">Transaksi</strong>: Proses pembelian produk digital oleh pengguna</li>
                </ul>
            </section>

            <section>
                <h2 class="text-base font-semibold text-white mb-3">2. Akun Pengguna</h2>
                <ul class="space-y-2 pl-4">
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Kamu
                        bertanggung jawab menjaga kerahasiaan kata sandi akun</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Satu akun
                        hanya boleh digunakan oleh satu orang</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Kami berhak
                        menangguhkan akun yang melanggar ketentuan ini</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Data akun
                        harus akurat dan terkini</li>
                </ul>
            </section>

            <section>
                <h2 class="text-base font-semibold text-white mb-3">3. Pembelian &amp; Pembayaran</h2>
                <ul class="space-y-2 pl-4">
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Seluruh harga
                        ditampilkan dalam Rupiah (IDR) dan sudah termasuk PPN jika berlaku</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Pembayaran
                        diproses melalui Midtrans dengan berbagai metode: transfer bank, kartu kredit/debit, QRIS, dan
                        e-wallet</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Pesanan
                        dianggap selesai setelah pembayaran berhasil dikonfirmasi</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Konfirmasi
                        pesanan dan invoice akan dikirimkan ke email yang terdaftar</li>
                </ul>
            </section>

            <section>
                <h2 class="text-base font-semibold text-white mb-3">4. Kebijakan Refund</h2>
                <p class="mb-4">
                    Karena sifat produk digital yang tidak dapat "dikembalikan", kami menerapkan kebijakan
                    refund sebagai berikut:
                </p>
                <ul class="space-y-2 pl-4">
                    <li class="flex items-start gap-2">
                        <span class="text-white/20 mt-1 flex-shrink-0">—</span>
                        <span>Refund dapat diminta dalam <strong class="text-white/60">7 hari</strong> setelah pembelian,
                            jika produk tidak dapat diakses atau tidak sesuai deskripsi</span>
                    </li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Permintaan
                        refund diajukan melalui email ke support@delixstudio.com dengan menyertakan nomor invoice</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Refund tidak
                        berlaku jika produk telah diunduh atau kursus telah diakses lebih dari 30%</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Proses refund
                        membutuhkan 5-14 hari kerja setelah disetujui</li>
                </ul>
            </section>

            <section>
                <h2 class="text-base font-semibold text-white mb-3">5. Lisensi Produk Digital</h2>
                <ul class="space-y-2 pl-4">
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Setiap
                        pembelian memberikan lisensi penggunaan personal (bukan kepemilikan)</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Produk tidak
                        boleh didistribusikan ulang, dijual kembali, atau dibagikan tanpa izin tertulis</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Pelanggaran
                        lisensi dapat mengakibatkan penonaktifan akun dan tindakan hukum</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Lisensi
                        berlaku seumur hidup kecuali dinyatakan lain pada halaman produk</li>
                </ul>
            </section>

            <section>
                <h2 class="text-base font-semibold text-white mb-3">6. Konten Kursus</h2>
                <ul class="space-y-2 pl-4">
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Akses kursus
                        berlaku seumur hidup setelah pembelian</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Kami berhak
                        memperbarui atau merevisi konten kursus untuk menjaga kualitas</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Materi kursus
                        tidak boleh direkam ulang, dibagikan, atau digunakan untuk keperluan komersial</li>
                </ul>
            </section>

            <section>
                <h2 class="text-base font-semibold text-white mb-3">7. Larangan Penggunaan</h2>
                <p class="mb-3">Pengguna dilarang untuk:</p>
                <ul class="space-y-2 pl-4">
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Melakukan
                        aktivitas yang melanggar hukum di Indonesia</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Mencoba
                        meretas, memanipulasi, atau mengganggu sistem platform</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Menyebarkan
                        konten berbahaya, spam, atau malware</li>
                    <li class="flex items-start gap-2"><span class="text-white/20 mt-1 flex-shrink-0">—</span> Menggunakan
                        akun orang lain tanpa izin</li>
                </ul>
            </section>

            <section>
                <h2 class="text-base font-semibold text-white mb-3">8. Batasan Tanggung Jawab</h2>
                <p>
                    Platform disediakan "sebagaimana adanya". Kami tidak bertanggung jawab atas kerugian
                    tidak langsung, insidental, atau konsekuensial yang timbul dari penggunaan layanan kami.
                    Tanggung jawab kami dibatasi sebesar nilai transaksi yang dilakukan pengguna.
                </p>
            </section>

            <section>
                <h2 class="text-base font-semibold text-white mb-3">9. Hukum yang Berlaku</h2>
                <p>
                    Syarat &amp; Ketentuan ini diatur oleh hukum Republik Indonesia. Setiap sengketa
                    diselesaikan melalui musyawarah mufakat, dan jika tidak tercapai, akan diselesaikan
                    melalui pengadilan yang berwenang di Indonesia.
                </p>
            </section>

            <section>
                <h2 class="text-base font-semibold text-white mb-3">10. Kontak</h2>
                <p>
                    Pertanyaan mengenai Syarat &amp; Ketentuan ini dapat diajukan ke
                    <a href="mailto:support@delixstudio.com"
                        class="text-white/70 hover:text-white underline transition-colors">support@delixstudio.com</a>.
                </p>
            </section>

        </div>

        {{-- Bottom nav --}}
        <div class="border-t border-white/5 mt-16 pt-8 flex flex-wrap gap-4">
            <a href="{{ route('privacy') }}" wire:navigate class="text-xs text-white/30 hover:text-white transition-colors">
                Kebijakan Privasi &rarr;
            </a>
            <a href="{{ route('contact') }}" wire:navigate class="text-xs text-white/30 hover:text-white transition-colors">
                Hubungi Kami &rarr;
            </a>
        </div>

    </div>
@endsection
