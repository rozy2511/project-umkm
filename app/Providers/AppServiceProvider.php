<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Ambil semua setting dengan cara yang benar
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        
        // Default values
        $defaults = [
            'site_title' => 'UMKM Shop',
            'site_description' => '',
            'site_keywords' => '',
            'meta_author' => '',
            'meta_robots' => 'index,follow',
            'logo_type' => 'text',
            'logo_text' => 'UMKM Shop',
            'logo_color' => '#333333',
            'logo_size' => 24,
            'website_logo' => null,
            'website_favicon' => null,
        ];
        
        // Merge dengan database values
        $settings = array_merge($defaults, $settings);
        
        // Prepare logo data
        $logoData = [
            'type' => $settings['logo_type'] ?? 'text',
            'text' => $settings['logo_text'] ?? $settings['site_title'],
            'color' => $settings['logo_color'] ?? '#000000',
            'size' => $settings['logo_size'] ?? 24,
            'image_url' => isset($settings['website_logo']) && $settings['website_logo'] 
                ? asset('storage/' . $settings['website_logo']) 
                : null,
        ];

        // Share ke semua view
        view()->share([
            // SEO
            'siteTitle'        => $settings['site_title'],
            'siteDescription'  => $settings['site_description'],
            'siteKeywords'     => $settings['site_keywords'],
            'metaAuthor'       => $settings['meta_author'],
            'metaRobots'       => $settings['meta_robots'],

            // LOGO (DIPERBAIKI!)
            'logoType'      => $logoData['type'],
            'logoText'      => $logoData['text'],
            'logoColor'     => $logoData['color'],
            'logoSize'      => $logoData['size'],
            'logoImageUrl'  => $logoData['image_url'],
            
            // Tambahkan juga favicon jika perlu
            'faviconUrl'    => isset($settings['website_favicon']) && $settings['website_favicon']
                ? asset('storage/' . $settings['website_favicon'])
                : null,
        ]);
    }
}