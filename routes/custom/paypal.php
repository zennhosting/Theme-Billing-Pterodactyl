<?php

use Illuminate\Support\Facades\Route;



Route::prefix('/paypal')->namespace("Billing")->group(function () {

  Route::group(['middleware' => 'guest'], function () {
    Route::any('/listener', 'PayPalController@listener')->name('paypal.listener')->withoutMiddleware(['web', 'auth', 'csrf']);
  });


  Route::group(['middleware' => 'auth'], function () {
    Route::post('/process', 'PayPalController@process')->name('paypal.process')->withoutMiddleware(['csrf']);
  });
});
