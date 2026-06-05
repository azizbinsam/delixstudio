<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChapterController;
use App\Http\Controllers\Admin\CourseManagerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\OrderManagerController;
use App\Http\Controllers\Admin\PaymentSettingController;
use App\Http\Controllers\Admin\ProductManagerController;
use App\Http\Controllers\Admin\PromoCodeController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\UserManagerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProfileController;
use App\Models\Course;
use App\Models\Product;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Courses
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{slug}', [CourseController::class, 'show'])->name('courses.show');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Search
Route::get('/search', SearchController::class)->name('search');

// Chapter Player
Route::get('/courses/{slug}/learn/{chapterId}', [CourseController::class, 'learn'])
    ->middleware('auth')
    ->name('courses.learn');

// Info
Route::get('/about', function () {
    SEOMeta::setTitle('Tentang Kami - Delix Studio');
    SEOMeta::setDescription('Kenali lebih dekat Delix Studio, platform template dan course digital terbaik.');
    SEOMeta::setCanonical(url('/about'));
    OpenGraph::setUrl(url('/about'));
    return view('pages.about');
})->name('about');
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');
Route::get('/privacy-policy', function () {
    SEOMeta::setTitle('Kebijakan Privasi - Delix Studio');
    SEOMeta::setDescription('Baca kebijakan privasi Delix Studio untuk memahami bagaimana kami melindungi data kamu.');
    SEOMeta::setCanonical(url('/privacy-policy'));
    return view('pages.privacy-policy');
})->name('privacy');
Route::get('/terms', function () {
    SEOMeta::setTitle('Syarat & Ketentuan - Delix Studio');
    SEOMeta::setDescription('Baca syarat dan ketentuan penggunaan layanan Delix Studio.');
    SEOMeta::setCanonical(url('/terms'));
    return view('pages.terms');
})->name('terms');

// Google OAuth
Route::get('/auth/google', [\App\Http\Controllers\Auth\GoogleController::class, 'redirect'])
    ->name('auth.google');
Route::get('/auth/google/callback', [\App\Http\Controllers\Auth\GoogleController::class, 'callback'])
    ->name('auth.google.callback');

Route::get('/sitemap.xml', function () {
    $courses = App\Models\Course::where('status', 'published')->get();
    $products = App\Models\Product::where('status', 'published')->get();

    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    // Static pages
    $staticPages = ['/', '/courses', '/products', '/about', '/contact', '/privacy-policy', '/terms'];
    foreach ($staticPages as $page) {
        $xml .= '<url>';
        $xml .= '<loc>' . url($page) . '</loc>';
        $xml .= '<changefreq>weekly</changefreq>';
        $xml .= '<priority>0.8</priority>';
        $xml .= '</url>';
    }

    // Courses
    foreach ($courses as $course) {
        $xml .= '<url>';
        $xml .= '<loc>' . url("/courses/{$course->slug}") . '</loc>';
        $xml .= '<lastmod>' . $course->updated_at->toAtomString() . '</lastmod>';
        $xml .= '<changefreq>weekly</changefreq>';
        $xml .= '<priority>0.8</priority>';
        $xml .= '</url>';
    }

    // Products
    foreach ($products as $product) {
        $xml .= '<url>';
        $xml .= '<loc>' . url("/products/{$product->slug}") . '</loc>';
        $xml .= '<lastmod>' . $product->updated_at->toAtomString() . '</lastmod>';
        $xml .= '<changefreq>weekly</changefreq>';
        $xml .= '<priority>0.8</priority>';
        $xml .= '</url>';
    }

    $xml .= '</urlset>';

    return response($xml, 200)->header('Content-Type', 'application/xml');
});

/*
|--------------------------------------------------------------------------
| Midtrans Webhook (public — tanpa auth & tanpa CSRF)
| Midtrans server POST ke sini, bukan browser user.
| Keamanan dijaga oleh verifikasi signature di dalam controller.
|--------------------------------------------------------------------------
*/
Route::post('/payment/midtrans/callback', [OrderController::class, 'midtransCallback'])
    ->name('payment.midtrans.callback')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

/*
|--------------------------------------------------------------------------
| Auth Routes (Login, Register, dll - dari Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| User Routes (harus login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->prefix('user')->name('user.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Email change
    Route::get('/profile/email/verify/{token}', [ProfileController::class, 'verifyPendingEmail'])
        ->name('profile.email.verify')
        ->withoutMiddleware(['auth', 'verified']); // bisa diakses tanpa login (buka dari email client)

    Route::post('/profile/email/cancel', [ProfileController::class, 'cancelPendingEmail'])
        ->name('profile.email.cancel');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{invoice}', [OrderController::class, 'show'])->name('orders.show');

    // Checkout via Cart (Produk) — rate limited
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])
        ->middleware('throttle:checkout')
        ->name('checkout.process');
    Route::get('/checkout/success/{invoice}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Checkout Langsung (Kelas) — rate limited
    Route::get('/checkout/course/{course}', [CheckoutController::class, 'courseCheckout'])->name('checkout.course');
    Route::post('/checkout/course/{course}', [CheckoutController::class, 'processCourse'])
        ->middleware('throttle:checkout')
        ->name('checkout.course.process');

    // Promo kelas — rate limited (cegah brute-force kode promo)
    Route::post('/checkout/course/{course}/promo', [CheckoutController::class, 'applyCoursePromo'])
        ->middleware('throttle:promo')
        ->name('checkout.course.promo');
    Route::delete('/checkout/course/{course}/promo', [CheckoutController::class, 'removeCoursePromo'])
        ->name('checkout.course.promo.remove');

    // Payment Confirmation (Manual Transfer)
    Route::get('/payment/confirm/{invoice}', [OrderController::class, 'confirmPayment'])->name('payment.confirm');
    Route::post('/payment/confirm/{invoice}', [OrderController::class, 'submitConfirmation'])->name('payment.submit');

    // Download Product File
    Route::get('/download/{orderItemId}', [OrderController::class, 'download'])->name('download');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Promo cart — rate limited (cegah brute-force kode promo)
    Route::post('/cart/promo', [CartController::class, 'applyPromo'])
        ->middleware('throttle:promo')
        ->name('cart.promo');
    Route::delete('/cart/promo', [CartController::class, 'removePromo'])->name('cart.promo.remove');

    // Progress tracking
    Route::post('/courses/{slug}/progress/{chapterId}', [CourseController::class, 'markProgress'])
        ->name('courses.progress');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (harus login & admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Categories
    Route::resource('categories', CategoryController::class);

    // Courses
    Route::resource('courses', CourseManagerController::class);

    // Sections
    Route::post('courses/{course}/sections', [SectionController::class, 'store'])->name('sections.store');
    Route::put('sections/{section}', [SectionController::class, 'update'])->name('sections.update');
    Route::delete('sections/{section}', [SectionController::class, 'destroy'])->name('sections.destroy');

    // Chapters
    Route::post('sections/{section}/chapters', [ChapterController::class, 'store'])->name('chapters.store');
    Route::put('chapters/{chapter}', [ChapterController::class, 'update'])->name('chapters.update');
    Route::delete('chapters/{chapter}', [ChapterController::class, 'destroy'])->name('chapters.destroy');

    // Products
    Route::resource('products', ProductManagerController::class);

    // Orders
    Route::get('/orders', [OrderManagerController::class, 'index'])->name('orders.index');
    Route::get('/orders/{invoice}', [OrderManagerController::class, 'show'])->name('orders.show');
    Route::put('/orders/{invoice}/status', [OrderManagerController::class, 'updateStatus'])->name('orders.status');
    Route::get('/orders/{invoice}/license', [OrderManagerController::class, 'viewLicense'])->name('orders.license');

    // Promo Codes
    Route::resource('promo-codes', PromoCodeController::class);

    // Users
    Route::resource('users', UserManagerController::class);

    // Payment Settings
    Route::get('/payment-settings', [PaymentSettingController::class, 'index'])->name('payment-settings.index');
    Route::put('/payment-settings', [PaymentSettingController::class, 'update'])->name('payment-settings.update');

    // Media Library
    Route::get('media', [MediaController::class, 'index'])->name('media.index');
    Route::post('media', [MediaController::class, 'store'])->name('media.store');
    Route::get('media/find', [MediaController::class, 'find'])->name('media.find');
    Route::delete('media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');

    // Media download
    Route::get('media/{media}/download', [MediaController::class, 'download'])->name('media.download');
});
