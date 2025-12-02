<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductGallery;
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
            'gallery' => 'required|array|min:2|max:7',
            'gallery.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'is_top' => 'nullable|boolean'
        ]);

        // Upload gambar thumbnail
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            $thumbnailPath = $request->file('thumbnail')->store('products/thumbnails', 'public');
            logger('Thumbnail uploaded successfully:', ['path' => $thumbnailPath]);
        } else {
            return back()->withErrors(['thumbnail' => 'Gagal mengupload gambar thumbnail'])->withInput();
        }

        // Validasi gallery
        if (!$request->hasFile('gallery') || count($request->file('gallery')) < 2) {
            return back()->withErrors(['gallery' => 'Minimal harus upload 2 foto gallery'])->withInput();
        }

        // Buat slug otomatis dari nama
        $slug = Str::slug($request->name);
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

        // CREATE produk
        $product = Product::create([
            'name'        => $request->name,
            'slug'        => $slug,
            'price'       => $price,
            'description' => $request->description,
            'thumbnail'   => $thumbnailPath,
            'is_top'      => $request->has('is_top')
        ]);

        // Upload gallery images
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $file) {
                if ($file->isValid()) {
                    $path = $file->store('products/gallery', 'public');
                    
                    ProductGallery::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'order' => $index
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $product = Product::with('galleries')->findOrFail($id);
        return view('website.admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::with('galleries')->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'thumbnail' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
            'gallery' => 'nullable|array|max:7',
            'gallery.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'is_top' => 'nullable|boolean'
        ]);

        // Upload gambar baru jika ada
        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            // Hapus gambar lama
            if ($product->thumbnail && Storage::disk('public')->exists($product->thumbnail)) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            
            // Upload gambar baru
            $thumbnailPath = $request->file('thumbnail')->store('products/thumbnails', 'public');
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

        // Handle gallery deletions
        if ($request->has('delete_galleries')) {
            $deleteIds = is_array($request->delete_galleries) 
                ? $request->delete_galleries 
                : explode(',', $request->delete_galleries);
                
            foreach ($deleteIds as $galleryId) {
                if (!empty($galleryId)) {
                    $gallery = ProductGallery::find($galleryId);
                    if ($gallery && $gallery->product_id == $product->id) {
                        // Hapus file dari storage
                        if (Storage::disk('public')->exists($gallery->image_path)) {
                            Storage::disk('public')->delete($gallery->image_path);
                        }
                        // Hapus record dari database
                        $gallery->delete();
                    }
                }
            }
        }

        // Upload new gallery images
        if ($request->hasFile('gallery')) {
            // Hitung gambar yang sudah ada
            $existingCount = $product->galleries()->count();
            $maxAllowed = 7 - $existingCount;
            
            if ($maxAllowed > 0) {
                $files = array_slice($request->file('gallery'), 0, $maxAllowed);
                
                foreach ($files as $index => $file) {
                    if ($file->isValid()) {
                        $path = $file->store('products/gallery', 'public');
                        
                        ProductGallery::create([
                            'product_id' => $product->id,
                            'image_path' => $path,
                            'order' => $existingCount + $index
                        ]);
                    }
                }
            }
        }

        $product->name = $request->name;
        $product->price = $price;
        $product->description = $request->description;
        $product->is_top = $request->has('is_top');
        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        try {
            $product = Product::with('galleries')->findOrFail($id);
            
            // Hapus file thumbnail jika ada
            if ($product->thumbnail && Storage::disk('public')->exists($product->thumbnail)) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            
            // Hapus gallery images
            foreach ($product->galleries as $gallery) {
                if (Storage::disk('public')->exists($gallery->image_path)) {
                    Storage::disk('public')->delete($gallery->image_path);
                }
                $gallery->delete();
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