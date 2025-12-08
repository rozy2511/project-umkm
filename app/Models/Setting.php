<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value', 'group'];

    /* ============================================
     * GET SETTING (AUTO JSON DECODE)
     * ============================================ */
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        if (!$setting) return $default;

        $value = $setting->value;

        // Auto decode JSON jika JSON
        $decoded = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $decoded;
        }

        return $value;
    }

    /* ============================================
     * SET SETTING (ARRAY -> JSON)
     * ============================================ */
    public static function set($key, $value, $group = 'general')
    {
        // Jika array → encode JSON
        if (is_array($value)) {
            $value = json_encode($value);
        }

        // Delete file jika kosong
        if ($value === '' || $value === null) {
            $oldFile = self::get($key);
            if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                Storage::disk('public')->delete($oldFile);
            }
        }

        // Jika file upload
        if ($value instanceof UploadedFile) {
            $oldFile = self::get($key);
            if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                Storage::disk('public')->delete($oldFile);
            }

            $path = $value->store('settings', 'public');
            $value = $path;
        }

        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );
    }

    /* ============================================
     * LOGO SYSTEM - DIPERBAIKI 100%!
     * ============================================ */

    // GET LOGO TYPE - AMBIL DARI FIELD TERPISAH
    public static function getLogoType()
    {
        $logoType = self::get('logo_type');
        
        // FALLBACK: Cek di website_logo (format lama GPT)
        if (!$logoType) {
            $websiteLogo = self::get('website_logo');
            if (is_array($websiteLogo)) {
                return $websiteLogo['type'] ?? 'text';
            }
        }
        
        return $logoType ?? 'text';
    }

    // GET LOGO TEXT - AMBIL DARI FIELD TERPISAH
    public static function getLogoText()
    {
        $logoText = self::get('logo_text');
        
        // FALLBACK 1: Cek di website_logo (format lama GPT)
        if (!$logoText) {
            $websiteLogo = self::get('website_logo');
            if (is_array($websiteLogo)) {
                $logoText = $websiteLogo['text'] ?? null;
            }
        }
        
        // FALLBACK 2: site_title
        if (!$logoText) {
            $logoText = self::get('site_title');
        }
        
        // FALLBACK 3: config app name
        return $logoText ?? config('app.name', 'UMKM Shop');
    }

    // GET LOGO COLOR - AMBIL DARI FIELD TERPISAH
    public static function getLogoColor()
    {
        $logoColor = self::get('logo_color');
        
        // FALLBACK: Cek di website_logo (format lama GPT)
        if (!$logoColor) {
            $websiteLogo = self::get('website_logo');
            if (is_array($websiteLogo)) {
                $logoColor = $websiteLogo['color'] ?? '#333333';
            }
        }
        
        return $logoColor ?? '#333333';
    }

    // GET LOGO SIZE - AMBIL DARI FIELD TERPISAH
    public static function getLogoSize()
    {
        $logoSize = self::get('logo_size');
        
        // FALLBACK: Cek di website_logo (format lama GPT)
        if (!$logoSize) {
            $websiteLogo = self::get('website_logo');
            if (is_array($websiteLogo)) {
                $logoSize = $websiteLogo['size'] ?? 24;
            }
        }
        
        $size = $logoSize ?? 24;
        return is_numeric($size) ? (int)$size : 24;
    }

    // GET LOGO FONT - AMBIL DARI FIELD TERPISAH
    public static function getLogoFont()
    {
        $logoFont = self::get('logo_font');
        
        // FALLBACK: Cek di website_logo (format lama GPT)
        if (!$logoFont) {
            $websiteLogo = self::get('website_logo');
            if (is_array($websiteLogo)) {
                $logoFont = $websiteLogo['font'] ?? 'Arial, sans-serif';
            }
        }
        
        return $logoFont ?? 'Arial, sans-serif';
    }

    // GET LOGO IMAGE URL - FIXED! (ERROR INI YANG DIPERBAIKI)
    public static function getLogoImageUrl()
    {
        $path = self::get('website_logo');
        
        // FIX: Cek jika $path adalah array (format lama GPT)
        if (is_array($path)) {
            // Jika array, ambil image_url jika ada
            return $path['image_url'] ?? null;
        }
        
        // Jika string dan file exists
        if (is_string($path) && $path && Storage::disk('public')->exists($path)) {
            return asset('storage/' . $path);
        }
        
        return null;
    }

    // GET ALL LOGO DATA - DIPERBAIKI!
    public static function getLogoData()
    {
        return [
            'type' => self::getLogoType(),       // 'text' atau 'image'
            'text' => self::getLogoText(),       // 'Jajan Pasar Tradisional4'
            'color' => self::getLogoColor(),     // '#ffffff'
            'size' => self::getLogoSize(),       // 24
            'font' => self::getLogoFont(),       // 'Arial, sans-serif'
            'image_url' => self::getLogoImageUrl() // null untuk logo text
        ];
    }

    /* ============================================
     * LOGO HTML GENERATOR - DIPERBAIKI!
     * ============================================ */

    // TEXT LOGO HTML
    private static function getTextLogoHtml($attributes = [])
    {
        $text = self::getLogoText();
        $font = self::getLogoFont();
        $color = self::getLogoColor();
        $size = self::getLogoSize();

        $style = "font-family: {$font}; color: {$color}; font-size: {$size}px; font-weight:bold;";

        $attr = '';
        foreach ($attributes as $k => $v) {
            if ($k !== 'style') {
                $attr .= " {$k}=\"{$v}\"";
            }
        }

        $extra = $attributes['style'] ?? '';
        $style .= " {$extra}";

        return "<span style=\"{$style}\"{$attr}>{$text}</span>";
    }

    // ACTIVE LOGO SELECTOR
    public static function getActiveLogoHtml($attributes = [])
    {
        $logoType = self::getLogoType();
        $imageUrl = self::getLogoImageUrl();

        if ($logoType === 'image' && $imageUrl) {
            $attr = '';
            foreach ($attributes as $k => $v) {
                $attr .= " {$k}=\"{$v}\"";
            }

            $altText = self::getLogoText();
            return "<img src=\"{$imageUrl}\" alt=\"{$altText}\"{$attr}>";
        }

        return self::getTextLogoHtml($attributes);
    }

    /* ============================================
     * NAVBAR LOGO - DIPERBAIKI!
     * ============================================ */
    public static function getNavbarLogo()
    {
        return self::getActiveLogoHtml([
            'class' => 'navbar-logo',
            'style' => 'text-decoration:none; display: inline-block;'
        ]);
    }

    /* ============================================
     * GET FILE URL - DIPERBAIKI!
     * ============================================ */
    public static function getFileUrl($key, $default = null)
    {
        $path = self::get($key);
        
        // FIX: Cek jika array
        if (is_array($path)) {
            return null;
        }

        if ($path && Storage::disk('public')->exists($path)) {
            return asset('storage/' . $path);
        }

        return $default ? asset($default) : null;
    }

    /* ============================================
     * FAVICON - DIPERBAIKI!
     * ============================================ */
    public static function getFaviconUrl()
    {
        $favicon = self::get('website_favicon');
        
        // FIX: Cek jika array
        if (is_array($favicon)) {
            return asset('favicon.ico');
        }
        
        if (!$favicon) {
            return asset('favicon.ico');
        }

        $path = storage_path('app/public/' . $favicon);
        if (file_exists($path)) {
            return asset('storage/' . $favicon) . '?v=' . filemtime($path);
        }

        return asset('storage/' . $favicon);
    }

    /* ============================================
     * HELPER METHODS
     * ============================================ */
    public static function formatWaText($text)
    {
        if (!$text) return '';

        $text = preg_replace('/\*(.*?)\*/', '<strong>$1</strong>', $text);
        $text = preg_replace('/_(.*?)_/', '<em>$1</em>', $text);
        $text = preg_replace('/^- (.*)$/m', '• $1', $text);
        return nl2br($text);
    }

    public static function clearLogoCache()
    {
        return '?t=' . time();
    }
}