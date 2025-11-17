@extends('admin.layouts.main')

<h2>Tambah Produk</h2>

<form action="{{ route('admin.products.store') }}" method="POST">
    @csrf

    <label>Nama Produk</label>
    <input type="text" name="name">

    <label>Slug</label>
    <input type="text" name="slug">

    <label>Harga</label>
    <input type="number" name="price">

    <label>Deskripsi</label>
    <textarea name="description"></textarea>

    <button type="submit">Simpan</button>
</form>
