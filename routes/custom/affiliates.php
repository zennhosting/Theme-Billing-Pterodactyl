<?php

use Illuminate\Support\Facades\Route;

  // Admin interface
  Route::get('/billing/admin/affiliate', 'Billing\AffiliatesController@admin')->name('admin.billing.affiliates');
  Route::post('/billing/admin/affiliate/edit', 'Billing\AffiliatesController@adminEdit')->name('admin.billing.affiliate.edit');

  // Affiliates Invite Link
  Route::get('/affiliate/{code}', 'Billing\AffiliatesController@Invite')->name('billing.affiliate.invite');
  Route::get('/affiliate/{code}/apply', 'Billing\AffiliatesController@cartApply')->name('billing.affiliate.cart');

  // Billing Account Balance Route -> /billing/balance
  Route::get('/billing/affiliate', 'Billing\AffiliatesController@Affiliates')->name('billing.affiliate');
  Route::get('/billing/affiliate/create', 'Billing\AffiliatesController@CreateAffiliate')->name('billing.affiliate.create');
  Route::get('/billing/affiliate/cashout', 'Billing\AffiliatesController@Cashout')->name('billing.affiliate.cashout');

