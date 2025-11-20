<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LandingpageController;
use App\Http\Controllers\Website\ProductController;
use App\Http\Controllers\Website\AboutController;
use App\Http\Controllers\Website\ContactController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\AdminAuthController;

// Public Routes
Route::get('/', [LandingpageController::class, 'index'])->name('landing');
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/tentang', [AboutController::class, 'index'])->name('about');
Route::get('/kontak', [ContactController::class, 'index'])->name('contact.index');

// Admin Auth Routes (bebas akses tanpa login)
Route::get('/admin/reset-password', [AdminAuthController::class, 'showResetRequest'])->name('admin.reset.request');
Route::post('/admin/reset-password/send', [AdminAuthController::class, 'sendResetOtp'])->name('admin.reset.send');
Route::get('/admin/reset-password/verify', [AdminAuthController::class, 'showVerifyOtp'])->name('admin.reset.verify');
Route::post('/admin/reset-password/verify', [AdminAuthController::class, 'verifyOtp'])->name('admin.reset.verify.post');
Route::get('/admin/reset-password/change', [AdminAuthController::class, 'showChangePassword'])->name('admin.reset.change');
Route::post('/admin/reset-password/change', [AdminAuthController::class, 'changePassword'])->name('admin.reset.change.post');

// Login Routes
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Protected Routes (harus login)
Route::middleware('auth')->group(function () {
    // Admin Dashboard dengan DEBUG LOG
    Route::get('/admin', function () {
        \Log::info('=== ADMIN ACCESS CHECK ===');
        \Log::info('Auth::check(): ' . (Auth::check() ? 'TRUE' : 'FALSE'));
        \Log::info('User IP: ' . request()->ip());
        \Log::info('Session ID: ' . session()->getId());
        
        if (!Auth::check()) {
            \Log::warning('BLOCKED: User not authenticated');
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        \Log::info('ACCESS GRANTED: User ' . Auth::user()->email . ' accessed admin dashboard');
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Admin Management Routes dengan prefix
    Route::prefix('admin')->group(function () {
        // Products Management
        Route::get('/products', [ProductAdminController::class, 'index'])->name('admin.products.index');
        Route::get('/products/create', [ProductAdminController::class, 'create'])->name('admin.products.create');
        Route::post('/products', [ProductAdminController::class, 'store'])->name('admin.products.store');
        Route::get('/products/{id}/edit', [ProductAdminController::class, 'edit'])->name('admin.products.edit');
        Route::put('/products/{id}', [ProductAdminController::class, 'update'])->name('admin.products.update');
        Route::delete('/products/{id}', [ProductAdminController::class, 'destroy'])->name('admin.products.destroy');
    });
});