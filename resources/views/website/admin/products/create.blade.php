@extends('admin.layouts.main')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-bold mb-5">Tambah Produk</h1>

   <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

        <div>
            <label class="block font-medium">Nama Produk</label>
            <input type="text" name="name" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block font-medium">Harga</label>
            <input type="number" name="price" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block font-medium">Deskripsi</label>
            <textarea name="description" class="w-full border rounded p-2" rows="4" required></textarea>
        </div>

        <div>
            <label class="block font-medium">Thumbnail Produk</label>
            <input type="file" name="thumbnail" class="w-full" required>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection
