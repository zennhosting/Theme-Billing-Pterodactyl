<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function () {
  Route::any('/portal', 'Billing\PortalController@portal')->name('billing.portal');

  // Game Plans Portal Route -> /portal/{game}/plans
  Route::get('/portal/{game}/plans', 'Billing\PortalController@plans')->name('billing.portal.plans');

  Route::get('/page/{page}', 'Billing\CoreController@getPage')->name('billing.custom.page');
});

Route::group(['middleware' => 'web', 'auth', 'csrf'], function () {
  Route::any('/portal', 'Billing\PortalController@portal')->name('billing.portal');

  // Game Plans Portal Route -> /portal/{game}/plans
  Route::get('/portal/{game}/plans', 'Billing\PortalController@plans')->name('billing.portal.plans');

  Route::get('/page/{page}', 'Billing\CoreController@getPage')->name('billing.custom.page');
});
