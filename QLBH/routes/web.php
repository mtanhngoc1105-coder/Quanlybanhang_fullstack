<?php

use Illuminate\Support\Facades\Route;

// SPA Route - Serve Vue app for all non-API routes
Route::get('{any?}', function () {
    return view('spa');
})->where('any', '.*')->name('spa');

