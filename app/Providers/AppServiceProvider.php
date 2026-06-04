<?php

namespace App\Providers;

use App\Mail\WelcomeMail;
use App\Models\PaymentSetting;
use App\Models\PromoCode;
use Illuminate\Auth\Events\Verified;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.tailwind');

        // Share promo aktif ke semua view
        View::composer('layouts.promo-banner', function ($view) {
            $activePromo = PromoCode::where('is_active', true)
                ->where(function ($q) {
                    $q->whereNull('expired_at')
                        ->orWhere('expired_at', '>', now());
                })
                ->where(function ($q) {
                    $q->whereNull('max_usage')
                        ->orWhereColumn('used_count', '<', 'max_usage');
                })
                ->latest()
                ->first();

            $view->with('activePromo', $activePromo);
        });

        // Kirim welcome email setelah verifikasi
        Event::listen(Verified::class, function ($event) {
            Mail::to($event->user->email)->send(new WelcomeMail($event->user));
        });

        // Share whatsapp number ke semua view
        View::composer('layouts.app', function ($view) {
            $setting = PaymentSetting::first();
            $view->with('whatsappNumber', $setting?->whatsapp_number);
        });
    }
}
