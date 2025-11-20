<?php
// app/Http\Controllers\Website\ContactController.php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('website.contact.index');
    }

    public function send(Request $request)
    {
        // Langsung return success tanpa processing apapun
        return back()->with('success', 'Pesan terkirim!');
    }
}