<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LandingpageController;
use App\Http\Controllers\Website\ProductController;
use App\Http\Controllers\Website\AboutController;
use App\Http\Controllers\Website\ContactController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\SocialMediaController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\AdminAuthController;

// ============================================
// PUBLIC ROUTES
// ============================================
Route::get('/', [LandingpageController::class, 'index'])->name('landing');
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/tentang', [AboutController::class, 'index'])->name('about');
Route::get('/kontak', [ContactController::class, 'index'])->name('contact.index');

// ============================================
// AUTH ROUTES (Admin)
// ============================================
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Reset Password (Tanpa Login)
Route::prefix('admin/reset-password')->group(function () {
    Route::get('/', [AdminAuthController::class, 'showResetRequest'])->name('admin.reset.request');
    Route::post('/send', [AdminAuthController::class, 'sendResetOtp'])->name('admin.reset.send');
    Route::get('/verify', [AdminAuthController::class, 'showVerifyOtp'])->name('admin.reset.verify');
    Route::post('/verify', [AdminAuthController::class, 'verifyOtp'])->name('admin.reset.verify.post');
    Route::get('/change', [AdminAuthController::class, 'showChangePassword'])->name('admin.reset.change');
    Route::post('/change', [AdminAuthController::class, 'changePassword'])->name('admin.reset.change.post');
});

// ============================================
// ADMIN PROTECTED ROUTES (harus login)
// ============================================
Route::middleware('auth')->prefix('admin')->group(function () {

    // Dashboard
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // ============================================
    // PRODUCT MANAGEMENT
    // ============================================
    Route::get('/products', [ProductAdminController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [ProductAdminController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [ProductAdminController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{id}/edit', [ProductAdminController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{id}', [ProductAdminController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{id}', [ProductAdminController::class, 'destroy'])->name('admin.products.destroy');

    // ============================================
    // SOCIAL MEDIA MANAGEMENT
    // ============================================
    Route::get('/social-media', [SocialMediaController::class, 'index'])->name('admin.social.index');
    Route::post('/social-media', [SocialMediaController::class, 'bulkUpdate'])->name('admin.social.store');
    Route::post('/social-media/bulk-update', [SocialMediaController::class, 'bulkUpdate'])->name('admin.social.bulk-update');
    Route::put('/social-media/{id}', [SocialMediaController::class, 'update'])->name('admin.social.update');

    // ============================================
    // SETTINGS MANAGEMENT
    // ============================================
    Route::prefix('settings')->group(function () {

        // Lokasi & Jam Operasional
        Route::get('/location', [SettingController::class, 'location'])->name('admin.settings.location');
        Route::post('/location', [SettingController::class, 'updateLocation'])->name('admin.settings.location.update');

        // Logo & Favicon
        Route::get('/logo', [SettingController::class, 'logo'])->name('admin.settings.logo');
        Route::post('/logo', [SettingController::class, 'updateLogo'])->name('admin.settings.logo.update');
        Route::delete('/logo/{type}', [SettingController::class, 'deleteLogo'])->name('admin.settings.logo.delete');

        // Welcome Message
        Route::get('/welcome', [SettingController::class, 'welcome'])->name('admin.settings.welcome');
        Route::post('/welcome', [SettingController::class, 'updateWelcome'])->name('admin.settings.welcome.update');

        // Contact Settings
        Route::get('/contact', [SettingController::class, 'contact'])->name('admin.settings.contact');
        Route::post('/contact', [SettingController::class, 'updateContact'])->name('admin.settings.contact.update');

        // SEO
        Route::get('/seo', [SettingController::class, 'seo'])->name('admin.settings.seo');
        Route::post('/seo', [SettingController::class, 'updateSeo'])->name('admin.settings.seo.update');

        // ============================================
        // AJAX & UTILITY ROUTES (TETAP ADA)
        // ============================================
        Route::post('/clear-notifications', [SettingController::class, 'clearFrontendNotifications'])->name('admin.settings.clear-notifications');
        Route::get('/current-logo', [SettingController::class, 'getCurrentLogo'])->name('admin.settings.current-logo');
        Route::post('/cleanup-data', [SettingController::class, 'cleanupOldData'])->name('admin.settings.cleanup-data');
        
    });
});