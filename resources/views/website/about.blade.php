@extends('website.layouts.main')

@section('title', 'Tentang Kami')

@section('content')

{{-- Hero Section --}}
<div class="relative bg-cover bg-center h-[55vh] flex items-center justify-center text-white"
     style="background-image: url('/images/dumy.png');">

    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm"></div>

    <div class="relative text-center drop-shadow-xl px-4">
        <h1 class="text-5xl font-bold tracking-wide">Tentang Kami</h1>
        <p class="mt-3 text-xl opacity-95">Mengangkat cita rasa lokal dengan sepenuh hati</p>
    </div>
</div>


{{-- About Section --}}
<section class="py-16 bg-[#fdf3e7]">
    <div class="container mx-auto px-4 max-w-4xl">

        <h2 class="text-3xl font-bold mb-6 text-center text-[#7b3f00]">
            Siapa Kami?
        </h2>

        <p class="text-lg leading-relaxed text-[#5a4633] text-center">
            Sebuah UMKM kuliner yang menyediakan aneka jajan pasar, minuman segar, dan pilihan nasi bungkus untuk memenuhi kebutuhan masyarakat sekitar dan karyawan kantor. 
            Setiap produk dibuat dengan cita rasa tradisional, kualitas yang terjaga, serta harga yang tetap terjangkau. Beragam hidangan seperti tahu bakso, risol, apem, gethuk, dan berbagai menu lainnya dihadirkan 
            setiap hari sebagai pilihan praktis untuk sarapan, camilan, maupun makan siang. UMKM ini terus berkembang bersama lingkungan sekitar dengan menghadirkan makanan yang hangat, segar, dan siap dinikmati kapan saja.
        </p>
    </div>
</section>


{{-- Perjalanan Kami - Zigzag --}}
<section class="py-20 bg-white">
    <div class="container mx-auto px-4 max-w-6xl">

        <h3 class="text-2xl font-semibold mb-12 text-[#7b3f00] text-center">
            Perjalanan Kami
        </h3>

        {{-- 1990-an --}}
        <div class="grid md:grid-cols-2 gap-10 items-center mb-16">
            
            {{-- Foto kiri --}}
            <div class="rounded-xl overflow-hidden shadow-md border border-[#e8d6c4] bg-[#fff8f1]">
                <img src="/images/dumy.png"
                     class="w-full h-72 object-cover" alt="">
            </div>

            {{-- Teks kanan --}}
            <div>
                <h4 class="text-xl font-bold text-[#7b3f00] mb-2">1990-an</h4>
                <p class="text-lg leading-relaxed text-[#5a4633]">
                    Usaha ini dimulai sebagai lapak sederhana yang menjual hidangan khas Jawa.
                    Menu yang dihadirkan masih terbatas, namun semuanya dibuat dengan resep
                    rumahan tradisional yang menjadi ciri khas hingga sekarang.
                </p>
            </div>

        </div>

        {{-- 2021 --}}
        <div class="grid md:grid-cols-2 gap-10 items-center mb-16 md:flex-row-reverse">

            {{-- Foto kanan --}}
            <div class="rounded-xl overflow-hidden shadow-md border border-[#e8d6c4] bg-[#fff8f1] md:order-2">
                <img src="/images/dumy.png"
                     class="w-full h-72 object-cover" alt="">
            </div>

            {{-- Teks kiri --}}
            <div class="md:order-1">
                <h4 class="text-xl font-bold text-[#7b3f00] mb-2">2021</h4>
                <p class="text-lg leading-relaxed text-[#5a4633]">
                    Di tahun ini, fokus usaha mulai bergeser menjadi jajanan pasar tradisional.
                    Permintaan pelanggan meningkat dan variasi produk mulai diperluas dengan tetap
                    mempertahankan cita rasa khas rumahan.
                </p>
            </div>

        </div>

        {{-- 2024 --}}
        <div class="grid md:grid-cols-2 gap-10 items-center">

            {{-- Foto kiri --}}
            <div class="rounded-xl overflow-hidden shadow-md border border-[#e8d6c4] bg-[#fff8f1]">
                <img src="/images/dumy.png"
                     class="w-full h-72 object-cover" alt="">
            </div>

            {{-- Teks kanan --}}
            <div>
                <h4 class="text-xl font-bold text-[#7b3f00] mb-2">2024</h4>
                <p class="text-lg leading-relaxed text-[#5a4633]">
                    Tahun ini menjadi langkah baru dengan hadirnya Es Teh Jumbo sebagai salah satu
                    produk yang langsung diminati pelanggan. Produk ini menjadi identitas baru yang
                    melengkapi jajanan pasar yang sudah dikenal sejak lama.
                </p>
            </div>

        </div>

    </div>
</section>



{{-- Produk Unggulan --}}
<section class="py-16 bg-[#fdf3e7]">
    <div class="container mx-auto px-4 max-w-5xl">
        <h3 class="text-2xl font-semibold mb-6 text-[#7b3f00] text-center">Produk Unggulan</h3>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow p-6 text-center">
                <div class="w-28 h-28 mx-auto rounded-full overflow-hidden bg-[#e8d6c4] mb-4">
                    <img src="/images/unggulan.png" class="w-full h-full object-cover">
                </div>
                <h4 class="font-semibold text-lg text-[#7b3f00]">Donat Kentang</h4>
                <p class="text-sm text-[#5a4633] mt-2">Donat kentang original — tekstur lembut dan rasa autentik.</p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 text-center">
                <div class="w-28 h-28 mx-auto rounded-full overflow-hidden bg-[#e8d6c4] mb-4">
                    <img src="/images/unggulan.png" class="w-full h-full object-cover">
                </div>
                <h4 class="font-semibold text-lg text-[#7b3f00]">Risol Mayo Pedas</h4>
                <p class="text-sm text-[#5a4633] mt-2">Isian beef slice, telur, dan mayo pedas — favorit pelanggan.</p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 text-center">
                <div class="w-28 h-28 mx-auto rounded-full overflow-hidden bg-[#e8d6c4] mb-4">
                    <img src="/images/unggulan.png" class="w-full h-full object-cover">
                </div>
                <h4 class="font-semibold text-lg text-[#7b3f00]">Kukus Gula Jawa</h4>
                <p class="text-sm text-[#5a4633] mt-2">Kue kukus tradisional dengan rasa gula jawa yang kaya.</p>
            </div>
        </div>
    </div>
</section>


{{-- Layanan --}}
<section class="py-16 bg-[#fdf3e7]">
    <div class="container mx-auto px-4 max-w-4xl text-[#5a4633]">
        <h3 class="text-2xl font-semibold mb-4 text-[#7b3f00] text-center">Layanan & Pemesanan</h3>

        <p class="text-center mb-6">
            Tersedia layanan pemesanan jajanan pasar dan snack dus untuk kebutuhan acara kecil hingga partai besar.
        </p>

        <div class="flex flex-col md:flex-row gap-4 md:gap-6 items-center justify-center">
            <a href="/kontak" class="btn-primary">
    Hubungi Kami
</a>

            <a href="https://wa.me/628123456789" target="_blank" class="btn-outline">
    Pesan via WhatsApp
</a>
        </div>
    </div>
</section>


{{-- Penutup --}}
<section class="py-12">
    <div class="container mx-auto px-4 text-center">
        <p class="text-gray-600 max-w-2xl mx-auto">
            Terima kasih telah melihat perjalanan dan produk yang ditawarkan.  
            Kami terus berupaya menjaga kualitas dan menghadirkan cita rasa tradisional untuk dinikmati semua.
        </p>
    </div>
</section>

@endsection
