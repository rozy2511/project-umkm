@extends('website.layouts.main')
@if($needsAutoRefresh)
<script>
    console.log('🔄 Auto refresh diaktifkan');
    
    // Tampilkan notifikasi kecil
    if(typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'info',
            title: 'Memperbarui...',
            text: 'Menyegarkan halaman untuk perubahan terbaru',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500
        });
    }
    
    // Auto refresh setelah 1.5 detik
    setTimeout(function() {
        console.log('🔃 Melakukan refresh...');
        window.location.reload(true);
    }, 1500);
</script>
@endif
@section('title', 'Homepage')

@section('content')

<style>
    /* ====== HERO SECTION STYLES ====== */
    .hero-banner {
        width: 100%;
        height: 100vh;
        position: relative;
        overflow: hidden;
    }

    /* Background dari database atau fallback default */
    .hero-banner .hero-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        z-index: 1;
        transition: transform 0.5s ease;
    }


    .hero-banner::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.6));
        z-index: 2;
    }

    .hero-content {
        position: relative;
        z-index: 10;
        text-align: center;
    }
        /* Animations */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Button styles */
    .btn-hero {
        background: linear-gradient(135deg, #7b3f00 0%, #633200 100%);
        border: none;
        padding: 12px 32px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        animation: fadeIn 1s ease 0.6s both;
        box-shadow: 0 4px 15px rgba(123, 63, 0, 0.3);
    }

    .btn-hero:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(123, 63, 0, 0.4);
        background: linear-gradient(135deg, #633200 0%, #522800 100%);
    }

    /* ====== RESPONSIVE STYLES ====== */
    @media (max-width: 1024px) {
        .hero-banner {
            height: 80vh;
        }
        .hero-content h1 {
            font-size: 3rem;
        }
        .hero-content p {
            font-size: 1.125rem;
        }
    }

    @media (max-width: 768px) {
        .hero-banner {
            height: 70vh;
        }
        .hero-content h1 {
            font-size: 2.25rem;
        }
        .hero-content p {
            font-size: 1rem;
        }
        .btn-hero {
            padding: 10px 24px;
            font-size: 0.875rem;
        }
    }

    @media (max-width: 480px) {
        .hero-banner {
            height: 60vh;
        }
        .hero-content h1 {
            font-size: 1.875rem;
            padding: 0 1rem;
        }
        .hero-content p {
            font-size: 0.875rem;
            padding: 0 1rem;
        }
    }
</style>

{{-- ====== HERO SECTION (DYNAMIC FROM DATABASE) ====== --}}
<div class="hero-banner flex items-center justify-center pt-20">
    {{-- Background Image dari Database atau Default --}}
    <div class="hero-background" style="
        @if($welcomeImage)
            background-image: url('{{ asset('storage/' . $welcomeImage) }}');
        @else
            background-image: url('/images/9.jpg');
        @endif
    "></div>

    <div class="hero-content text-white text-center px-4">
        {{-- Title dari Database --}}
        <h1 class="welcome-title text-5xl font-bold mb-4">
            {{ $welcomeTitle ?? 'Selamat Datang di UMKM Kami' }}
        </h1>
        
        {{-- Subtitle dari Database --}}
        <p class="welcome-subtitle text-xl mb-6">
            {{ $welcomeSubtitle ?? 'Produk berkualitas dari tangan lokal' }}
        </p>

        {{-- CTA Button --}}
        <a href="/produk" class="btn-hero inline-block text-white font-semibold">
            <i class="fas fa-shopping-bag mr-2"></i> Lihat Produk
        </a>
    </div>
</div>

{{-- GOOGLE MAPS SECTION --}}
<!-- ====== LOKASI & JAM OPERASIONAL ====== -->
<section id="lokasi" class="py-14 bg-gray-100">
    <div class="max-w-6xl mx-auto px-4">

        <h2 class="text-3xl font-bold text-center mb-8">Lokasi & Jam Operasional</h2>

        <div class="grid md:grid-cols-2 gap-10 items-start">

            <!-- MAP - DYNAMIC DARI DATABASE -->
            <div class="shadow-lg rounded-lg overflow-hidden">
                {!! \App\Models\Setting::get('google_maps_embed', '') !!}
            </div>

            <!-- JAM OPERASIONAL - DYNAMIC DARI DATABASE -->
            <div>
                <h3 class="text-2xl font-semibold mb-4">Jam Operasional</h3>
                
                {{-- Deskripsi dengan format WA/markdown --}}
                <div class="text-gray-700 leading-relaxed mb-6">
    {!! \App\Helpers\TextFormatter::formatWaText(\App\Models\Setting::get('operational_description', '')) !!}
</div>

                {{-- Catatan dengan format WA/markdown --}}
                <div class="bg-white p-5 rounded-lg shadow-md border">
                    <p class="font-semibold text-lg mb-1">Catatan:</p>
                    <div class="text-gray-700 space-y-2">
                        {!! \App\Helpers\TextFormatter::formatWaText(\App\Models\Setting::get('operational_notes', '')) !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
