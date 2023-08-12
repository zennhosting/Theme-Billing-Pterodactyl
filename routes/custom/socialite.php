<?php

use Illuminate\Support\Facades\Route;
use Pterodactyl\Http\Controllers\Auth\SocialLoginController;

Route::group(['middleware' => 'guest'], function () {

    Route::get('/auth/login/{driver}', [SocialLoginController::class, 'Driver']);
    Route::get('/auth/login/{driver}/redirect', [SocialLoginController::class, 'DriverCallback']);
    
});

