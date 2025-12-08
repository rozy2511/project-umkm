<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SocialMedia;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class LandingpageController extends Controller
{
    public function index()
    {
        $lastSettingsUpdate = Cache::get('frontend_settings_updated', 0);
        $userLastVisit = session('frontend_last_visit', 0);
        
        $needsAutoRefresh = $lastSettingsUpdate > $userLastVisit;
        session(['frontend_last_visit' => time()]);
        
        $logoType = Setting::get('logo_type', 'text');
        $logoText = Setting::get('logo_text', 'Jajan Pasar Tradisional');
        $logoColor = Setting::get('logo_color', '#000000');
        $logoSize = Setting::get('logo_size', 24);
        $logoImage = Setting::get('website_logo');
        $favicon = Setting::get('website_favicon');
        
        $logoImageUrl = null;
        if (is_array($logoImage)) {
            $logoImage = $logoImage['path'] ?? $logoImage['file'] ?? null;
        }
        if (is_string($logoImage) && Storage::disk('public')->exists($logoImage)) {
            $logoImageUrl = asset('storage/' . $logoImage);
        }
        
        $socialMedias = SocialMedia::where('is_active', true)
            ->whereNotNull('url')
            ->orderBy('order')
            ->get();
        
        $siteTitle = Setting::get('site_title', config('app.name'));
        $siteDescription = Setting::get('site_description', '');
        $companyAddress = Setting::get('company_address', '');
        $mapsEmbed = Setting::get('google_maps_embed', '');
        $operationalDesc = Setting::get('operational_description', '');
        $operationalNotes = Setting::get('operational_notes', '');
        $welcomeTitle = Setting::get('welcome_title', 'Selamat Datang di UMKM Kami');
        $welcomeSubtitle = Setting::get('welcome_subtitle', 'Produk berkualitas dari tangan lokal');
        $welcomeImage = Setting::get('welcome_image');
        
        return view('website.index', [
            'logoType' => $logoType,
            'logoText' => $logoText,
            'logoColor' => $logoColor,
            'logoSize' => $logoSize,
            'logoImage' => $logoImage,
            'logoImageUrl' => $logoImageUrl,
            'favicon' => $favicon,
            
            'socialMedias' => $socialMedias,
            
            'siteTitle' => $siteTitle,
            'siteDescription' => $siteDescription,
            'companyAddress' => $companyAddress,
            'mapsEmbed' => $mapsEmbed,
            'operationalDesc' => $operationalDesc,
            'operationalNotes' => $operationalNotes,
            
            'welcomeTitle' => $welcomeTitle,
            'welcomeSubtitle' => $welcomeSubtitle,
            'welcomeImage' => $welcomeImage,
            
            'needsAutoRefresh' => $needsAutoRefresh,
            'lastUpdateTime' => $lastSettingsUpdate,
        ]);
    }
}