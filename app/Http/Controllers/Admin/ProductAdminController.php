<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductAdminController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('website.admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('website.admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Upload gambar - versi paling stabil
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {

            // Ganti storeAs() -> store() agar Laravel handle filenamenya otomatis
            $thumbnailPath = $request->file('thumbnail')->store('products', 'public');

            // DEBUG LOG (optional)
            logger('File uploaded successfully:', ['path' => $thumbnailPath]);

        } else {
            return back()->withErrors(['thumbnail' => 'Gagal mengupload gambar'])->withInput();
        }

        // Buat slug otomatis dari nama
        $slug = Str::slug($request->name);

        // Cek jika slug sudah ada, tambahkan angka
        $originalSlug = $slug;
        $counter = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Konversi harga
        $price = $request->price;
        if (is_string($price)) {
            $price = str_replace('.', '', $price);
        }

        // CREATE dengan data lengkap
        Product::create([
            'name'        => $request->name,
            'slug'        => $slug,
            'price'       => $price,
            'description' => $request->description,
            'thumbnail'   => $thumbnailPath
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }
}
