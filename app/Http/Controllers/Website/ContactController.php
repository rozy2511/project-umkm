<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('website.products.contact');
    }

    public function send(Request $request)
    {
        // nanti implementasi kirim email atau redirect ke WA
        return back()->with('success', 'Pesan terkirim (demo).');
    }
}
