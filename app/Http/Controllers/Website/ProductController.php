<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Halaman daftar produk
     */
    public function index()
    {
        // Ambil semua produk dari database dengan urutan TOP dulu
        $products = Product::orderBy('is_top', 'DESC')  // Produk TOP di atas
                          ->orderBy('created_at', 'DESC') // Kemudian yang terbaru
                          ->get();

        // kirim ke view - PAKAI PATH YANG BENAR
        return view('website.produk.index', compact('products'));
    }

    /**
     * Halaman detail produk
     */
    public function show($slug)
    {
        // cari produk berdasarkan slug
        $product = Product::where('slug', $slug)->first();

        if (!$product) {
            abort(404);
        }

        return view('website.produk.show', compact('product'));
    }
}