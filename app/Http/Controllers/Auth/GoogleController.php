<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Login dengan Google gagal. Silakan coba lagi.');
        }

        // Cek apakah user sudah ada berdasarkan google_id
        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            // Update avatar dari Google jika belum punya avatar custom
            if (!$user->avatar) {
                $user->update(['avatar_url' => $googleUser->getAvatar()]);
            }
            Auth::login($user);
            return redirect()->intended(route('user.dashboard'));
        }

        // Cek berdasarkan email
        $userByEmail = User::withTrashed()
            ->where('email', $googleUser->getEmail())
            ->first();

        if ($userByEmail) {
            if ($userByEmail->trashed()) {
                $userByEmail->restore();
            }

            // Update google_id & verifikasi email
            $userByEmail->update([
                'google_id' => $googleUser->getId(),
                'avatar_url' => $userByEmail->avatar ? $userByEmail->avatar_url : $googleUser->getAvatar(),
                'email_verified_at' => $userByEmail->email_verified_at ?? now(),
            ]);

            Auth::login($userByEmail);
            return redirect()->intended(route('user.dashboard'));
        }

        // Buat user baru
        $newUser = User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'avatar_url' => $googleUser->getAvatar(),
            'password' => bcrypt(\Illuminate\Support\Str::random(24)),
            'email_verified_at' => now(), // Google sudah verifikasi email
        ]);

        // Kirim welcome email
        Mail::to($newUser->email)->send(new WelcomeMail($newUser));

        Auth::login($newUser);
        return redirect()->intended(route('user.dashboard'));
    }
}
