@extends('website.layouts.main')

@section('title', 'Homepage')

@section('content')

<style>
    .hero-banner {
        max-width: 100%;
        height: 100vh;
        background-image: url('/images/dumy.png'); /* Ganti dengan path gambar Anda */
        background-size: cover;          /* Full tapi tetap rapi */
        background-position: center;     /* Bagian penting terjaga */
        background-repeat: no-repeat;
        position: relative;
    }

    /* Optional overlay biar teks lebih jelas */
    .hero-banner::after {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.3);
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }
</style>

<div class="hero-banner flex items-center justify-center pt-20">
    <div class="hero-content text-white text-center">
        <h1 class="text-5xl font-bold drop-shadow-lg">Selamat Datang di UMKM Kami</h1>
        <p class="mt-4 text-xl drop-shadow-md">Produk berkualitas dari tangan lokal</p>
        <a class="btn-solid-lg page-scroll" href="#intro">Selengkapnya</a>
    </div>
</div>

<div class="section products py-20">
    <div class="container">
        <h2 class="text-3xl font-bold mb-6 text-center">Produk Unggulan</h2>

        {{-- nanti diganti grid produk --}}
        <p class="text-center">Sedang disiapkan...</p>
    </div>
</div>

@endsection
