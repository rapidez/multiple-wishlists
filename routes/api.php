<?php

use Illuminate\Http\Request;
use Rapidez\MultipleWishlist\Middleware\AuthMagento;
use Illuminate\Support\Facades\Route;

Route::middleware([AuthMagento::class])->group(function () {
    Route::post('test', function (Request $request) {
        return $request->userId;
    });
});
