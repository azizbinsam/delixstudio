<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => [
                    'required',
                    'string',
                    'lowercase',
                    'email',
                    'max:255',
                    // Ignore soft deleted users
                    \Illuminate\Validation\Rule::unique('users')->whereNull('deleted_at'),
                ],
                'password' => [
                    'required',
                    'confirmed',
                    Rules\Password::min(8)
                        ->mixedCase()
                        ->numbers()
                        ->symbols(),
                ],
            ],
            [
                'name.required' => 'Nama wajib diisi.',
                'name.max' => 'Nama terlalu panjang.',

                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah digunakan.',
                'email.max' => 'Email terlalu panjang.',

                'password.required' => 'Password wajib diisi.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.mixed' => 'Password harus mengandung huruf besar dan kecil.',
                'password.numbers' => 'Password harus mengandung angka.',
                'password.symbols' => 'Password harus mengandung simbol.',
            ]
        );

        // Cek apakah ada soft deleted user dengan email yang sama
        $existingUser = \App\Models\User::withTrashed()
            ->where('email', $request->email)
            ->first();

        if ($existingUser && $existingUser->trashed()) {
            // Restore dan update datanya
            $existingUser->restore();
            $existingUser->update([
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'email_verified_at' => null,
            ]);
            $user = $existingUser;
        } else {
            // Buat user baru
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        }

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('verification.notice'));
    }
}
