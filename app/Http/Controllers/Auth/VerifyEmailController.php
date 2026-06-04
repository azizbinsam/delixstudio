<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Tentukan dashboard
        $dashboard = $user->email === 'admin@delixstudio.com'
            ? 'admin.dashboard'
            : 'user.dashboard';

        // Jika sudah verified
        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(
                route($dashboard, absolute: false) . '?verified=1'
            );
        }

        // Verifikasi email
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect()->intended(
            route($dashboard, absolute: false) . '?verified=1'
        );
    }
}
