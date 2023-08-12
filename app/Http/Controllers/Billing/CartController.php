<?php

namespace Pterodactyl\Http\Controllers\Billing;

use Pterodactyl\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

use Bill;


class CartController extends Controller
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
    if(Bill::settings()->getparam('currency_symbol') == NULL) {
      return redirect(route('admin.billing.gateways'))->withErrors('Please setup your gateways before placing an cart order.');
    }

    $cart = Bill::cart();
    $user_cart = array();
    foreach ($cart->where('user_id', Auth::user()->id)->get() as $value) {
      if (!empty($plan = Bill::plans()->find($value->plan_id))) {
        $user_cart[$value->id] = $plan;
      } else {
        Bill::cart()->find($value->id)->delete();
      }
    }
    $data = array(
      'billding_user' => Bill::users()->getAuth(),
      'settings' => Bill::settings()->getAll(),
      'carts' => $user_cart,
    );
    return view('templates.' . $this->getTemplate() . '.billing.cart', $data);
  }

  public function addToCart(Request $request)
  {
    $plan = Bill::plans()->find($request->input('plan_id'));
    if ($plan->limit > 0) {
      $invoices = Bill::invoices()->where('user_id', Auth::user()->id)->where('plan_id', $plan->id)->get();
      if (count($invoices) >= $plan->limit) {
        return redirect()->back()->withErrors(Bill::lang()->get('err_plan_limit') . $plan->limit);
      }
      $cart = Bill::cart()->where('user_id', Auth::user()->id)->where('plan_id', $plan->id)->get();
      if (count($cart) >= $plan->limit) {
        return redirect()->back()->withErrors(Bill::lang()->get('err_plan_limit') . $plan->limit);
      }
    }

    $cart = Bill::cart();
    $cart->user_id = Auth::user()->id;
    $cart->plan_id = $plan->id;
    $cart->save();
    return redirect()->route('billing.cart')->with('success', Bill::lang()->get('plan_added_cart'));
  }

  public function removeCart(Request $request)
  {
    $cart = Bill::cart()->find($request->input('plan_id'));
    if ($cart->user_id == Auth::user()->id) {
      $cart->delete();
    }
    return redirect()->route('billing.cart');
  }

  public function orderAll()
  {
    $user_id = Auth::user()->id;
    foreach (Bill::cart()->where('user_id', $user_id)->get() as $value) {
      $plan = Bill::plans()->find($value->plan_id);
      if (!empty($plan)) {
        $user = Bill::users()->getAuth();
        if ($user->balance >= $plan->price()['price']) {
          Bill::cart()->where('id', $value->id)->delete();
          $server = Bill::servers()->create($user_id, $plan->id);
          if ($server['status']) {

            $amount = $plan->price()['price'];
            $getAffiliate = Auth::user()->id.'_affiliate';
            if(Cache::has($getAffiliate)) {
              $affiliate = Cache::get($getAffiliate);

              $minus = $amount / 100 * $affiliate['discount'];
              $creator_comission = $amount / 100 * $affiliate['creator_commision'];

              Bill::affiliates()->AddBalance($affiliate['code'], $creator_comission);
              $amount = $amount - $minus;
            }
            $user->editBalance($amount, '-');
          } else {
            return redirect()->back()->withErrors([Bill::lang()->get('err_create_server'), $server['text']]);
          }
        } else {
          return redirect()->back()->withErrors(Bill::lang()->get('err_user_balance'));
        }
      } else {
        return redirect()->back()->withErrors(Bill::lang()->get('err_plan_exist'));
      }
    }

    // Send Mail
    $intro = "This email is a confirmation that we have successfully received your order and processed it. You can log into your account and start using your server(s)! <br><strong>Product:</strong> <br> $plan->name [$plan->description]";
    $outro = "Thank you for putting your trust in us!";
    $button_name = "Game Panel";
    $button_url = route('billing.my-plans');
    Bill::mail()->Plans($intro, $outro, $button_name, $button_url);

    Bill::events()->create('client', Auth::user()->id, 'client:order:new', Auth::user()->username.' just placed a new order');
    return redirect()->back()->with('success', Bill::lang()->get('server_create_success'));
  }
}
