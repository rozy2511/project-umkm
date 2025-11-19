<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UMKM Shop')</title>
    <link rel="stylesheet" href="/build/assets/app-CNa4NKUf.css">
    <script src="/build/assets/app-Cjp3yYZ7.js"></script>
</head>

<body>

    @include('website.layouts.navbar')

    <main>
        @yield('content')
    </main>

    @include('website.layouts.footer')

</body>
</html>
