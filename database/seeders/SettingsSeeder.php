<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        // Lokasi dan Jam Operasional
        Setting::set('company_address', 'Jl. Contoh No. 123, Kota Anda', 'location');
        Setting::set('company_phone', '(021) 12345678', 'location');
        Setting::set('company_email', 'info@umkmanda.com', 'location');
        
        Setting::set('operational_hours', json_encode([
            ['day' => 'Senin - Jumat', 'time' => '08:00 - 17:00'],
            ['day' => 'Sabtu', 'time' => '08:00 - 15:00'],
            ['day' => 'Minggu', 'time' => 'Tutup']
        ]), 'location');
        
        // Maps Embed URL (dari Google Maps)
        Setting::set('google_maps_embed', '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d106.8195613506864!3d-6.194741395493371!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5390917b759%3A0x6b45e67356080477!2sMonumen%20Nasional!5e0!3m2!1sen!2sid!4v1627361119883!5m2!1sen!2sid" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>', 'location');
    }
}