<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-zinc-950 text-white antialiased min-h-screen flex items-center justify-center px-4 py-10">

    <div class="w-full max-w-sm">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="text-base font-semibold tracking-tight">
                delix<span class="text-white/30">studio</span>
            </a>
            <p class="text-xs text-white/30 mt-2">Buat akun baru</p>
        </div>

        {{-- Card --}}
        <div class="card p-6 space-y-4">
            <form method="POST" action="{{ route('register') }}" class="space-y-4" novalidate>
                @csrf

                <x-form.input name="name" label="Nama Lengkap" placeholder="Nama kamu" required />

                <x-form.input name="email" label="Email" type="email" placeholder="email@example.com" required />

                <x-form.input name="password" label="Password" type="password" placeholder="Min. 8 karakter" required
                    hint="Password harus mengandung huruf besar, kecil, symbol dan angka." />

                <x-form.input name="password_confirmation" label="Konfirmasi Password" type="password"
                    placeholder="Ulangi password" required />

                <x-btn type="submit" class="w-full justify-center">Daftar Sekarang</x-btn>
            </form>
        </div>

        <p class="text-center text-xs text-white/30 mt-4">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-white/60 hover:text-white transition-colors">
                Masuk
            </a>
        </p>
    </div>
</body>

</html>
