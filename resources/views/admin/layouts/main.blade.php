<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - UMKM</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }
        .sidebar {
            width: 240px;
            background: #1e293b; /* biru gelap seperti navbar website */
            min-height: 100vh;
            padding: 20px 0;
            position: fixed;
            color: white;
        }
        .sidebar a {
            display: block;
            padding: 12px 25px;
            color: #e2e8f0;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #0f172a;
            color: white;
        }
        .content {
            margin-left: 240px;
            padding: 25px;
        }
    </style>
</head>

<body>

    {{-- SIDEBAR --}}
    <div class="sidebar">
        <h4 class="text-center mb-4">Admin UMKM</h4>

        <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
        <a href="{{ route('admin.products.index') }}">🍞 Produk</a>
    </div>

    {{-- CONTENT --}}
    <div class="content">
        @yield('content')
    </div>

</body>
</html>
