<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    /**
     * Lokasi & Jam Operasional
     */
    public function location()
    {
        $address = Setting::get('company_address', 'Jl. Contoh No. 123, Kota Anda');
        $maps_embed = Setting::get('google_maps_embed', '');
        $op_desc = Setting::get('operational_description', '');
        $op_notes = Setting::get('operational_notes', '');

        return view('website.admin.setting.location', compact(
            'address', 'maps_embed', 'op_desc', 'op_notes'
        ));
    }

    public function updateLocation(Request $request)
    {
        $validated = $request->validate([
            'company_address' => 'required|string|max:500',
            'google_maps_embed' => [
                'required',
                'string',
                'min:50',
                function ($attribute, $value, $fail) {
                    if (!str_contains($value, '<iframe') || !str_contains($value, 'src=')) {
                        $fail('Kode Maps harus mengandung tag iframe dengan atribut src.');
                    }
                },
            ],
            'operational_description' => 'required|string|max:1000',
            'operational_notes' => 'nullable|string|max:1000',
        ]);

        Setting::set('company_address', $validated['company_address'], 'location');
        Setting::set('google_maps_embed', trim($validated['google_maps_embed']), 'location');
        Setting::set('operational_description', $validated['operational_description'], 'operational');
        Setting::set('operational_notes', $validated['operational_notes'], 'operational');

        // ✅ SET CACHE TIMESTAMP UNTUK AUTO UPDATE FRONTEND
        Cache::put('frontend_settings_updated', time(), 3600);

        return redirect()->route('admin.settings.location')
            ->with('success', 'Pengaturan lokasi berhasil diperbarui!')
            ->with('frontend_notification', 'location_updated')
            ->with('auto_refresh_frontend', true);
    }

    /**
     * Logo & Favicon Settings - DIPERBAIKI!
     */
    public function logo()
    {
        // Ambil semua settings
        $allSettings = Setting::all()->pluck('value', 'key')->toArray();
        
        // FILTER DAN FORMAT DATA
        $data = [];
        
        foreach ($allSettings as $key => $value) {
            // Decode JSON jika JSON
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $data[$key] = $decoded;
            } else {
                $data[$key] = $value;
            }
        }
        
        // Tambahkan default values
        $defaults = [
            'website_logo' => null,
            'website_favicon' => null,
            'logo_type' => 'text',
            'logo_text' => Setting::get('site_title', config('app.name', 'UMKM Shop')),
            'logo_font' => 'Arial, sans-serif',
            'logo_color' => '#000000',
            'logo_size' => 24,
            'site_title' => config('app.name', 'UMKM Shop'),
        ];
        
        $data = array_merge($defaults, $data);
        
        // Pastikan website_logo bukan array untuk view
        if (is_array($data['website_logo'])) {
            $data['website_logo'] = null;
        }
        
        // Pastikan website_favicon bukan array untuk view
        if (is_array($data['website_favicon'])) {
            $data['website_favicon'] = null;
        }
        
        return view('website.admin.setting.logo', compact('data'));
    }

    public function updateLogo(Request $request)
    {
        $validated = $request->validate([
            'website_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'website_favicon' => 'nullable|mimes:ico,png,jpg,gif,svg|max:1024',
            
            // Logo options validation
            'logo_type' => 'required|in:image,text',
            'logo_text' => 'nullable|string|max:50',
            'logo_color' => 'nullable|string|max:7',
            'logo_font' => 'nullable|string|max:100',
            'logo_size' => 'nullable|integer|min:12|max:72',
        ]);

        $updated = [];
        $frontendNotifications = [];

        // === LOGO GAMBAR ===
        if ($request->hasFile('website_logo')) {
            Setting::set('website_logo', $request->file('website_logo'), 'appearance');
            $updated[] = 'Logo Gambar';
            $frontendNotifications[] = 'logo_image_updated';
        }

        // === FAVICON ===
        if ($request->hasFile('website_favicon')) {
            Setting::set('website_favicon', $request->file('website_favicon'), 'appearance');
            $updated[] = 'Favicon';
            $frontendNotifications[] = 'favicon_updated';
            
            // Force favicon to be .ico format
            $file = $request->file('website_favicon');
            if (!in_array($file->getClientOriginalExtension(), ['ico', 'ICO'])) {
                session()->flash('favicon_warning', 'Format favicon sebaiknya .ICO untuk tampilan optimal di semua browser.');
            }
        }

        // === LOGO OPTIONS ===
        // Logo type
        $oldLogoType = Setting::get('logo_type', 'text');
        $newLogoType = $validated['logo_type'];
        
        Setting::set('logo_type', $newLogoType, 'appearance');
        $updated[] = 'Tipe Logo';
        $frontendNotifications[] = 'logo_type_updated';
        
        // Jika berpindah dari image ke text, beri warning
        if ($oldLogoType === 'image' && $newLogoType === 'text') {
            session()->flash('logo_type_change', 'Anda mengubah logo dari gambar ke teks.');
        }

        // Logo text
        if ($request->filled('logo_text')) {
            Setting::set('logo_text', $request->logo_text, 'appearance');
            $updated[] = 'Teks Logo';
            $frontendNotifications[] = 'logo_text_updated';
        }

        // Logo font
        if ($request->filled('logo_font')) {
            Setting::set('logo_font', $request->logo_font, 'appearance');
            $updated[] = 'Font Logo';
        }

        // Logo color
        if ($request->filled('logo_color')) {
            Setting::set('logo_color', $request->logo_color, 'appearance');
            $updated[] = 'Warna Logo';
        }

        // Logo size
        if ($request->filled('logo_size')) {
            Setting::set('logo_size', $request->logo_size, 'appearance');
            $updated[] = 'Ukuran Logo';
        }

        // === DELETE REQUESTS ===
        if ($request->has('delete_website_logo')) {
            // Hapus file fisik jika ada
            $currentLogo = Setting::get('website_logo');
            if ($currentLogo && Storage::disk('public')->exists($currentLogo)) {
                Storage::disk('public')->delete($currentLogo);
            }
            
            Setting::set('website_logo', null, 'appearance');
            $updated[] = 'Logo Gambar dihapus';
            $frontendNotifications[] = 'logo_image_deleted';
            
            // Jika logo type masih image, ubah ke text
            if (Setting::get('logo_type') === 'image') {
                Setting::set('logo_type', 'text', 'appearance');
                $updated[] = 'Tipe Logo diubah ke teks (karena gambar dihapus)';
            }
        }

        if ($request->has('delete_website_favicon')) {
            // Hapus file fisik jika ada
            $currentFavicon = Setting::get('website_favicon');
            if ($currentFavicon && Storage::disk('public')->exists($currentFavicon)) {
                Storage::disk('public')->delete($currentFavicon);
            }
            
            Setting::set('website_favicon', null, 'appearance');
            $updated[] = 'Favicon dihapus';
            $frontendNotifications[] = 'favicon_deleted';
        }

        // === SAVE SESSION FOR FRONTEND ===
        if (count($updated) > 0) {
            $message = implode(', ', $updated) . ' berhasil diperbarui!';
            
            // Hapus data array lama di website_logo jika ada
            $oldWebsiteLogo = Setting::where('key', 'website_logo')->first();
            if ($oldWebsiteLogo) {
                $value = $oldWebsiteLogo->value;
                $decoded = json_decode($value, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    // Ini adalah array lama, hapus
                    Setting::where('key', 'website_logo')->delete();
                }
            }
            
            // Save notifications for frontend
            session()->flash('frontend_notifications', $frontendNotifications);
            
            // Save timestamp for cache busting
            session()->flash('assets_timestamp', time());
            
            // Force frontend refresh
            session()->flash('force_refresh', true);
            
            // ✅ SET CACHE TIMESTAMP UNTUK AUTO UPDATE FRONTEND
            Cache::put('frontend_settings_updated', time(), 3600);
            
            // Clear cache
            \Artisan::call('cache:clear');
            \Artisan::call('config:clear');
            \Artisan::call('view:clear');
            
            return redirect()->route('admin.settings.logo')
                ->with('success', $message)
                ->with('logo_updated', true)
                ->with('auto_refresh_frontend', true);
        }

        return redirect()->route('admin.settings.logo')
            ->with('info', 'Tidak ada perubahan yang dilakukan.');
    }

    /**
     * Welcome Message Settings - UPDATED!
     */
    public function welcome()
    {
        $data = [
            'welcome_title' => Setting::get('welcome_title', 'Selamat Datang di UMKM Kami'),
            'welcome_subtitle' => Setting::get('welcome_subtitle', 'Produk berkualitas dari tangan lokal'),
            'welcome_image' => Setting::get('welcome_image'),
        ];
        
        return view('website.admin.setting.welcome', compact('data'));
    }

    public function updateWelcome(Request $request)
    {
        $validated = $request->validate([
            'welcome_title' => 'required|string|max:100',
            'welcome_subtitle' => 'required|string|max:200',
            'welcome_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        
        // Update text fields
        Setting::set('welcome_title', $validated['welcome_title'], 'content');
        Setting::set('welcome_subtitle', $validated['welcome_subtitle'], 'content');
        
        // Handle image upload
        if ($request->hasFile('welcome_image')) {
            Setting::set('welcome_image', $request->file('welcome_image'), 'content');
        }
        
        // Delete image if requested
        if ($request->has('delete_welcome_image')) {
            $currentImage = Setting::get('welcome_image');
            if ($currentImage && Storage::disk('public')->exists($currentImage)) {
                Storage::disk('public')->delete($currentImage);
            }
            Setting::set('welcome_image', null, 'content');
        }
        
        // ✅ SET CACHE TIMESTAMP UNTUK AUTO UPDATE FRONTEND
        Cache::put('frontend_settings_updated', time(), 3600);
        
        return redirect()->route('admin.settings.welcome')
            ->with('success', 'Welcome message berhasil diperbarui!')
            ->with('frontend_notification', 'welcome_updated')
            ->with('auto_refresh_frontend', true);
    }

    /**
     * Contact Settings
     */
    public function contact()
    {
        $data = [
            'contact_phone_admin' => Setting::get('contact_phone_admin', '+62 812-3456-7890'),
            'contact_whatsapp_admin' => Setting::get('contact_whatsapp_admin', '+62 812-3456-7890'),
            'contact_whatsapp_message' => Setting::get('contact_whatsapp_message', 'Halo ada yang bisa dibantu?'),
            'contact_email_admin' => Setting::get('company_email', 'info@umkmanda.com'),
            'contact_address' => Setting::get('company_address', 'Jl. Prof. DR. Soepomo Sh No.29, Muja Muju'),
        ];
        
        return view('website.admin.setting.contact', compact('data'));
    }

    public function updateContact(Request $request)
    {
        $validated = $request->validate([
            'contact_phone_admin' => 'required|string|max:20',
            'contact_whatsapp_admin' => 'required|string|max:20',
            'contact_whatsapp_message' => 'required|string|max:200',
            'contact_email_admin' => 'required|email|max:100',
            'contact_address' => 'required|string|max:500',
        ]);
        
        // Update contact data
        Setting::set('contact_phone_admin', $validated['contact_phone_admin'], 'contact');
        Setting::set('contact_whatsapp_admin', $validated['contact_whatsapp_admin'], 'contact');
        Setting::set('contact_whatsapp_message', $validated['contact_whatsapp_message'], 'contact');
        Setting::set('company_email', $validated['contact_email_admin'], 'location'); // Update existing company_email
        Setting::set('company_address', $validated['contact_address'], 'location'); // Update existing company_address
        
        // ✅ SET CACHE TIMESTAMP UNTUK AUTO UPDATE FRONTEND
        Cache::put('frontend_settings_updated', time(), 3600);
        
        return redirect()->route('admin.settings.contact')
            ->with('success', 'Pengaturan kontak berhasil diperbarui!')
            ->with('frontend_notification', 'contact_updated')
            ->with('auto_refresh_frontend', true);
    }

    /**
     * SEO Settings
     */
    public function seo()
    {
        $data = [
            'site_title' => Setting::get('site_title', config('app.name')),
            'site_description' => Setting::get('site_description', ''),
            'site_keywords' => Setting::get('site_keywords', ''),
            'meta_author' => Setting::get('meta_author', ''),
            'meta_robots' => Setting::get('meta_robots', 'index,follow'),
        ];

        return view('website.admin.setting.seo', compact('data'));
    }

    /**
     * Update SEO Settings - FINAL VERSION WITH FIXED VALIDATION
     */
    public function updateSeo(Request $request)
    {
        // === VALIDATION TANPA META_ROBOTS ===
        $validated = $request->validate([
            'site_title' => 'required|string|max:70',
            'site_description' => 'required|string|max:160',
            'site_keywords' => 'required|string|max:255',
            'meta_author' => 'required|string|max:100',
        ]);
        
        // Ambil meta_robots dari request, default ke index,follow
        $metaRobots = $request->input('meta_robots', 'index,follow');
        
        // === SAVE DATA ===
        Setting::set('site_title', $validated['site_title'], 'seo');
        Setting::set('site_description', $validated['site_description'], 'seo');
        Setting::set('site_keywords', $validated['site_keywords'], 'seo');
        Setting::set('meta_author', $validated['meta_author'], 'seo');
        Setting::set('meta_robots', $metaRobots, 'seo');
        
        // === CACHE ===
        Cache::put('frontend_settings_updated', time(), 3600);
        
        return redirect()->route('admin.settings.seo')
            ->with('success', 'Pengaturan SEO berhasil diperbarui!')
            ->with('frontend_notification', 'seo_updated')
            ->with('auto_refresh_frontend', true);
    }
    
    /**
     * Clear all frontend notifications
     */
    public function clearFrontendNotifications()
    {
        session()->forget([
            'frontend_notifications', 
            'frontend_notification', 
            'assets_timestamp',
            'force_refresh',
            'logo_updated',
            'favicon_warning',
            'logo_type_change',
            'auto_refresh_frontend'
        ]);
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Get current logo for AJAX request (for frontend auto-refresh)
     */
    public function getCurrentLogo()
    {
        $logoData = Setting::getLogoData();
        $faviconUrl = Setting::getFaviconUrl();
        
        return response()->json([
            'success' => true,
            'logo_html' => Setting::getActiveLogoHtml(['class' => 'navbar-logo']),
            'logo_type' => $logoData['type'],
            'logo_text' => $logoData['text'],
            'logo_image_url' => $logoData['image_url'],
            'favicon_url' => $faviconUrl,
            'timestamp' => time(),
        ]);
    }
    
    /**
     * Clean up old format data (optional)
     */
    public function cleanupOldData()
    {
        // Hapus data website_logo yang masih array/JSON
        $oldRecords = Setting::where('key', 'website_logo')
            ->where('value', 'LIKE', '{%')
            ->get();
            
        foreach ($oldRecords as $record) {
            $record->delete();
        }
        
        return response()->json([
            'success' => true,
            'deleted' => $oldRecords->count(),
            'message' => 'Data format lama berhasil dibersihkan.'
        ]);
    }
}