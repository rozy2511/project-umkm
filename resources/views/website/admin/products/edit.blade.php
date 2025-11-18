@extends('admin.layouts.main')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-bold mb-5">Edit Produk</h1>

    <form action="route('admin.products.update', $product->id)" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium">Nama Produk</label>
            <input type="text" name="name" value="{{ $product->name }}" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block font-medium">Harga</label>
            <input type="number" name="price" value="{{ $product->price }}" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block font-medium">Deskripsi</label>
            <textarea name="description" class="w-full border rounded p-2" rows="4" required>{{ $product->description }}</textarea>
        </div>

        <div>
            <label class="block font-medium">Thumbnail Saat Ini</label>
            <img src="{{ asset('storage/' . $product->thumbnail) }}" class="h-32 rounded mb-2">

            <label class="block font-medium mt-2">Ganti Thumbnail (opsional)</label>
            <input type="file" name="thumbnail" class="w-full">
        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection
