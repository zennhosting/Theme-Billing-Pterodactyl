<?php

namespace Pterodactyl\Http\Controllers\Billing;

use Pterodactyl\Http\Controllers\Controller;
use Pterodactyl\Models\Billing\PayPal;
use Illuminate\Http\Request;

class PayPalController extends Controller
{

  public function listener()
  {

    $paypal = new PayPal;
    $paypal->listener();
    return;
  }

  public function process(Request $request)
  {
    $paypal = new PayPal;
    $paypal->generateForm($request->input('amount'));
  }
}
