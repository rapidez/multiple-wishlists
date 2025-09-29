<?php

namespace Rapidez\MultipleWishlist;

use Illuminate\Support\ServiceProvider;

class MultipleWishlistServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerConfig();
    }

    public function boot()
    {
        $this->bootRoutes()
             ->bootViews()
             ->bootMigrations()
             ->publish()
             ->bootTranslations();
    }

    public function registerConfig(): static
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/rapidez/multiple-wishlists.php', 'rapidez.multiple-wishlists');

        return $this;
    }

    public function bootRoutes(): static
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        return $this;
    }

    public function bootViews(): static
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'rapidez-mw');

        return $this;
    }

    public function bootMigrations(): static
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        return $this;
    }

    public function publish(): static
    {
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/rapidez'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/../config/rapidez/multiple-wishlists.php' => config_path('rapidez/multiple-wishlists.php'),
        ], 'config');

        return $this;
    }

    protected function bootTranslations(): self
    {
        $this->loadJsonTranslationsFrom(__DIR__ . '/../lang');

        return $this;
    }
}
