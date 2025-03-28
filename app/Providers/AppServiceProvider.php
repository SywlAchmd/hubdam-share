<?php	

namespace App\Providers;

use Carbon\Carbon;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

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
	    Livewire::setScriptRoute(function ($handle) {
            return Route::get('/hubdamshare/livewire/livewire.js', $handle);
        });

	    Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/hubdamshare/livewire/update', $handle);
    	});

        config(['app.locale' => 'id']);
        Carbon::setLocale('id');

        Filament::serving(function () {
            Filament::registerNavigationGroups([
                'Pengguna',
                'Dokumen'
            ]);
        });
    }
}
