<?php

namespace Rapidez\MultipleWishlist;

use App\Policies\WishlistPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Rapidez\MultipleWishlist\Models\RapidezWishlist;

class MultipleWishlistServiceProvider extends ServiceProvider
{
    protected $policies = [
        RapidezWishlist::class => WishlistPolicy::class,
    ];

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
