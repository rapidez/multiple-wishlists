<?php

use Illuminate\Support\Facades\Route;

Route::view('wishlists/shared/{token}', 'rapidez-mw::shared')->name('wishlist.shared');
Route::middleware('web')->group(function () {
    Route::view('account/wishlists', 'rapidez-mw::account.listing')->name('wishlist.listing');
    Route::view('account/wishlists/{id}', 'rapidez-mw::account.view')->name('wishlist.show');
});
