<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingpageController;
use App\Http\Controllers\Website\ProductController;
use App\Http\Controllers\Website\AboutController;
use App\Http\Controllers\Website\ContactController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\AdminAuthController;


Route::get('/admin/reset-password', [AdminAuthController::class, 'showResetRequest'])->name('admin.reset.request');
Route::post('/admin/reset-password/send', [AdminAuthController::class, 'sendResetOtp'])->name('admin.reset.send');

Route::get('/admin/reset-password/verify', [AdminAuthController::class, 'showVerifyOtp'])->name('admin.reset.verify');
Route::post('/admin/reset-password/verify', [AdminAuthController::class, 'verifyOtp'])->name('admin.reset.verify.post');

Route::get('/admin/reset-password/change', [AdminAuthController::class, 'showChangePassword'])->name('admin.reset.change');
Route::post('/admin/reset-password/change', [AdminAuthController::class, 'changePassword'])->name('admin.reset.change.post');

Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');


Route::prefix('admin')->group(function () {

    // List Produk
    Route::get('/products', [ProductAdminController::class, 'index'])->name('admin.products.index');

    // Create Produk
    Route::get('/products/create', [ProductAdminController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [ProductAdminController::class, 'store'])->name('admin.products.store');

    // Edit Produk
    Route::get('/products/{id}/edit', [ProductAdminController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{id}', [ProductAdminController::class, 'update'])->name('admin.products.update');

    // Delete Produk
    Route::delete('/products/{id}', [ProductAdminController::class, 'destroy'])->name('admin.products.destroy');
});
// Dashboard
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/tentang', [AboutController::class, 'index'])->name('about');
Route::get('/kontak', [ContactController::class, 'index'])->name('contact');
Route::post('/kontak', [ContactController::class, 'send'])->name('contact.send');
Route::get('/', [LandingpageController::class, 'index'])->name('landing');
