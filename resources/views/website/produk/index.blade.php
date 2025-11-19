@extends('website.layouts.main')

@section('title', 'Produk Kami')

@section('content')

<section class="py-16 bg-[#fdf7f1]">
    <div class="container mx-auto px-4">

        <h2 class="text-3xl font-semibold text-center text-[#7b3f00] mb-10">
            Pilihan Jajanan & Minuman
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

            @forelse ($products as $item)
                <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-[#e8d6c4] hover:scale-[1.02] transition-transform duration-300 relative">
                    
                    <!-- BADGE BEST SELLER -->
                   @if($item->is_top)
    <div class="absolute -top-2 -left-2 z-10 transform -rotate-12">
        <img src="{{ asset('images/best-seller-label.png') }}" 
             alt="BEST SELLER" 
             class="h-26 w-auto drop-shadow-lg">
    </div>
@endif

                    <a href="{{ route('products.show', $item->slug) }}">
                        <!-- CONTAINER GAMBAR DENGAN BACKGROUND & BORDER -->
                        <div class="w-full h-75 bg-gray-100 flex items-center justify-center overflow-hidden">
                            <img src="{{ asset('storage/' . $item->thumbnail) }}"
                                alt="{{ $item->name }}"
                                class="w-full h-full object-cover">
                        </div>
                    </a>
                    <div class="p-5 text-[#5a4633]">
                        <h3 class="text-xl font-semibold mb-1 text-[#7b3f00]">
                            {{ $item->name }}
                        </h3>

                        <p class="text-lg font-medium mb-4">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </p>

                        <a href="https://wa.me/628123456789?text=Saya%20ingin%20pesan%20{{ urlencode($item->name) }}%20-%20Rp%20{{ number_format($item->price, 0, ',', '.') }}"
                           target="_blank"
                           class="block text-center w-full py-2 rounded-lg font-semibold
                                  bg-[#7b3f00] text-white hover:bg-[#633200] transition">
                            Pesan via WhatsApp
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-600 col-span-3 py-8">Belum ada produk tersedia.</p>
            @endforelse

        </div>

    </div>
</section>

@endsection