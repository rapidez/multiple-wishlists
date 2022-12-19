<?php

namespace Rapidez\MultipleWishlist;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MultipleWishlistServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Route::middleware('api')->prefix('api')->group(function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        });
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'rapidez');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/rapidez')
        ], 'views');
    }
}