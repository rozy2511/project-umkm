<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'UMKM Shop')</title>

    {{-- Vite CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    @include('website.layouts.navbar')

    <main>
        @yield('content')
    </main>

    @include('website.layouts.footer')

</body>
</html>
