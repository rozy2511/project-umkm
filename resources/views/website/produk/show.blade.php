@extends('website.layouts.main')

@section('title', $product['name'])

@section('content')

<div class="relative bg-cover bg-center h-[35vh] flex items-center justify-center text-white"
     style="background-image: url('{{ $product['image'] }}');">
    <div class="absolute inset-0 bg-black/40"></div>
    <h1 class="relative text-4xl font-bold drop-shadow-xl">{{ $product['name'] }}</h1>
</div>

<section class="py-16 bg-[#fffdf9]">
    <div class="container mx-auto px-4 max-w-4xl">

        <div class="grid md:grid-cols-2 gap-10 items-center">
            <img src="{{ $product['image'] }}" class="rounded-xl shadow-lg w-full object-cover">

            <div>
                <h2 class="text-3xl font-semibold text-[#7b3f00] mb-4">{{ $product['name'] }}</h2>

                <p class="text-2xl font-bold text-[#7b3f00] mb-6">
                    Rp {{ $product['price'] }}
                </p>

                <p class="text-lg text-[#5a4633] mb-4">
                    {{ $product['short_description'] }}
                </p>

                <a href="https://wa.me/628123456789?text=Saya%20ingin%20pesan%20{{ urlencode($product['name']) }}"
                   class="inline-block px-6 py-3 rounded-lg bg-[#7b3f00] text-white font-semibold shadow">
                    Pesan via WhatsApp
                </a>
            </div>
        </div>

    </div>
</section>

@endsection
