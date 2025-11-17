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
        // Ambil semua produk dari database
        $products = Product::orderBy('created_at', 'DESC')->get();

        // kirim ke view
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
