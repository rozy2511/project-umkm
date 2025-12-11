<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display contact page
     */
    public function index()
    {
        // Ambil data kontak dari database
        $contactData = [
            'phone' => Setting::get('contact_phone_admin', '+62 812-3593-8380'),
            'whatsapp' => Setting::get('contact_whatsapp_admin', '+62 812-3593-8380'),
            'whatsapp_message' => Setting::get('contact_whatsapp_message', 'Halo ada yang bisa dibantu?'),
            'email' => Setting::get('company_email', 'info@umkmanda.com'),
            'address' => Setting::get('company_address', 'Jl. Prof. DR. Soepomo Sh No.29, Muja Muju, Kec. Umbulharjo, Kota Yogyakarta 55165'),
        ];
        
        // Debug: Cek data yang didapat
        // dd($contactData);
        
        // Format nomor untuk WhatsApp link
        $whatsapp_number = preg_replace('/[^0-9]/', '', $contactData['whatsapp']);
        $whatsapp_link = "https://wa.me/{$whatsapp_number}?text=" . urlencode($contactData['whatsapp_message']);
        
        // Format nomor untuk tel: link
        $phone_link = "tel:" . preg_replace('/[^0-9+]/', '', $contactData['phone']);
        
        // Debug: Cek link yang dibuat
        // dd($whatsapp_link, $phone_link);
        
        return view('website.contact.index', compact('contactData', 'whatsapp_link', 'phone_link'));
    }
}