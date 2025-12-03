<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SocialMedia;
use Illuminate\Support\Facades\DB;

class SocialMediaSeeder extends Seeder
{
    public function run(): void
    {
        $socialMedias = [
            [
                'name' => 'Facebook',
                'icon' => 'facebook-f',
                'url' => null,
                'is_active' => true,
                'order' => 1
            ],
            [
                'name' => 'Instagram',
                'icon' => 'instagram',
                'url' => null,
                'is_active' => true,
                'order' => 2
            ],
            [
                'name' => 'Twitter',
                'icon' => 'twitter',
                'url' => null,
                'is_active' => true,
                'order' => 3
            ],
            [
                'name' => 'TikTok',
                'icon' => 'tiktok',
                'url' => null,
                'is_active' => true,
                'order' => 4
            ],
            [
                'name' => 'YouTube',
                'icon' => 'youtube',
                'url' => null,
                'is_active' => true,
                'order' => 5
            ],
            [
                'name' => 'LinkedIn',
                'icon' => 'linkedin-in',
                'url' => null,
                'is_active' => true,
                'order' => 6
            ],
        ];

        foreach ($socialMedias as $social) {
            SocialMedia::create($social);
        }
    }
}