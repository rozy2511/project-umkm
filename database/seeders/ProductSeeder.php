<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Donat Kentang',
            'slug' => 'donat-kentang',
            'thumbnail' => 'products/donat-kentang.jpg',
            'price' => 2500,
            'description' => 'Donat kentang olahan rumahan dengan tekstur lembut dan rasa manis yang pas.'
        ]);

        Product::create([
            'name' => 'Risol Mayo Pedas',
            'slug' => 'risol-mayo-pedas',
            'thumbnail' => 'products/risol-mayo.jpg',
            'price' => 3000,
            'description' => 'Risol mayo pedas dibuat dari kulit risol premium dengan isian beef slice, telur, dan mayo pedas.'
        ]);

        Product::create([
            'name' => 'Tahu Bakso',
            'slug' => 'tahu-bakso',
            'thumbnail' => 'products/tahu-bakso.jpg',
            'price' => 1500,
            'description' => 'Tahu bakso dengan rasa gurih dan tekstur lembut, cocok untuk camilan atau lauk.'
        ]);
    }
}
