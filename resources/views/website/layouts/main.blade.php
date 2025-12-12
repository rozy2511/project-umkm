<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- ====== DYNAMIC SETTINGS (dari lokal, tetap dipertahankan) ====== --}}
    @php
        use App\Models\Setting;

        $favicon = Setting::get('website_favicon');
        $logo = Setting::get('website_logo');
        $siteTitle = Setting::get('site_title', 'UMKM Shop');
        $siteDescription = Setting::get('site_description', 'Website UMKM Terpercaya');
        $siteKeywords = Setting::get('site_keywords', 'umkm, toko online, produk lokal');
        $metaAuthor = Setting::get('meta_author', '');
        $metaRobots = Setting::get('meta_robots', 'index,follow');

        $frontendNotifications = session('frontend_notifications', []);
        $frontendNotification = session('frontend_notification', '');
    @endphp

    {{-- ====== FAVICON (lokal punya, tetap dipertahankan) ====== --}}
    @if($favicon)
        @php
            $faviconPath = storage_path('app/public/' . $favicon);
            $faviconTimestamp = file_exists($faviconPath) ? filemtime($faviconPath) : time();
        @endphp
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $favicon) }}?v={{ $faviconTimestamp }}">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}">
    @endif

    {{-- ====== TITLE (lokal punya) ====== --}}
    <title>
        @hasSection('title')
            @yield('title') | {{ $siteTitle }}
        @else
            {{ $siteTitle }}
        @endif
    </title>

    {{-- ====== META SEO (lokal punya) ====== --}}
    <meta name="description" content="{{ $siteDescription }}">
    <meta name="keywords" content="{{ $siteKeywords }}">
    @if($metaAuthor)
        <meta name="author" content="{{ $metaAuthor }}">
    @endif
    <meta name="robots" content="{{ $metaRobots }}">

    <link rel="stylesheet" href="{{ asset('build/assets/app-CIUZgm2i.css') }}">

    <script type="module" src="{{ asset('build/assets/app-CbrbhIeo.js') }}" defer></script>

    {{-- Extra styles (dari lokal) --}}
    @stack('styles')

</head>


<body>

    {{-- Navbar tetap sama --}}
    @include('website.layouts.navbar')

    <main>
        @yield('content')
    </main>

    {{-- Footer tetap sama --}}
    @include('website.layouts.footer')


    {{-- ====== JS TAMBAHAN LOKAL (SweetAlert, jQuery, Bootstrap) ====== --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')

    {{-- ====== SCRIPT NOTIFIKASI (lokal, tidak diubah) ====== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notifications = @json($frontendNotifications);
            const notification = @json($frontendNotification);

            if (notifications.length > 0 || notification) {
                showFrontendNotifications(notifications, notification);
            }
        });

        function showFrontendNotifications(notifications, singleNotification) {
            const allNotifications = [...notifications];
            if (singleNotification) allNotifications.push(singleNotification);

            allNotifications.forEach(notif => {
                switch(notif) {
                    case 'favicon_updated':
                        Swal.fire({
                            icon: 'success',
                            title: 'Favicon Diperbarui!',
                            toast: true,
                            position: 'top-end',
                            timer: 4000,
                            showConfirmButton: false,
                        });
                        break;
                }
            });
        }
    </script>

</body>
</html>
