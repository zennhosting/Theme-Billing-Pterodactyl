<?php

namespace Pterodactyl\Http\Controllers\Billing\Gateways;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use Bill;

class BitpaveGateway
{

  public function __construct()
  {
    // This is the constructor and is executed
    // when any of the functions in this file are.
  }

  public function checkout(Request $request)
  {
    $amount = $request->input('amount');
    if(!isset($amount) OR $amount <= 0) {
      return redirect()->back()->withErrors(['You must specify an amount you want to add']);
    }

    $checkout = Http::post('https://bitpave.com/api/checkout/create', [
        'client' => Bill::settings()->getParam('bitpave_client'),
        'client_secret' => Bill::settings()->getParam('bitpave_client_secret'),
        'name' => config('app.name'),
        'wallet' => Bill::settings()->getParam('bitpave_wallet'),
        'price' => $amount,
        'custom_data' => json_encode(['user_id' => Bill::users()->getAuth()->id, 'email' => Auth::user()->email, 'amount' => $amount]),
        'success_url' => config('app.url'),
        'cancel_url' => config('app.url'),
        'callback_url' => route('bitpave.callback')
    ]);

    if($checkout['response'] !== true) {
      return redirect()->back()->withErrors($checkout['description']);
    }
    
    return redirect($checkout['checkout_url']);
  }

  public static function callback(Request $request)
  {
      // Verify that incoming source is legit & verify the transaction status
      if($request->input('signature') == Bill::settings()->getParam('bitpave_client_secret') AND $request->input('status') == 'completed') {
          // If you passed in custom data, you can retrieve it like the example below.
          $data = json_decode($request->input('custom_data'));
          $user = Bill::users()->find($data->user_id);
          $user->editBalance($data->amount, '+');
          Bill::events()->create('client', false, 'balance:bitpave:added', $data->email. ' added amount: '. $data->amount);
      }
  }
  
}
