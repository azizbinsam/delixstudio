<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-zinc-950 text-white antialiased min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-sm">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="text-base font-semibold tracking-tight">
                delix<span class="text-white/30">studio</span>
            </a>
        </div>

        <div class="card p-6 text-center space-y-4">

            {{-- Icon --}}
            <div
                class="w-14 h-14 bg-white/5 border border-white/10 rounded-full flex items-center justify-center mx-auto">
                <i class="fas fa-envelope text-white/40 text-lg"></i>
            </div>

            <div>
                <p class="text-sm font-semibold text-white mb-1">Verifikasi Email Kamu</p>
                <p class="text-xs text-white/40 leading-relaxed">
                    Kami telah mengirimkan link verifikasi ke
                    <span class="text-white/60 font-medium">{{ Auth::user()->email }}</span>.
                    Cek inbox atau folder spam kamu.
                </p>
            </div>

            @if (session('status') === 'verification-link-sent')
                <div class="alert-success text-xs">
                    <i class="fas fa-check-circle"></i>
                    <span>Link verifikasi baru telah dikirim ke email kamu.</span>
                </div>
            @endif

            {{-- Steps --}}
            <div class="text-left space-y-2 bg-white/5 rounded-xl p-4">
                <p class="text-[11px] text-white/40 font-medium uppercase tracking-wider mb-3">Langkah Verifikasi</p>
                <div class="flex items-start gap-2.5">
                    <span
                        class="w-5 h-5 rounded-full bg-white/10 text-white/50 text-[10px] flex items-center justify-center flex-shrink-0 mt-0.5">1</span>
                    <p class="text-xs text-white/50">Buka email yang kamu daftarkan</p>
                </div>
                <div class="flex items-start gap-2.5">
                    <span
                        class="w-5 h-5 rounded-full bg-white/10 text-white/50 text-[10px] flex items-center justify-center flex-shrink-0 mt-0.5">2</span>
                    <p class="text-xs text-white/50">Cari email dari <span
                            class="text-white/70">{{ config('mail.from.address') }}</span></p>
                </div>
                <div class="flex items-start gap-2.5">
                    <span
                        class="w-5 h-5 rounded-full bg-white/10 text-white/50 text-[10px] flex items-center justify-center flex-shrink-0 mt-0.5">3</span>
                    <p class="text-xs text-white/50">Klik tombol verifikasi di email</p>
                </div>
            </div>

            <div class="flex flex-col gap-2 pt-2">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <x-btn type="submit" class="w-full justify-center">
                        <i class="fas fa-paper-plane"></i>
                        Kirim Ulang Email Verifikasi
                    </x-btn>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-btn variant="ghost" type="submit" class="w-full justify-center text-white/30">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </x-btn>
                </form>
            </div>
        </div>

        <p class="text-center text-xs text-white/20 mt-4 leading-relaxed">
            Link verifikasi berlaku selama 60 menit.<br>
            Tidak menerima email? Cek folder spam kamu.
        </p>
    </div>
</body>

</html>
