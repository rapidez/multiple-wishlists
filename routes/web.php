<?php

use Illuminate\Support\Facades\Route;

Route::view('wishlists/shared/{token}', 'rapidez::multiplewishlist.shared')->name('wishlist.shared');
Route::middleware('web')->group(function () {
    Route::view('account/wishlists', 'rapidez::multiplewishlist.listing')->name('wishlist.listing');
    Route::view('account/wishlists/{id}', 'rapidez::multiplewishlist.wishlist')->name('wishlist.show');
    Route::view('account/wishlists/edit/{id}', 'rapidez::multiplewishlist.wishlist-edit')->name('wishlist.edit');
});
