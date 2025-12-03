<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // COMMENT OUT SEMUA UNTUK TESTING
        /*
        view()->composer('*', function ($view) {
            $socialMedias = \App\Models\SocialMedia::where('is_active', true)
                ->whereNotNull('url')
                ->orderBy('order')
                ->get();
            
            $view->with('socialMedias', $socialMedias);
        });
        */
    }
}
