<?php

namespace Pterodactyl\Http\Controllers\Billing;

use Pterodactyl\Http\Controllers\Controller;
use Pterodactyl\Models\Billing\PteroAPI\PteroAPI;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Bill;

class MyPlansController extends Controller
{

  protected $mail;

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
    $billding_user = Bill::users()->getAuth();
    $invoices = Bill::invoices()->where('user_id', $billding_user->user_id)->get();
    return view('templates.' . $this->getTemplate() . '.billing.my-plans', ['plans' => Bill::plans()->getArrayKeyData(), 'invoices' => $invoices, 'billding_user' => $billding_user, 'settings' => Bill::settings()->getAll()]);
  }

  public function plan($id)
  {
    $bill_user = Bill::users()->getAuth();
    $invoice = Bill::invoices()->find($id);
    if (!isset($invoice) or $invoice->user_id != $bill_user->user_id) {
      return redirect()->back();
    }
    $servеr = Bill::getInvoiceServer($id);
    $invoice_logs = Bill::logs()->getInvoiceLog($id, $bill_user->user_id);

    if(!isset($servеr->allocation_id)) {
      return redirect()->back()->withErrors('Your server could not be located. It either expired, was cancelled for more than 10 days or manually deleted by an Admin.');
    }

    $allocation = DB::table('allocations')->where('id', $servеr->allocation_id)->first();
    $plans = Bill::plans()->getArrayKeyData();
    
    try {
      $upgrades = Bill::plans()->where('game_id', $plans[$invoice->plan_id]['game_id'])->get();
    } catch (Exception $e) {
      return redirect()->back()->withErrors(Bill::lang()->get('err_plans_in_game'));
    }

    $data = [
      'invoice_logs' => $invoice_logs,
      'invoice' => $invoice,
      'billding_user' => $bill_user,
      'settings' => Bill::settings()->getAll(),
      'server' => $servеr,
      'allocation' => $allocation,
      'plan' => $plans[$invoice->plan_id],
      'upgrades' => $upgrades,
      'game' => Bill::games()->find($plans[$invoice->plan_id]->game_id),
    ];
    return view('templates.' . $this->getTemplate() . '.billing.view-plan', $data);
  }

  public function upgrade($id)
  {
    $invoice = Bill::invoices()->find($id);
    $plan = Bill::plans()->find($invoice->plan_id);
    
    if(!isset($_GET['plan'])) {
      return redirect()->back()->withErrors('Something went wrong, please try again. Missing parameters');
    }

    try {
      $upgrade = Bill::plans()->find($_GET['plan']);
    } catch (Exception $e) {
      return redirect()->back()->withErrors(Bill::lang()->get('err_plans_in_game'));
    }

    if($upgrade->price > $plan->price) {
      $charge = $upgrade->price - $plan->price;
    } 
    elseif($upgrade->price == $plan->price) {
      return redirect()->back()->withErrors('You cannot upgrade/downgrade to a plan with a similar price.');
    }
    else { $charge = NULL; }

    $user = Bill::users()->getAuth();
    if ($user->balance >= $charge) {
      $upgrade = Bill::invoices()->upgradeOrDowngrade($invoice->id, $upgrade->id, $charge);
      if($upgrade) {
        return redirect()->back()->withSuccess('You plan has been upgraded.');
      }
    }
    else {
      return redirect()->back()->withErrors(Bill::lang()->get('err_user_balance'));
    }

  }

  public function orderUpdate($id)
  {
    $invoice = Bill::invoices()->find($id);
    $user = Bill::users()->getAuth();

    if ($invoice->user_id != $user->user_id) {
      return redirect()->back();
    }

    if (!empty($plan = Bill::plans()->find($invoice->plan_id))) {
      if ($user->balance >= $plan->price) {

        $dt = date("Y-m-d");

        $url = request()->getSchemeAndHttpHost();
        $api = Bill::settings()->getParam('api_key');
        $api = new PteroAPI($api, $url);

        if ($invoice->due_date >= $dt) {
          $invoice->due_date = date("Y-m-d", strtotime("{$invoice->due_date} +{$plan->days} day"));
          $api->servers->unsuspend($invoice->server_id);
        } else {
          $invoice->due_date = date("Y-m-d", strtotime("{$dt} +{$plan->days} day"));
          $api->servers->unsuspend($invoice->server_id);
        }
        $user->editBalance($plan->price, '-', $invoice->id);
        $invoice->status = 'Paid';
        $invoice->save();
      } else {
        return redirect()->back()->withErrors(Bill::lang()->get('err_user_balance'));
      }
    } else {
      return redirect()->back()->withErrors(Bill::lang()->get('err_plan_exist'));
    }

    // Send Mail
    $intro = "You are receiving this email as confirmation that your plan has successfully been extended. <br><br> <strong>Details:<br></strong>Plan: $plan->name [#$invoice->id]<br> Price: $plan->price <br> New Invoice Date: $invoice->invoice_date";
    $outro = "We hope that we have informed you enough.";
    $button_name = "Manage Plan";
    $button_url = route('billing.my-plans.plan', ['id' => $invoice->id]);
    Bill::mail()->Plans($intro, $outro, $button_name, $button_url);

    Bill::events()->create('client', Auth::user()->id, 'client:plan:renewal', Auth::user()->username.' just renewed their plan '. $plan->name);
    return redirect()->back()->with('success', 'Your plan was successfully renewed!');
  }

  public function invoiceCancel($id)
  {
    $invoice = Bill::invoices()->find($id);
    $user = Bill::users()->getAuth();

    if ($invoice->user_id != $user->user_id) {
      return redirect()->back();
    }

    if($invoice->status == 'Unpaid')
    {
      return redirect()->back()->with('success', 'You cannot cancel unpaid servers.');
    }

    $invoice->status = 'Cancelled';
    $invoice->save();

    // Send Mail
    $intro = "You are receiving this email as confirmation for the cancellation of your plan. Your plan is currently on a grace period until ".$invoice->due_date.". You can re-activate your plan at any time during this period.";
    $outro = "We are sorry to see you go, feel free to come back in the future. We hope that we have informed you enough.";
    $button_name = "View Plan";
    $button_url = route('billing.portal');
    Bill::mail()->Plans($intro, $outro, $button_name, $button_url);

    Bill::events()->create('client', Auth::user()->id, 'client:plan:cancelled', Auth::user()->username.' just cancelled their plan');
    return redirect()->back()->with('success', 'Your plans was successfully cancelled.');
  }

  public function invoiceActivate($id)
  {
    $invoice = Bill::invoices()->find($id);
    $user = Bill::users()->getAuth();

    if($invoice->status !== 'Cancelled')
    {
      return redirect()->back()->with('success', 'Your plan is already active');
    }

    if ($invoice->user_id != $user->user_id) {
      return redirect()->back();
    }

    $invoice->status = 'Paid';
    $invoice->save();

    return redirect()->back()->with('success', 'Your plan has been re-activated.');

  }

  public function setSubDomain(Request $request)
  {

    $invoice = Bill::invoices()->find($request->input('invoice_id'));
    $plan = Bill::plans()->find($invoice->plan_id);
    if (empty($plan) or $plan->subdomain != 1) {
      return redirect()->back()->withErrors(Bill::lang()->get('plan_error'));
    }
    $sub = Bill::subdomain(null)->getInvoiceSubDomain($invoice->id);
    if (!empty($sub)) {
      Bill::subdomain(null)->remove($sub->id);
    }

    // Check if the domain contains spaces.
    $domain = Bill::subdomain(null)->getAPI($request->input('domain'));
    $server = Bill::getInvoiceServer($invoice->id);
    $allocation = DB::table('allocations')->where('id', $server->allocation_id)->first();

    if (str_contains($request->input('subdomain'), ' ')) {
      return redirect()->back()->withErrors("Subdomain cannot contain spaces, please try again");
    } else {

      if (!empty($domain) and !empty($server) and !empty($allocation)) {
        Bill::subdomain($domain->id)->createSRV($request->input('subdomain'), $allocation->ip, $allocation->port, $invoice->id);
        Bill::events()->create('client', Auth::user()->id, 'client:subdomain:created', Auth::user()->username.' just created a new subdomain for domain '.$request->input('subdomain'));
      }
    }
    return redirect()->back();
  }
}
