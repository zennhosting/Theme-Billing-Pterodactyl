<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['web', 'csrf'])->prefix('/auth')->namespace("Auth")->group(function () {
  Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', 'RegisterController@index')->name('auth.register');
    Route::post('/register/user', 'RegisterController@register')->name('auth.register.url');
  });


  Route::get('/logout', 'LoginController@logout')->name('auth.logout')->middleware('auth');
});
