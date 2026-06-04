<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — {{ config('app.name') }}</title>
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
            <p class="text-xs text-white/30 mt-2">Buat password baru</p>
        </div>

        <div class="card p-6 space-y-4">
            <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <x-form.input name="email" label="Email" type="email" :value="$request->email"
                    placeholder="email@example.com" required />

                <x-form.input name="password" label="Password Baru" type="password" placeholder="Min. 8 karakter"
                    required />

                <x-form.input name="password_confirmation" label="Konfirmasi Password" type="password"
                    placeholder="Ulangi password baru" required />

                <x-btn type="submit" class="w-full justify-center">
                    Reset Password
                </x-btn>
            </form>
        </div>
    </div>
</body>

</html>
