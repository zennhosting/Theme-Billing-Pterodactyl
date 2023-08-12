<?php

use Illuminate\Support\Facades\Route;
use Pterodactyl\Http\Controllers\Billing\Gateways\BitpaveGateway;

// set the url for gateway, now the prefix is set to
// example.com/billing/gateway/example
// to add amount, you go to example.com/billing/gateway/example/10/checkout

Route::post('/gateway/bitpave/checkout', [BitpaveGateway::class, 'checkout'])->name('bitpave.checkout');
Route::post('/remote/bitpave/webhook', [BitpaveGateway::class, 'callback'])->name('bitpave.callback');


