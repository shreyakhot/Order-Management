<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\File;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $helperFiles = File::files(app_path('Helpers'));
        foreach ($helperFiles as $helperFile) {
            require_once $helperFile;
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResourceCollection::withoutWrapping();
    }
}
