<?php

use Illuminate\Support\Facades\Route;

Route::view('wishlists/shared/{token}', 'rapidez::multiplewishlist.shared');
Route::middleware('web')->group(function () {
    Route::view('account/wishlists', 'rapidez::multiplewishlist.listing');
    Route::view('account/wishlists/{id}', 'rapidez::multiplewishlist.wishlist');
    Route::view('account/wishlists/edit/{id}', 'rapidez::multiplewishlist.wishlist-edit');
});