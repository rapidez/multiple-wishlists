<?php

namespace Rapidez\MultipleWishlist;

use Illuminate\Support\ServiceProvider;

class MultipleWishlistServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->bootRoutes()
             ->bootViews()
             ->bootMigrations()
             ->publish();
    }

    public function bootRoutes(): static
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        return $this;
    }

    public function bootViews(): static
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'rapidez');

        return $this;
    }

    public function bootMigrations(): static
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        return $this;
    }

    public function publish(): static
    {
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/rapidez')
        ], 'views');

        return $this;
    }
}
