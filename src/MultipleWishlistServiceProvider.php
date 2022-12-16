<?php

namespace Rapidez\MultipleWishlist;

use Illuminate\Support\ServiceProvider;

class MultipleWishlistServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'rapidez');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/rapidez')
        ], 'views');
    }
}