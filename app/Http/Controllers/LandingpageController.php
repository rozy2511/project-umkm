<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SocialMedia; // <-- TAMBAH INI

class LandingpageController extends Controller
{
    public function index()
    {
        // ============================================
        // AMBIL DATA SOCIAL MEDIA YANG AKTIF
        // ============================================
        $socialMedias = SocialMedia::where('is_active', true)
            ->whereNotNull('url')
            ->orderBy('order')
            ->get();
        
        // ============================================
        // KODE LAIN JIKA ADA (products, categories, dll)
        // ============================================
        // Contoh jika ada data lain:
        // $products = Product::where('featured', true)->limit(6)->get();
        // $categories = Category::all();
        
        // ============================================
        // RETURN VIEW DENGAN SEMUA DATA
        // ============================================
        return view('website.index', [
            'socialMedias' => $socialMedias,
            
            // Jika ada data lain, tambahkan di sini:
            // 'products' => $products ?? [],
            // 'categories' => $categories ?? [],
            // 'testimonials' => $testimonials ?? [],
        ]);
    }
}