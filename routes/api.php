<?php

use Rapidez\MultipleWishlist\Middleware\AuthMagento;
use Illuminate\Support\Facades\Route;
use Rapidez\MultipleWishlist\Controllers\WishlistController;
use Rapidez\MultipleWishlist\Controllers\WishlistItemController;
use Rapidez\MultipleWishlist\Scopes\CustomerScope;

Route::middleware('api')->prefix('api')->group(function () {
    Route::get('wishlists/shared/{token}', [WishlistController::class, 'shared']);
    Route::get('wishlists/all', [WishlistController::class, 'allWithItems']);
    Route::apiResource('wishlists/item', WishlistItemController::class)->except('show', 'index');
    Route::apiResource('wishlists', WishlistController::class);
});
