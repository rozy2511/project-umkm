<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 
        'price', 
        'description',
        'thumbnail',
        'slug',
        'is_top'
    ];

    public function galleries(): HasMany
    {
        return $this->hasMany(ProductGallery::class)->orderBy('order');
    }
}