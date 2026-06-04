<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\EmailChangedNotificationMail;
use App\Mail\PendingEmailVerificationMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $user->id,
            'phone'  => 'nullable|string|max:20',
            'bio'    => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ], [
            'name.required'  => 'Nama wajib diisi.',
            'name.string'    => 'Nama harus berupa teks.',
            'name.max'       => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email sudah digunakan.',
            'phone.string'   => 'Nomor telepon harus berupa teks.',
            'phone.max'      => 'Nomor telepon maksimal 20 karakter.',
            'bio.string'     => 'Bio harus berupa teks.',
            'bio.max'        => 'Bio maksimal 500 karakter.',
            'avatar.image'   => 'File avatar harus berupa gambar.',
            'avatar.mimes'   => 'Avatar harus berformat JPG, JPEG, atau PNG.',
            'avatar.max'     => 'Ukuran avatar maksimal 1 MB.',
        ]);

        // --- Avatar ---
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        // --- Data biasa ---
        $user->name  = $request->name;
        $user->phone = $request->phone;
        $user->bio   = $request->bio;

        $oldEmail    = $user->email;
        $newEmail    = $request->email;
        $emailChanged = $newEmail !== $oldEmail;

        // --- Email change flow ---
        if ($emailChanged) {
            $token     = Str::random(64);
            $tokenHash = hash('sha256', $token);

            $user->pending_email            = $newEmail;
            $user->pending_email_token      = $tokenHash;
            $user->pending_email_expires_at = now()->addMinutes(60);

            $verificationUrl = route('user.profile.email.verify', ['token' => $token]);

            Mail::to($newEmail)->send(
                new PendingEmailVerificationMail($user->name, $oldEmail, $newEmail, $verificationUrl)
            );
        }

        $user->save();

        return back()->with(
            'success',
            $emailChanged
                ? 'Profil diperbarui! Silakan cek email baru untuk verifikasi perubahan email.'
                : 'Profil berhasil diperbarui!'
        );
    }

    public function verifyPendingEmail(string $token)
    {
        $tokenHash = hash('sha256', $token);

        $user = User::where('pending_email_token', $tokenHash)->first();

        if (
            ! $user ||
            ! $user->pending_email ||
            ! $user->pending_email_expires_at ||
            now()->greaterThan($user->pending_email_expires_at)
        ) {
            return redirect()->route('user.profile')
                ->with('error', 'Link verifikasi tidak valid atau sudah kadaluarsa.');
        }

        $oldEmail = $user->email;
        $newEmail = $user->pending_email;

        $user->email                    = $newEmail;
        $user->email_verified_at        = now();
        $user->pending_email            = null;
        $user->pending_email_token      = null;
        $user->pending_email_expires_at = null;
        $user->save();

        Mail::to($oldEmail)->send(
            new EmailChangedNotificationMail($user, $oldEmail, $newEmail)
        );

        return redirect()->route('user.profile')
            ->with('success', 'Email berhasil diperbarui ke ' . $newEmail);
    }

    public function cancelPendingEmail()
    {
        $user = Auth::user();

        $user->pending_email            = null;
        $user->pending_email_token      = null;
        $user->pending_email_expires_at = null;
        $saved = $user->save();

        dd([
            'saved'         => $saved,
            'pending_email' => $user->pending_email,
            'user_id'       => $user->id,
        ]);

        return back()->with('success', 'Permintaan perubahan email dibatalkan.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'password.required'         => 'Password baru wajib diisi.',
            'password.confirmed'        => 'Konfirmasi password tidak cocok.',
            'password.min'              => 'Password minimal 8 karakter.',
            'password.mixed'            => 'Password harus mengandung huruf besar dan kecil.',
            'password.numbers'          => 'Password harus mengandung angka.',
            'password.symbols'          => 'Password harus mengandung simbol.',
        ]);

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai!');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui!');
    }
}
