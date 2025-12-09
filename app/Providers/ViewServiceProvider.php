<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Setting;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share SEO data to all views
        View::composer('*', function ($view) {
            $seoData = [
                'site_title' => Setting::get('site_title', config('app.name', 'UMKM Shop')),
                'site_description' => Setting::get('site_description', 'Toko online UMKM dengan produk lokal berkualitas'),
                'site_keywords' => Setting::get('site_keywords', 'umkm, produk lokal, makanan tradisional'),
                'meta_author' => Setting::get('meta_author', 'Tim UMKM'),
                'meta_robots' => Setting::get('meta_robots', 'index,follow'),
            ];
            
            $view->with($seoData);
        });
        
        // Share favicon URL to all views
        View::composer('*', function ($view) {
            $favicon = Setting::get('website_favicon');
            $faviconUrl = $favicon ? asset('storage/' . $favicon) : null;
            
            $view->with('favicon_url', $faviconUrl);
        });
        
        // Share logo data to all views
        View::composer('*', function ($view) {
            $logoData = Setting::getLogoData();
            $view->with('logo_data', $logoData);
        });
    }
}