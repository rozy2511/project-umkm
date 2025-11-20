@extends('website.layouts.main')

@section('title', 'Kontak Kami')

@section('content')

<style>
    .contact-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 80vh;
        padding: 4rem 0;
    }

    .contact-info {
        background: #7b3f00;
        color: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(123, 63, 0, 0.2);
    }

    .contact-method {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .contact-method:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .contact-details h3 {
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 1.125rem;
        color: white;
    }

    .contact-details p {
        opacity: 0.9;
        font-size: 0.875rem;
        line-height: 1.5;
    }

    .info-label {
        display: inline-block;
        background: rgba(255,255,255,0.1);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .action-buttons {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .whatsapp-btn, .call-btn, .email-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        border: none;
        flex: 1;
        text-align: center;
    }

    .whatsapp-btn {
        background: #25D366;
        color: white;
    }

    .call-btn {
        background: #007bff;
        color: white;
    }

    .email-btn {
        background: #6c757d;
        color: white;
    }
</style>

<section class="contact-section">
    <div class="container mx-auto px-4">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Hubungi Kami</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Butuh bantuan atau ingin bertanya tentang produk kami? 
                Hubungi langsung via WhatsApp atau Telepon.
            </p>
        </div>

        <div class="max-w-2xl mx-auto">
            <div class="contact-info">
                <h2 class="text-2xl font-bold mb-8 text-center">Kontak Langsung</h2>
                
                <div class="space-y-2">
                    <!-- Alamat -->
                    <div class="contact-method">
                        <span class="info-label">ALAMAT</span>
                        <div class="contact-details">
                            <h3>Lokasi Kami</h3>
                            <p>
                                Jl. Prof. DR. Soepomo SH No.29<br>
                                Muja Muju, Kec. Umbulharjo<br>
                                Kota Yogyakarta 55165
                            </p>
                        </div>
                    </div>

                    <!-- Telepon & WhatsApp -->
                    <div class="contact-method">
                        <span class="info-label">KONTAK</span>
                        <div class="contact-details">
                            <h3>Telepon & WhatsApp</h3>
                            <p class="text-lg font-semibold mb-4">+62 812-3593-8380</p>
                            
                            <div class="action-buttons">
                                <a href="https://wa.me/6281235938380?text=Halo,%20saya%20ingin%20bertanya%20tentang%20produk%20UMKM%20Anda" 
                                   target="_blank" 
                                   class="whatsapp-btn">
                                    WhatsApp
                                </a>
                                <a href="tel:+6281235938380" 
                                   class="call-btn">
                                    Telepon
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="contact-method">
                        <span class="info-label">EMAIL</span>
                        <div class="contact-details">
                            <h3>Email</h3>
                            <p class="mb-4">muhammadfchrurrozyrozy@gmail.com</p>
                            <a href="mailto:muhammadfchrurrozyrozy@gmail.com" 
                               class="email-btn">
                                Kirim Email
                            </a>
                        </div>
                    </div>
                    {{-- Tambahkan di contact page, sebelum jam operasional --}}
<div class="contact-method">
    <span class="info-label">LAYANAN PESANAN KHUSUS</span>
    <div class="contact-details">
        <h3 class="text-lg font-bold mb-3">Pesan Snack Dus Custom</h3>
        
        <div class="space-y-3">
            <div class="flex items-start">
                <div class=" w-6 h-6 bg-white/20 rounded-full flex items-center justify-center mt-0.5">
                    <span class="text-xs font-bold">✓</span>
                </div>
                <p class="ml-3 text-white/90 leading-relaxed">
                    Menerima pesanan <span class="font-semibold">partai besar & kecil</span> dengan harga kompetitif
                </p>
            </div>
            
            <div class="flex items-start">
                <div class=" w-6 h-6 bg-white/20 rounded-full flex items-center justify-center mt-0.5">
                    <span class="text-xs font-bold">✓</span>
                </div>
                <p class="ml-3 text-white/90 leading-relaxed">
                    <span class="font-semibold">Snack dus custom</span> - bisa campur berbagai varian atau fokus satu jenis favorit
                </p>
            </div>
            
            <div class="flex items-start">
                <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center mt-0.5">
                    <span class="text-xs font-bold">✓</span>
                </div>
                <p class="ml-3 text-white/90 leading-relaxed">
                    Cocok untuuk <span class="font-semibold">acara arisan, kumpulan keluarga, meeting kantor, atau acara formal lainnya </span>
                </p>
            </div>
        </div>
    </div>
</div>

                    <!-- Jam Operasional -->
                    <div class="contact-method">
                        <span class="info-label">JAM OPERASIONAL</span>
                        <div class="contact-details">
                            <h3>Waktu Pelayanan</h3>
                            <p>
                                <strong>Setiap Hari:</strong><br>
                                05.30 WIB - Selesai
                            </p>
                            <p class="text-sm opacity-80 mt-2">
                                Buka pagi pukul setengah 6 dan tutup sehabisnya
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection