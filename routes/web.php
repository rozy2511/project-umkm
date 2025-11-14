<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingpageController;
use App\Http\Controllers\Website\ProductController;
use App\Http\Controllers\Website\AboutController;
use App\Http\Controllers\Website\ContactController;

Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/tentang', [AboutController::class, 'index'])->name('about');
Route::get('/kontak', [ContactController::class, 'index'])->name('contact');
Route::post('/kontak', [ContactController::class, 'send'])->name('contact.send');
Route::get('/', [LandingpageController::class, 'index'])->name('landing');
