<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin - UMKM')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Summernote CSS (Lokal) -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { 
            background: #f4f6f9; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            min-height: 100vh;
            padding: 20px 0;
            position: fixed;
            color: white;
            transition: transform .3s ease;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar h4 {
            padding: 0 25px;
            font-weight: 600;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 25px;
            color: #cbd5e1;
            text-decoration: none;
            font-size: 15px;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            border-left: 3px solid #60a5fa;
        }

        .sidebar a i {
            width: 20px;
            text-align: center;
        }

        .content {
            margin-left: 240px;
            padding: 25px;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
        }

        /* MOBILE RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar { 
                transform: translateX(-100%); 
                z-index: 1050;
            }
            .sidebar.show-sidebar { 
                transform: translateX(0); 
                box-shadow: 5px 0 15px rgba(0, 0, 0, 0.2);
            }
            .content { 
                margin-left: 0; 
                padding-top: 70px; 
            }
            .menu-toggle { 
                display: block !important; 
            }
        }

        .menu-toggle { 
            display: none; 
            z-index: 1060;
        }

        /* SUBMENU SETTINGS */
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
            color: #94a3b8;
        }

        .settings-toggle.active .settings-arrow {
            transform: rotate(180deg);
            color: #60a5fa;
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

        .settings-submenu a {
            padding-left: 35px;
            font-size: 14px;
            color: #94a3b8;
        }

        .settings-submenu a:hover {
            color: #ffffff;
        }

        /* STYLE SUMMERNOTE */
        .note-editor.note-frame {
            border: 1px solid #dee2e6 !important;
            border-radius: 0.375rem !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05) !important;
        }

        .note-toolbar {
            background-color: #f8f9fa !important;
            border-bottom: 1px solid #dee2e6 !important;
            padding: 0.5rem !important;
            border-radius: 0.375rem 0.375rem 0 0 !important;
        }

        .note-btn-group {
            margin-right: 5px !important;
        }

        .note-editable {
            min-height: 250px !important;
            padding: 1rem !important;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        }

        .note-placeholder {
            color: #6c757d !important;
        }
    </style>

    @yield('styles')
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <h4 class="mb-4">
            Admin UMKM
        </h4>

        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="bi bi-bag-check"></i> Produk
        </a>

        <a href="{{ route('admin.social.index') }}" class="{{ request()->routeIs('admin.social.*') ? 'active' : '' }}">
            <i class="bi bi-share"></i> Sosial Media
        </a>

        <!-- PENGATURAN -->
        <a href="javascript:void(0)" class="settings-toggle {{ request()->is('admin/settings*') ? 'active' : '' }}" onclick="toggleSettings()">
            <span><i class="bi bi-gear"></i> Pengaturan Umum</span>
            <span class="settings-arrow"><i class="bi bi-chevron-down"></i></span>
        </a>

        <div class="settings-submenu {{ request()->is('admin/settings*') ? 'open' : '' }}" id="settingsSubmenu">
            <a href="{{ route('admin.settings.location') }}" class="{{ request()->routeIs('admin.settings.location') ? 'active' : '' }}">
                <i class="bi bi-geo-alt"></i> Lokasi & Jam
            </a>

            <a href="{{ route('admin.settings.logo') }}" class="{{ request()->routeIs('admin.settings.logo') ? 'active' : '' }}">
                <i class="bi bi-image"></i> Logo & Favicon
            </a>

            <a href="{{ route('admin.settings.welcome') }}" class="{{ request()->routeIs('admin.settings.welcome') ? 'active' : '' }}">
                <i class="bi bi-hand-thumbs-up"></i> Welcome Message
            </a>

            <a href="{{ route('admin.settings.contact') }}" class="{{ request()->routeIs('admin.settings.contact') ? 'active' : '' }}">
                <i class="bi bi-telephone"></i> Kontak
            </a>
            
            <a href="{{ route('admin.settings.seo') }}" class="{{ request()->routeIs('admin.settings.seo') ? 'active' : '' }}">
                <i class="bi bi-search"></i> SEO & Title
            </a>
        </div>
    </div>

    <!-- MOBILE MENU BUTTON -->
    <button class="menu-toggle btn btn-light position-fixed top-0 end-0 m-3 shadow" onclick="toggleSidebar()" style="z-index: 1000;">
        <i class="bi bi-list fs-3"></i>
    </button>

    <!-- OVERLAY UNTUK MOBILE -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- CONTENT -->
    <div class="content">
        @yield('content')
    </div>

    <!-- jQuery (WAJIB untuk Summernote) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Summernote JS (Lokal) -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/lang/summernote-id-ID.min.js"></script>

    <script>
        // Toggle Sidebar untuk Mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.toggle('show-sidebar');
            
            if (sidebar.classList.contains('show-sidebar')) {
                overlay.style.display = 'block';
                setTimeout(() => overlay.style.opacity = '1', 10);
            } else {
                overlay.style.opacity = '0';
                setTimeout(() => overlay.style.display = 'none', 300);
            }
        }

        // Close sidebar saat klik overlay
        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.remove('show-sidebar');
            overlay.style.opacity = '0';
            setTimeout(() => overlay.style.display = 'none', 300);
        }

        // SUBMENU FUNCTION
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

        // AUTO OPEN SUBMENU JIKA DI HALAMAN SETTINGS
        document.addEventListener("DOMContentLoaded", function () {
            const submenu = document.getElementById("settingsSubmenu");
            const toggle = document.querySelector(".settings-toggle");

            if (window.location.pathname.includes("/admin/settings/")) {
                submenu.classList.add("open");
                submenu.style.height = "auto";
                submenu.style.opacity = "1";
                toggle.classList.add("active");
            }

            // Inisialisasi Summernote
            initializeSummernote();
            
            // Set active link di sidebar
            setActiveSidebarLinks();
            
            // Buat overlay untuk mobile
            createOverlay();
        });

        // Fungsi untuk inisialisasi Summernote
        function initializeSummernote() {
            if ($('.summernote').length > 0) {
                $('.summernote').summernote({
                    height: 300,
                    lang: 'id-ID',
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ],
                    placeholder: 'Tulis konten di sini...',
                    callbacks: {
                        onImageUpload: function(files) {
                            uploadSummernoteImage(files[0]);
                        }
                    }
                });
            }
        }

        // Fungsi untuk upload gambar (opsional)
        function uploadSummernoteImage(file) {
            const formData = new FormData();
            formData.append('image', file);
            
            // Ganti URL dengan route yang sesuai
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch('/admin/upload-editor-image', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Upload gagal');
                }
                return response.json();
            })
            .then(data => {
                if (data.url) {
                    $('.summernote').summernote('insertImage', data.url);
                }
            })
            .catch(error => {
                console.error('Error uploading image:', error);
                alert('Gagal mengupload gambar. Pastikan ukuran file maksimal 2MB.');
            });
        }

        // Set active class pada sidebar links
        function setActiveSidebarLinks() {
            const currentPath = window.location.pathname;
            const links = document.querySelectorAll('.sidebar a');
            
            links.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
        }

        // Buat overlay untuk mobile
        function createOverlay() {
            if (!document.getElementById('sidebarOverlay')) {
                const overlay = document.createElement('div');
                overlay.id = 'sidebarOverlay';
                overlay.className = 'sidebar-overlay';
                overlay.style.cssText = `
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0,0,0,0.5);
                    z-index: 1040;
                    display: none;
                    opacity: 0;
                    transition: opacity 0.3s ease;
                `;
                document.body.appendChild(overlay);
            }
        }

        // Close sidebar saat resize window (jika menjadi desktop)
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                
                if (sidebar) sidebar.classList.remove('show-sidebar');
                if (overlay) {
                    overlay.style.opacity = '0';
                    setTimeout(() => overlay.style.display = 'none', 300);
                }
            }
        });
    </script>

    <!-- Script tambahan dari view -->
    @yield('scripts')
</body>
</html>
