<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'thumbnail',  // ← ini WAJIB sesuai controller
        'price',
        'description',
    ];
}
