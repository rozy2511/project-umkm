@extends('website.layouts.main')

@section('title', $product->name)

@section('content')

@php
    // Cek apakah produk memiliki thumbnail
    $imageUrl = $product->thumbnail 
        ? asset('storage/' . $product->thumbnail) 
        : asset('images/default-product.jpg'); // fallback image
@endphp

<!-- Hero Section dengan background abu-abu solid -->
<div class="bg-gray-500 h-[35vh] flex items-center justify-center text-gray-800">
    <h1 class="text-4xl font-bold">{{ $product->name }}</h1>
</div>

<section class="py-16 bg-[#fffdf9]">
    <div class="container mx-auto px-4 max-w-6xl">

        <div class="grid md:grid-cols-2 gap-10 items-center">
            
            <!-- Swiper Gallery -->
            <div class="space-y-4">
                @if($product->galleries && $product->galleries->count() > 0)
                <!-- Main Swiper -->
                <div class="swiper product-gallery-main">
                    <div class="swiper-wrapper">
                        @foreach($product->galleries as $gallery)
                        <div class="swiper-slide">
                            <img src="{{ asset('storage/' . $gallery->image_path) }}" 
                                 alt="{{ $product->name }}"
                                 class="w-full h-96 object-cover rounded-xl shadow-lg">
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Navigation buttons -->
                    <div class="swiper-button-next bg-white/70 hover:bg-white p-3 rounded-full shadow-lg"></div>
                    <div class="swiper-button-prev bg-white/70 hover:bg-white p-3 rounded-full shadow-lg"></div>
                    
                    <!-- Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
                
                <!-- Thumbnail Swiper -->
                <div class="swiper product-gallery-thumbs mt-4">
                    <div class="swiper-wrapper">
                        @foreach($product->galleries as $gallery)
                        <div class="swiper-slide">
                            <img src="{{ asset('storage/' . $gallery->image_path) }}" 
                                 alt="{{ $product->name }}"
                                 class="w-full h-24 object-cover rounded-lg cursor-pointer border-2 border-transparent hover:border-amber-500 transition-all">
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <!-- Fallback jika tidak ada gallery -->
                <div class="rounded-xl shadow-lg overflow-hidden">
                    <img src="{{ $imageUrl }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-96 object-cover">
                </div>
                @endif
            </div>

            <!-- Product Info -->
            <div>
                <h2 class="text-3xl font-semibold text-[#7b3f00] mb-4">{{ $product->name }}</h2>

                <p class="text-2xl font-bold text-[#7b3f00] mb-6">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>

                <div class="text-lg text-[#5a4633] mb-6">
                    {!! nl2br(e($product->description)) !!}
                </div>

                @if($product->is_top)
                <div class="mb-6">
                    <span class="inline-flex items-center gap-2 px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-sm font-medium">
                        <i class="fas fa-crown text-amber-500"></i>
                        Produk Terlaris
                    </span>
                </div>
                @endif

                <a href="https://wa.me/628123456789?text=Saya%20ingin%20pesan%20{{ urlencode($product->name) }}"
                   target="_blank"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-[#7b3f00] hover:bg-[#5a2e00] text-white font-semibold shadow transition duration-300">
                    <i class="fab fa-whatsapp"></i>
                    Pesan via WhatsApp
                </a>
            </div>
        </div>

    </div>
</section>

@push('styles')
<style>
    /* Custom Swiper Styles */
    .swiper {
        width: 100%;
        border-radius: 12px;
    }
    
    .swiper-slide {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .swiper-slide img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .product-gallery-thumbs .swiper-slide {
        opacity: 0.4;
        transition: opacity 0.3s;
    }
    
    .product-gallery-thumbs .swiper-slide-thumb-active {
        opacity: 1;
        border-color: #7b3f00 !important;
    }
    
    .swiper-button-next,
    .swiper-button-prev {
        color: #7b3f00;
        width: 44px;
        height: 44px;
    }
    
    .swiper-button-next:after,
    .swiper-button-prev:after {
        font-size: 24px;
        font-weight: bold;
    }
    
    .swiper-pagination-bullet {
        background-color: white;
        opacity: 0.5;
        width: 10px;
        height: 10px;
    }
    
    .swiper-pagination-bullet-active {
        background-color: #7b3f00;
        opacity: 1;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if($product->galleries && $product->galleries->count() > 0)
    // Pastikan Swiper tersedia
    if (typeof Swiper !== 'undefined') {
        // Initialize Thumbnail Swiper
        const galleryThumbs = new Swiper('.product-gallery-thumbs', {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
            breakpoints: {
                640: {
                    slidesPerView: 4,
                    spaceBetween: 10,
                },
                768: {
                    slidesPerView: 5,
                    spaceBetween: 10,
                },
                1024: {
                    slidesPerView: 6,
                    spaceBetween: 10,
                },
            }
        });
        
        // Initialize Main Swiper
        const galleryMain = new Swiper('.product-gallery-main', {
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            thumbs: {
                swiper: galleryThumbs,
            },
            loop: true,
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
        });
        
        // Click thumbnail to navigate
        document.querySelectorAll('.product-gallery-thumbs .swiper-slide').forEach((thumb, index) => {
            thumb.addEventListener('click', function() {
                galleryMain.slideTo(index);
            });
        });
    } else {
        console.error('Swiper not loaded. Please check Swiper installation.');
    }
    @endif
});
</script>
@endpush

@endsection