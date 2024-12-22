<?php

namespace App\Providers;

use Carbon\Carbon;
use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');

        Filament::serving(function () {
            Filament::registerNavigationGroups([
                'User',
                'Files'
            ]);
        });
    }
}
