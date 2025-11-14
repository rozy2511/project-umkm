<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        return view('website.products.index');
    }

    public function show($slug)
    {
        return view('website.products.show', compact('slug'));
    }
}
