<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - UMKM</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { background: #f4f6f9; }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            background: #1e293b;
            min-height: 100vh;
            padding: 20px 0;
            position: fixed;
            color: white;
            transition: transform .3s ease;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 25px;
            color: #e2e8f0;
            text-decoration: none;
            font-size: 15px;
        }

        .sidebar a:hover {
            background: #0f172a;
            color: #fff;
        }

        .content {
            margin-left: 240px;
            padding: 25px;
            transition: margin-left 0.3s ease;
        }

        /* MOBILE SIDEBAR */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show-sidebar { transform: translateX(0); }
            .content { margin-left: 0; padding-top: 70px; }
            .menu-toggle { display: block; }
        }

        /* HIDDEN DESKTOP */
        .menu-toggle { display: none; }

        /* SUBMENU */
        .settings-toggle {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-right: 25px;
            cursor: pointer;
        }

        .settings-arrow {
            transition: transform .35s cubic-bezier(.68,-0.55,.27,1.55);
            font-size: 14px;
        }

        .settings-toggle.active .settings-arrow {
            transform: rotate(180deg);
        }

        .settings-submenu {
            overflow: hidden;
            height: 0;
            opacity: 0;
            transition: height .35s ease, opacity .35s ease;
            margin-left: 15px;
        }

        .settings-submenu.open {
            height: auto;
            opacity: 1;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">

        <h4 class="text-center mb-4">Admin UMKM</h4>

        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <a href="{{ route('admin.products.index') }}">
            <i class="bi bi-bag-check"></i> Produk
        </a>

        <a href="{{ route('admin.social.index') }}">
            <i class="bi bi-share"></i> Sosial Media
        </a>

        <!-- PENGATURAN -->
        <a href="javascript:void(0)" class="settings-toggle" onclick="toggleSettings()">
            <span><i class="bi bi-gear"></i> Pengaturan Umum</span>
            <span class="settings-arrow"><i class="bi bi-chevron-down"></i></span>
        </a>

        <div class="settings-submenu" id="settingsSubmenu">
            <a href="{{ route('admin.settings.location') }}">
                <i class="bi bi-geo-alt"></i> Lokasi & Jam Operasional
            </a>

            <a href="{{ route('admin.settings.logo') }}">
                <i class="bi bi-image"></i> Logo & Favicon
            </a>

            <a href="{{ route('admin.settings.welcome') }}">
                <i class="bi bi-hand-thumbs-up"></i> Welcome Message
            </a>

            <a href="{{ route('admin.settings.contact') }}">
                <i class="bi bi-telephone"></i> Contact Information
            </a>
            
            <a href="{{ route('admin.settings.seo') }}">
                <i class="bi bi-search"></i> SEO & Title Website
            </a>
        </div>

    </div>

    <!-- MOBILE MENU BUTTON -->
    <button class="menu-toggle btn btn-light position-fixed top-0 end-0 m-3" onclick="toggleSidebar()" style="z-index: 1000;">
        <i class="bi bi-list fs-3"></i>
    </button>

    <!-- CONTENT -->
    <div class="content">
        @yield('content')
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("show-sidebar");
        }

        /* SUBMENU FUNCTION */
        function toggleSettings() {
            const submenu = document.getElementById("settingsSubmenu");
            const toggle = document.querySelector(".settings-toggle");

            if (submenu.classList.contains("open")) {
                // Closing
                submenu.style.height = submenu.scrollHeight + "px";

                requestAnimationFrame(() => {
                    submenu.style.height = "0";
                    submenu.style.opacity = "0";
                });

                submenu.classList.remove("open");
                toggle.classList.remove("active");

            } else {
                // Opening
                submenu.style.height = submenu.scrollHeight + "px";
                submenu.style.opacity = "1";
                submenu.classList.add("open");
                toggle.classList.add("active");

                submenu.addEventListener("transitionend", () => {
                    submenu.style.height = "auto";
                }, { once: true });
            }
        }

        /* AUTO OPEN IF CURRENTLY IN /admin/settings/... */
        document.addEventListener("DOMContentLoaded", function () {
            const submenu = document.getElementById("settingsSubmenu");
            const toggle = document.querySelector(".settings-toggle");

            if (window.location.pathname.includes("/admin/settings/")) {
                submenu.classList.add("open");
                submenu.style.height = "auto";
                submenu.style.opacity = "1";
                toggle.classList.add("active");
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
