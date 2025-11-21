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
            background: #1e293b;
            min-height: 100vh;
            padding: 20px 0;
            position: fixed;
            color: white;
            transition: transform 0.3s ease-in-out;
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
            transition: margin-left 0.3s ease-in-out;
        }

        /* ===== MOBILE MODE ===== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%); /* sembunyikan */
                z-index: 1000;
                background: rgba(30, 41, 59, 0.1) !important;
                backdrop-filter: blur(25px);
                -webkit-backdrop-filter: blur(25px);
                border-right: 1px solid rgba(255, 255, 255, 0.2);
            }

            .sidebar.show-sidebar {
                transform: translateX(0); /* muncul */
            }

            /* Biarkan tulisan tetap solid dan jelas */
            .sidebar h4,
            .sidebar a {
                background: transparent !important;
                color: #1e293b !important;
                font-weight: 600;
                text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
            }

            .sidebar a:hover {
                background: rgba(30, 41, 59, 0.2) !important;
                color: #1e293b !important;
            }

            /* HAMBURGER MENU ANIMATED - POSISI DI KANAN ATAS SIDEBAR */
            .menu-toggle {
                display: block;
                background: transparent;
                border: none;
                padding: 12px;
                position: fixed;
                top: 15px;
                right: 15px;
                z-index: 1002;
                cursor: pointer;
            }

            .hamburger {
                display: block;
                position: relative;
                width: 24px;
                height: 18px;
            }

            .hamburger span {
                display: block;
                position: absolute;
                height: 2px;
                width: 100%;
                background: #333;
                border-radius: 2px;
                opacity: 1;
                left: 0;
                transform: rotate(0deg);
                transition: all 0.3s ease-in-out;
            }

            .hamburger span:nth-child(1) {
                top: 0px;
            }

            .hamburger span:nth-child(2) {
                top: 8px;
            }

            .hamburger span:nth-child(3) {
                top: 16px;
            }

            /* Hamburger Animation ketika sidebar aktif */
            .sidebar.show-sidebar ~ .menu-toggle .hamburger span:nth-child(1) {
                top: 8px;
                transform: rotate(135deg);
                background: #333;
            }

            .sidebar.show-sidebar ~ .menu-toggle .hamburger span:nth-child(2) {
                opacity: 0;
                left: -20px;
            }

            .sidebar.show-sidebar ~ .menu-toggle .hamburger span:nth-child(3) {
                top: 8px;
                transform: rotate(-135deg);
                background: #333;
            }

            /* Floating effect untuk tombol */
            .menu-toggle {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
                border: 1px solid rgba(255, 255, 255, 0.2);
                transition: all 0.3s ease;
            }

            .menu-toggle:hover {
                transform: scale(1.05);
                box-shadow: 0 6px 25px rgba(0, 0, 0, 0.2);
            }

            .menu-toggle:active {
                transform: scale(0.95);
            }
            
            .content {
                margin-left: 0;
                padding: 25px;
                padding-top: 70px;
            }

            /* Overlay ketika sidebar terbuka */
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.3);
                z-index: 999;
            }

            .sidebar-overlay.active {
                display: block;
            }
        }

        /* desktop: sembunyikan menu button & normal sidebar */
        @media (min-width: 769px) {
            .menu-toggle {
                display: none;
            }
            .sidebar {
                background: #1e293b !important;
                backdrop-filter: none !important;
            }
            .sidebar-overlay {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    {{-- SIDEBAR --}}
    <div class="sidebar" id="sidebar">
        <h4 class="text-center mb-4">Admin UMKM</h4>
        <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
        <a href="{{ route('admin.products.index') }}">🍞 Produk</a>
    </div>

    <!-- Overlay untuk mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Tombol Menu (Mobile Only) - POSISI DI KANAN ATAS -->
    <button class="menu-toggle" onclick="toggleSidebar()">
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </button>

    {{-- CONTENT --}}
    <div class="content">
        @yield('content')
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('show-sidebar');
            overlay.classList.toggle('active');
        }

        // Close sidebar ketika klik di luar sidebar
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const menuToggle = document.querySelector('.menu-toggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !menuToggle.contains(event.target) &&
                sidebar.classList.contains('show-sidebar')) {
                sidebar.classList.remove('show-sidebar');
                overlay.classList.remove('active');
            }
        });

        // Close sidebar dengan ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                if (sidebar.classList.contains('show-sidebar')) {
                    sidebar.classList.remove('show-sidebar');
                    overlay.classList.remove('active');
                }
            }
        });
    </script>

</body>
</html>
