<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — {{ config('app.name') }}</title>
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
            <p class="text-xs text-white/30 mt-2">Masuk ke akun kamu</p>
        </div>

        {{-- Session Status --}}
        @if (session('status'))
            <div class="alert-success mb-4 text-xs">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        {{-- Card --}}
        <div class="card p-6 space-y-4">
            <form method="POST" action="{{ route('login') }}" class="space-y-4" novalidate>
                @csrf

                <x-form.input name="email" label="Email" type="email" placeholder="email@example.com" required />
                <x-form.input name="password" label="Password" type="password" placeholder="••••••••" required />
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <x-form.checkbox name="remember" label="Ingat saya" />
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-xs text-white/30 hover:text-white transition-colors">
                                Lupa password?
                            </a>
                        @endif
                    </div>
                </div>

                <x-btn type="submit" class="w-full justify-center">Masuk</x-btn>
            </form>
            {{-- Divider --}}
            <div class="relative my-2">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-white/10"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="bg-[#0D0D0D] px-3 text-[11px] text-white/30">atau</span>
                </div>
            </div>

            {{-- Google Login --}}
            <a href="{{ route('auth.google') }}"
                class="w-full flex items-center justify-center gap-2.5 border border-white/10 bg-white/5 hover:bg-white/10 text-white/70 hover:text-white text-xs font-medium py-2 rounded-lg transition-colors">
                <svg class="w-4 h-4" viewBox="0 0 24 24">
                    <path fill="#4285F4"
                        d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                    <path fill="#34A853"
                        d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                    <path fill="#FBBC05"
                        d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                    <path fill="#EA4335"
                        d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                </svg>
                Lanjutkan dengan Google
            </a>
        </div>



        <p class="text-center text-xs text-white/30 mt-4">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-white/60 hover:text-white transition-colors">
                Daftar sekarang
            </a>
        </p>
    </div>
</body>

</html>
