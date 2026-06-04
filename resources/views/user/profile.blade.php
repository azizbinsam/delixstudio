@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <x-section-header label="Akun" title="Profile" description="" />

    <div class="pb-20">
        <div class="max-w-6xl mx-auto px-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">

                {{-- Edit Profile --}}
                <div class="card">
                    <div class="card-header">
                        <p class="text-xs font-medium text-white/50">Informasi Profile</p>
                    </div>
                    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data"
                        class="card-body space-y-4" novalidate>
                        @csrf @method('PUT')

                        {{-- Avatar --}}
                        <div x-data="{ preview: @js($user->avatar ? Storage::url($user->avatar) : ($user->avatar_url ?: null)) }">
                            <label class="label">Foto Profile</label>

                            <div class="flex items-center gap-4">
                                <div
                                    class="w-14 h-14 rounded-full bg-white/10 overflow-hidden flex items-center justify-center">
                                    <template x-if="preview">
                                        <img :src="preview" class="w-full h-full object-cover rounded-full">
                                    </template>
                                    <template x-if="!preview">
                                        <span class="text-lg font-semibold text-white/50">
                                            {{ substr($user->name, 0, 1) }}
                                        </span>
                                    </template>
                                </div>

                                <div>
                                    <button type="button" @click="$refs.avatarInput.click()"
                                        class="btn btn-outline btn-sm">
                                        Ganti Foto
                                    </button>
                                    <p class="text-[11px] text-white/20 mt-1">JPG, PNG maks. 1MB</p>
                                </div>
                            </div>

                            <input type="file" name="avatar" accept="image/*" class="hidden" x-ref="avatarInput"
                                @change="preview = URL.createObjectURL($event.target.files[0])">

                            @error('avatar')
                                <p class="mt-1 text-[11px] text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nama --}}
                        <x-form.input name="name" label="Nama Lengkap" :value="$user->name" required />

                        {{-- Email --}}
                        <x-form.input name="email" label="Email" type="email" :value="$user->email" required />

                        {{-- Pending Email Notif — di luar wrapper input agar tidak ganggu layout --}}
                        @if ($user->pending_email)
                            <div class="p-3 bg-yellow-500/5 border border-yellow-500/20 rounded-lg">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-xs font-medium text-yellow-400 mb-0.5">
                                            <i class="fas fa-clock mr-1"></i>
                                            Menunggu Verifikasi
                                        </p>
                                        <p class="text-[11px] text-white/40 leading-relaxed">
                                            Link verifikasi dikirim ke
                                            <span class="text-white/60 font-medium">{{ $user->pending_email }}</span>.
                                            Cek inbox atau spam kamu.
                                            @if ($user->pending_email_expires_at)
                                                Link berlaku hingga
                                                {{ $user->pending_email_expires_at->format('d M Y, H:i') }}.
                                            @endif
                                        </p>
                                    </div>

                                    <button type="button" x-data
                                        @click="
                                        fetch('{{ route('user.profile.email.cancel') }}', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                                'Accept': 'application/json',
                                            }
                                        }).then(() => window.location.reload())"
                                        class="text-[11px] text-white/30 hover:text-red-400 transition-colors whitespace-nowrap">
                                        Batalkan
                                    </button>
                                </div>
                            </div>
                        @endif

                        {{-- Phone --}}
                        <x-form.input name="phone" label="Nomor WhatsApp" :value="$user->phone" placeholder="08xxxxxxxxxx" />

                        {{-- Bio --}}
                        <x-form.textarea name="bio" label="Bio" :value="$user->bio"
                            placeholder="Ceritakan sedikit tentang dirimu..." :rows="3" />

                        <div class="flex justify-end pt-2">
                            <x-btn type="submit">Simpan Perubahan</x-btn>
                        </div>
                    </form>
                </div>

                {{-- Ganti Password --}}
                <div class="card">
                    <div class="card-header">
                        <p class="text-xs font-medium text-white/50">Ganti Password</p>
                    </div>

                    @if ($user->google_id && !$user->password)
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle mt-0.5"></i>
                                <span>Akun kamu terhubung dengan Google. Login menggunakan Google tidak memerlukan
                                    password.</span>
                            </div>
                        </div>
                    @else
                        <form action="{{ route('user.profile.password') }}" method="POST" class="card-body space-y-4"
                            novalidate>
                            @csrf @method('PUT')

                            <x-form.input name="current_password" label="Password Lama" type="password"
                                placeholder="••••••••" required />

                            <x-form.input name="password" label="Password Baru" type="password" placeholder="••••••••"
                                required hint="Minimal 8 karakter, mengandung huruf besar dan kecil, angka dan simbol." />

                            <x-form.input name="password_confirmation" label="Konfirmasi Password Baru" type="password"
                                placeholder="••••••••" required />

                            <div class="flex justify-end pt-2">
                                <x-btn type="submit">Ganti Password</x-btn>
                            </div>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection
