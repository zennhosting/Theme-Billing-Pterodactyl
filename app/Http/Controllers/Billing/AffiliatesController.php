<?php

namespace Pterodactyl\Http\Controllers\Billing;

use Pterodactyl\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use Bill;

class AffiliatesController extends Controller
{

  public function __construct(Request $request)
  {
    $this->request = $request;
  }

  private function getTemplate()
  {
    return $this->request->template;
  }

  public function admin()
  {
    if(!Bill::allowed('affiliates')) {
      return $this->denied();
    }

    return view('templates.' . $this->getTemplate() . '.billing.admin.affiliate', ['affiliates' => Bill::affiliates()->getAllAffiliates(), 'settings' => Bill::settings()->getAll()]);
  }

  public function adminEdit()
  {
    $affiliate = Bill::affiliates()->EditAffiliate($_POST['id'], $_POST['code'], $_POST['total_earned'],  $_POST['commision'], $_POST['discount']);

    if(!$affiliate) {
      return redirect()->back()->with('error', 'Could not modify!');
    }
    
  return redirect()->back()->with('success', 'Succesfully edited affiliate');
  }

  public function Affiliates()
  {
    if(!Bill::allowed('affiliates')) {
      return $this->denied();
    }
    return view('templates.' . $this->getTemplate() . '.billing.affiliates', ['affiliate' => Bill::affiliates()->getAuth(), 'settings' => Bill::settings()->getAll()]);
  }

  public function CreateAffiliate()
  {
    Bill::affiliates()->issetOrCreateAffiliate();
    return redirect(route('billing.affiliate'))->with('success', 'Successfully created affiliates link.');
  } 

  public function Cashout()
  {
    $user = Bill::affiliates()->getAuth();
    if(isset($user)) {
      if($user['total_earned'] >= config('billing.affiliates.cashout')) {

        if(config('billing.affiliates.webhook') !== NULL) {
          $this->DiscordLog($user['total_earned']);
        }

        Bill::affiliates()->Cashout($user['total_earned']);
        return redirect(route('billing.affiliate'))->with('success', 'The money will be added to your panel balance. If you are a "Partner" you should talk to support to get a payment method sent to you.');

      } else {
        return redirect(route('billing.affiliate'))->withErrors('The minimum cashout amount is '. config('billing.affiliates.cashout'));
      }

    } else {
      return redirect(route('billing.affiliate'))->withErrors('You must activate affiliates program before cashing out.');

    }
  } 

  public function Invite($code)
  {
    $getAffiliate = Bill::affiliates()->getAffiliate($code);
    if($getAffiliate !== NULL) {
      Bill::affiliates()->UpdateClicks($code);
      $this->store($code);

      return redirect('/');

    } else {
      return redirect('/')->withErrors('Affiliate does not exist');
    }
  }

  public function cartApply($code)
  {
    $getAffiliate = Bill::affiliates()->getAffiliate($code);
    if($getAffiliate !== NULL) {
      $this->store($code);
      return redirect(route('billing.cart'));
    } else {
      if($code == "remove") {
        $affiliate = Auth::user()->id.'_affiliate';
        Cache::forget($affiliate);
        return redirect(route('billing.cart'))->with('success', 'Code has been removed');

      } else {
        return redirect(route('billing.cart'))->withErrors('Could not find affiliate code.');

      }
    }
  }

  private function store($code)
  {
    $getAffiliate = Bill::affiliates()->getAffiliate($code);
    if(!Auth::guest()) {
      $getUserAffiliate = Bill::affiliates()->getAuth();
      $affiliate = Auth::user()->id.'_affiliate';
      if($getUserAffiliate !== NULL AND $getUserAffiliate['code'] !== $code) {
        Cache::put($affiliate, $getAffiliate, 604800);
        return redirect(route('billing.cart'))->with('success', 'Successfully applied code: '. $code);
      } else {
        return redirect(route('billing.cart'))->withErrors('You cannot use your own affiliate link for a discount.');
      }
    }
  }

  private function DiscordLog($amount)
  {

      $webkey = config('billing.affiliates.webhook');

      $timestamp = date("c", strtotime("now"));

      $json_data = json_encode([
        // Message
        "content" => "New log:",

        // Embeds Array
        "embeds" => [
          [
            // Embed Title
            "title" => "Cashout Alert",

            // Embed Type
            "type" => "rich",

            // Embed Description
            "description" => "There is a new cashout",

            // URL of title link
            "url" => config('app.url'),

            // Timestamp of embed must be formatted as ISO8601
            "timestamp" => $timestamp,

            // Embed left border color in HEX
            "color" => hexdec("3366ff"),


            // Additional Fields array
            "fields" => [

              // Inline
              [
                "name" => "Username",
                "value" => Auth::user()->username,
                "inline" => true
              ],
              // Inline
              [
                "name" => "Email",
                "value" => Auth::user()->email,
                "inline" => true
              ],
              // Field 2
              [
                "name" => "Cashout Amount:",
                "value" => '$'.$amount,
                "inline" => false
              ],
              // Etc..
            ]
          ]
        ]

      ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);


      $ch = curl_init($webkey);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

      $response = curl_exec($ch);
      // If you need to debug, or find out why you can't send message uncomment line below, and execute script.
      // echo $response;
      curl_close($ch);
    }

  private function denied()
  {
    return redirect()->back()->withError('You have discovered a Premium Feature, to access upgrade your plan. Upgrade here: https://wemx.net/pricing');
  }

}
