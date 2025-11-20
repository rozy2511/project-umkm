@extends('website.layouts.main')

@section('title', 'Homepage')

@section('content')

<style>
    .hero-banner {
        width: 100%;
        height: 100vh;
        background-image: url('/images/dumy.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
    }

    .hero-banner::after {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.3);
    }

    .hero-content {
        position: relative;
        z-index: 10;
    }

    /* RESPONSIVE FIXES */
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
            background-attachment: scroll;
        }
        .hero-content h1 {
            font-size: 2.25rem;
        }
        .hero-content p {
            font-size: 1rem;
        }
        .btn-solid-lg {
            padding: 0.75rem 1.5rem;
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

{{-- HERO SECTION --}}
<div class="hero-banner flex items-center justify-center pt-20">
    <div class="hero-content text-white text-center px-4">
        <h1 class="text-5xl font-bold drop-shadow-lg mb-4">Selamat Datang di UMKM Kami</h1>
        <p class="text-xl drop-shadow-md mb-6">Produk berkualitas dari tangan lokal</p>

        <a href="#lokasi"
           class="btn-solid-lg inline-block bg-[#7b3f00] text-white px-6 py-3 rounded-lg font-semibold
                  hover:bg-[#633200] transition shadow-lg">
            Lihat Lokasi
        </a>
    </div>
</div>

{{-- GOOGLE MAPS SECTION --}}
<!-- ====== LOKASI & JAM OPERASIONAL ====== -->
<section id="lokasi" class="py-14 bg-gray-100">
    <div class="max-w-6xl mx-auto px-4">

        <h2 class="text-3xl font-bold text-center mb-8">Lokasi & Jam Operasional</h2>

        <div class="grid md:grid-cols-2 gap-10 items-start">

            <!-- MAP -->
            <div class="shadow-lg rounded-lg overflow-hidden">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.8561165711926!2d110.38808367412085!3d-7.805052877483105!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a5771db9c4187%3A0xec37835a1078919f!2sGudeg%20Bu%20Susi!5e0!3m2!1sid!2sid!4v1763617893276!5m2!1sid!2sid" 
                    width="100%" 
                    height="350" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

            <!-- JAM OPERASIONAL -->
            <div>
                <h3 class="text-2xl font-semibold mb-4">Jam Operasional</h3>
                <p class="text-gray-700 leading-relaxed mb-6">
                    Kami buka setiap hari mulai pukul <strong>05.30 pagi</strong>. 
                    Namun perlu diketahui bahwa <strong>stok makanan terbatas</strong> dan sering habis lebih cepat, 
                    terutama karena banyak pelanggan dari area kantor terdekat dan juga anak sekolah yang membeli saat pagi hari.
                </p>

                <div class="bg-white p-5 rounded-lg shadow-md border">
                    <p class="font-semibold text-lg mb-1">Catatan:</p>
                    <ul class="text-gray-700 space-y-2">
                        <li>• Semakin siang, semakin sedikit makanan yang tersisa.</li>
                        <li>• Jam tutup **tidak menentu**, biasanya mengikuti habisnya persediaan.</li>
                        <li>• Disarankan datang lebih pagi agar kebagian menu lengkap.</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>


@endsection
