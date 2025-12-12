@extends('website.layouts.main')

@section('title', 'Kontak')

@section('content')
<div class="container mx-auto pt-28 pb-16">
    <h1 class="text-3xl font-semibold mb-4">Hubungi Kami</h1>

    <form class="max-w-lg space-y-4">
        <input type="text" placeholder="Nama"
               class="w-full p-3 border rounded">

        <input type="email" placeholder="Email"
               class="w-full p-3 border rounded">

        <textarea placeholder="Pesan"
                  class="w-full p-3 border rounded h-32"></textarea>

        <button class="px-5 py-3 bg-blue-600 text-white rounded">
            Kirim Pesan
        </button>
    </form>
</div>
@endsection
