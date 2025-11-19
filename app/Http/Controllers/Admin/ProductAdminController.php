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
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'is_top' => 'nullable|boolean'
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

        // CREATE dengan data lengkap + is_top
        Product::create([
            'name'        => $request->name,
            'slug'        => $slug,
            'price'       => $price,
            'description' => $request->description,
            'thumbnail'   => $thumbnailPath,
            'is_top'      => $request->has('is_top') // TAMBAH INI
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('website.admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'thumbnail' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
            'is_top' => 'nullable|boolean' // TAMBAH INI
        ]);

        // Upload gambar baru jika ada
        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            // Hapus gambar lama
            if ($product->thumbnail && Storage::disk('public')->exists($product->thumbnail)) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            
            // Upload gambar baru
            $thumbnailPath = $request->file('thumbnail')->store('products', 'public');
            $product->thumbnail = $thumbnailPath;
        }

        // Update slug jika nama berubah
        if ($product->name != $request->name) {
            $slug = Str::slug($request->name);
            
            // Cek jika slug sudah ada (selain produk ini)
            $originalSlug = $slug;
            $counter = 1;
            while (Product::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            $product->slug = $slug;
        }

        // Konversi harga
        $price = $request->price;
        if (is_string($price)) {
            $price = str_replace('.', '', $price);
        }

        $product->name = $request->name;
        $product->price = $price;
        $product->description = $request->description;
        $product->is_top = $request->has('is_top'); // TAMBAH INI
        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            
            // Hapus file thumbnail jika ada
            if ($product->thumbnail && Storage::disk('public')->exists($product->thumbnail)) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            
            $productName = $product->name;
            $product->delete();

            return redirect()->route('admin.products.index')
                           ->with('success', "Produk '{$productName}' berhasil dihapus!");
            
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')
                           ->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }
}