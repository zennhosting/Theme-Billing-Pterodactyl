<?php

namespace Pterodactyl\Http\Controllers\Billing;

use Pterodactyl\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Charge;

use Bill;

class ProfileController extends Controller
{

  public function __construct(Request $request)
  {
    $this->request = $request;
    Bill::settings()->scheduler();
  }

  private function getTemplate()
  {
    return $this->request->template;
  }

  public function index()
  {
    return view('templates.' . $this->getTemplate() . '.billing.balance', ['billding_user' => Bill::users()->getAuth(), 'settings' => Bill::settings()->getAll()]);
  }

  public function updateUser(Request $request)
  {
    $validated = $request->validate([
      'address' => 'required',
      'city' => 'required',
      'country' => 'required',
      'postal_code' => 'required',
    ]);

    $billding_user = Bill::users();
    $billding_user = $billding_user->getAuth();
    $billding_user->address = $request->input('address');
    $billding_user->city = $request->input('city');
    $billding_user->country = $request->input('country');
    $billding_user->postal_code = $request->input('postal_code');
    $billding_user->save();
    
    return redirect()->back();
  }

  public function giftCard(Request $request)
  {
    $validated = $request->validate([
      'code' => 'required',
    ]);

    $user_id = Auth::user()->id;
    $code = $request->input('code');
    $index_code = $code . $user_id;

    $giftcard = DB::table('billing_giftcards')->where('code', $code)->first();
    if (empty($giftcard) or $giftcard->limit <= 0) {
      return redirect()->back()->withErrors(Bill::lang()->get('gift_card_not_exist'));
    }

    $user_log = Bill::logs()->where('user_id', $user_id)->where('type', 'giftdard')->where('txn_id', $index_code)->first();
    if (!empty($user_log)) {
      return redirect()->back()->withErrors(Bill::lang()->get('gift_card_used_error'));
    }

    // Success
    $data = array(
      'code' => $index_code,
      'money' => $giftcard->value,
      'name' => $giftcard->name,
      'id' => $giftcard->id,
    );

    $log = Bill::logs();
    $log->user_id = $user_id;
    $log->type = 'giftdard';
    $log->txn_id = $index_code;
    $log->status = 'VERIFIED';
    $log->data = json_encode($data);
    $log->save();

    DB::table('billing_giftcards')->where('id', $giftcard->id)->update(array(
      'limit' => $giftcard->limit - 1,
    ));

    $this->updateBalance($user_id, $giftcard->value, '+');
    Bill::events()->create('client', Auth::user()->id, 'client:giftcard:used', Auth::user()->username.' just used a giftcard '.$giftcard->name);
    return redirect()->back()->with('success', Bill::lang()->get('gift_card_used_success'));
  }

  public function stripe(Request $request)
  {
    $billding_settings = Bill::settings()->getAll();
    $publishable_key     = $billding_settings['publishable_key'];
    $secret_key            = $billding_settings['secret_key'];

    if (isset($_POST['stripeToken'])) {
      Stripe::setApiKey($secret_key);
      $description     = "Invoice #" . Auth::user()->id . "#" . rand(99999, 999999999);
      $amount_cents     = $_POST['amount'] * 100;
      $tokenid        = $_POST['stripeToken'];
      try {
        $charge = Charge::create(
          array(
            "amount" => $amount_cents,
            "currency" => $billding_settings['paypal_currency'],
            "source" => $tokenid,
            "description" => $description
          )
        );

        $id            = $charge['id'];
        $amount     = $charge['amount'];
        $balance_transaction = $charge['balance_transaction'];
        $currency     = $charge['currency'];
        $status     = $charge['status'];
        $date     = date("Y-m-d H:i:s");

        $result = "succeeded";

        $log = Bill::logs();
        $log->user_id = Auth::user()->id;
        $log->type = 'paypal';
        $log->txn_id = $id;
        $log->status = 'VERIFIED/' . $status;
        $log->data = json_encode($_REQUEST);
        $log->save();

        $this->updateBalance(Auth::user()->id, $_POST['amount'], '+');
        /* You can save the above response in DB */

        // Send Mail
        $intro = "We are emailing you to confirm that we have received your payment, your balance has successfully been updated on our website.";
        $outro = "Thank you for putting your trust in us!";
        $button_name = "Game Panel";
        $button_url = route('billing.my-plans');
        Bill::mail()->Plans($intro, $outro, $button_name, $button_url);
        Bill::events()->create('client', Auth::user()->id, 'payment:stripe:received', Auth::user()->username.' just made a payment on stripe of $'.$_POST['amount'].' Receipt: '.$charge['receipt_url']);

        return redirect()->back()->with('success', Bill::lang()->get('stripe_status_url') . $charge['receipt_url']);
      } catch (\Stripe\Exception\CardException $e) {
        $error = $e->getMessage();
        return redirect()->back()->withErrors($error);
      } catch (\Stripe\Exception\RateLimitException $e) {
        $error = $e->getMessage();
        return redirect()->back()->withErrors($error);
      } catch (\Stripe\Exception\InvalidRequestException $e) {
        $error = $e->getMessage();
        return redirect()->back()->withErrors($error);
      } catch (\Stripe\Exception\AuthenticationException $e) {
        $error = $e->getMessage();
        return redirect()->back()->withErrors($error);
      } catch (\Stripe\Exception\ApiConnectionException $e) {
        $error = $e->getMessage();
        return redirect()->back()->withErrors($error);
      } catch (\Stripe\Exception\ApiErrorException $e) {
        $error = $e->getMessage();
        return redirect()->back()->withErrors($error);
      } catch (Exception $e) {
        $error = $e->getMessage();
        return redirect()->back()->withErrors($error);
      }
    }
  }

  public function updateBalance($user_id, $count, $param = '+')
  {
    if ($param == '+') {
      DB::table('billing_users')->where('user_id', $user_id)->increment('balance', $count);
    } elseif ($param == '-') {
      DB::table('billing_users')->where('user_id', $user_id)->decrement('balance', $count);
    }
  }
}
