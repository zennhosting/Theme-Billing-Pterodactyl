<?php

namespace Pterodactyl\Http\Controllers\Billing\Admin;

use Pterodactyl\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Pterodactyl\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Bill;

class AdminCoreController extends Controller
{

  public $template = 'Carbon';

  // Construct Function
  public function __construct()
  {
    if (!empty(config('billing.theme'))) {
      $this->template = config('billing.theme');
    }
    Bill::upd()->update();
    Bill::settings()->scheduler();

  }

  public function index()
  {
    return view('templates.' . $this->template . '.billing.admin.index', ['settings' => Bill::settings()->getAll()]);
  }

  public function overview()
  {
    $orders = Bill::invoices()->stats();
    return view('templates.' . $this->template . '.billing.admin.overview', ['settings' => Bill::settings()->getAll(), 'orders' => $orders, 'events' => Bill::events()->latest()->paginate(9), 'subscription' => Bill::getSubscriptionDetails(),]);
  }

  public function gateways()
  {
    $currency_list = array(
      'ALL' => 'Albania Lek',
      'AFN' => 'Afghanistan Afghani',
      'ARS' => 'Argentina Peso',
      'AWG' => 'Aruba Guilder',
      'AUD' => 'Australia Dollar',
      'AZN' => 'Azerbaijan New Manat',
      'BSD' => 'Bahamas Dollar',
      'BBD' => 'Barbados Dollar',
      'BDT' => 'Bangladeshi taka',
      'BYR' => 'Belarus Ruble',
      'BZD' => 'Belize Dollar',
      'BMD' => 'Bermuda Dollar',
      'BOB' => 'Bolivia Boliviano',
      'BAM' => 'Bosnia and Herzegovina Convertible Marka',
      'BWP' => 'Botswana Pula',
      'BGN' => 'Bulgaria Lev',
      'BRL' => 'Brazil Real',
      'BND' => 'Brunei Darussalam Dollar',
      'KHR' => 'Cambodia Riel',
      'CAD' => 'Canada Dollar',
      'KYD' => 'Cayman Islands Dollar',
      'CLP' => 'Chile Peso',
      'CNY' => 'China Yuan Renminbi',
      'COP' => 'Colombia Peso',
      'CRC' => 'Costa Rica Colon',
      'HRK' => 'Croatia Kuna',
      'CUP' => 'Cuba Peso',
      'CZK' => 'Czech Republic Koruna',
      'DKK' => 'Denmark Krone',
      'DOP' => 'Dominican Republic Peso',
      'XCD' => 'East Caribbean Dollar',
      'EGP' => 'Egypt Pound',
      'SVC' => 'El Salvador Colon',
      'EEK' => 'Estonia Kroon',
      'EUR' => 'Euro Member Countries',
      'FKP' => 'Falkland Islands (Malvinas) Pound',
      'FJD' => 'Fiji Dollar',
      'GHC' => 'Ghana Cedis',
      'GIP' => 'Gibraltar Pound',
      'GTQ' => 'Guatemala Quetzal',
      'GGP' => 'Guernsey Pound',
      'GYD' => 'Guyana Dollar',
      'HNL' => 'Honduras Lempira',
      'HKD' => 'Hong Kong Dollar',
      'HUF' => 'Hungary Forint',
      'ISK' => 'Iceland Krona',
      'INR' => 'India Rupee',
      'IDR' => 'Indonesia Rupiah',
      'IRR' => 'Iran Rial',
      'IMP' => 'Isle of Man Pound',
      'ILS' => 'Israel Shekel',
      'JMD' => 'Jamaica Dollar',
      'JPY' => 'Japan Yen',
      'JEP' => 'Jersey Pound',
      'KZT' => 'Kazakhstan Tenge',
      'KPW' => 'Korea (North) Won',
      'KRW' => 'Korea (South) Won',
      'KGS' => 'Kyrgyzstan Som',
      'LAK' => 'Laos Kip',
      'LVL' => 'Latvia Lat',
      'LBP' => 'Lebanon Pound',
      'LRD' => 'Liberia Dollar',
      'LTL' => 'Lithuania Litas',
      'MKD' => 'Macedonia Denar',
      'MYR' => 'Malaysia Ringgit',
      'MUR' => 'Mauritius Rupee',
      'MXN' => 'Mexico Peso',
      'MNT' => 'Mongolia Tughrik',
      'MZN' => 'Mozambique Metical',
      'NAD' => 'Namibia Dollar',
      'NPR' => 'Nepal Rupee',
      'ANG' => 'Netherlands Antilles Guilder',
      'NZD' => 'New Zealand Dollar',
      'NIO' => 'Nicaragua Cordoba',
      'NGN' => 'Nigeria Naira',
      'NOK' => 'Norway Krone',
      'OMR' => 'Oman Rial',
      'PKR' => 'Pakistan Rupee',
      'PAB' => 'Panama Balboa',
      'PYG' => 'Paraguay Guarani',
      'PEN' => 'Peru Nuevo Sol',
      'PHP' => 'Philippines Peso',
      'PLN' => 'Poland Zloty',
      'QAR' => 'Qatar Riyal',
      'RON' => 'Romania New Leu',
      'RUB' => 'Russia Ruble',
      'SHP' => 'Saint Helena Pound',
      'SAR' => 'Saudi Arabia Riyal',
      'RSD' => 'Serbia Dinar',
      'SCR' => 'Seychelles Rupee',
      'SGD' => 'Singapore Dollar',
      'SBD' => 'Solomon Islands Dollar',
      'SOS' => 'Somalia Shilling',
      'ZAR' => 'South Africa Rand',
      'LKR' => 'Sri Lanka Rupee',
      'SEK' => 'Sweden Krona',
      'CHF' => 'Switzerland Franc',
      'SRD' => 'Suriname Dollar',
      'SYP' => 'Syria Pound',
      'TWD' => 'Taiwan New Dollar',
      'THB' => 'Thailand Baht',
      'TTD' => 'Trinidad and Tobago Dollar',
      'TRY' => 'Turkey Lira',
      'TRL' => 'Turkey Lira',
      'TVD' => 'Tuvalu Dollar',
      'UAH' => 'Ukraine Hryvna',
      'GBP' => 'United Kingdom Pound',
      'USD' => 'United States Dollar',
      'UYU' => 'Uruguay Peso',
      'UZS' => 'Uzbekistan Som',
      'VEF' => 'Venezuela Bolivar',
      'VND' => 'Viet Nam Dong',
      'YER' => 'Yemen Rial',
      'ZWD' => 'Zimbabwe Dollar'
    );
    return view('templates.' . $this->template . '.billing.admin.gateways', ['settings' => Bill::settings()->getAll(), 'currency_list' => $currency_list]);
  }

  public function setSetting(Request $request)
  {

    foreach ($request->input() as $key => $value) {
      Bill::settings()->updateOrCreate(['name' => $key], ['name' => $key, 'data' => $value]);
    }
    Bill::events()->create('admin', Auth::user()->id, 'admin:settings:save', 'Billing Admin settings were updated.');

    return redirect()->back()->with('success', 'Settings have been saved successfully.');
  }

  public function forceSchedular()
  {
    $schedular = Bill::settings()->forceScheduler();

    if($schedular) {
      return redirect()->back()->with('success', 'Schedular was force-ran successfully.');
    }

  }

  public function impersonate($id)
  {

    $user = User::find($id);

    if($user->root_admin) {
    return redirect()->back()->with('warning', 'You may not impersonate Admin Users due to security!');
    }

    $token = Str::random(30);
    Cache::put('impersonate_token', $token, now()->addMinutes(1));
    Bill::events()->create('admin', Auth::user()->id, 'admin:impersonate:user', Auth::user()->username.' (admin) just started impersonation as #'.$id);
    Auth::logout();

    return redirect(route('billing.impersonate', ['id' => $id, 'token' => $token]));
  }

  public function orders()
  {
    $orders = Bill::invoices()->paginate(9);
    return view('templates.' . $this->template . '.billing.admin.orders', ['orders' => $orders, 'plans' => Bill::plans()->getArrayKeyData()]);
  }

  public function createOrder(Request $request)
  {
    $user = User::where('email',$request->email)->first();
    if(!isset($user)) {
      return redirect()->back()->with('warning', 'Email is not registered to any account.');
    }
    
    $server = Bill::servers()->create($user->id, $request->plan);
    if($server) {
      Bill::events()->create('admin', Auth::user()->id, 'admin:order:created', Auth::user()->username.' (admin) created a new order for '.$request->email);
      return redirect()->back()->with('success', 'Server for user '. $user->username .' was created successfully.');
    } else {
        return redirect()->back()->with('warning', 'There was an error whilst creating your order. Please check the API permissions or Node status');
    }
  }

  public function deleteOrder($id)
  {
    $invoice = Bill::invoices()->find($id);
    if(!isset($invoice)) {
      return redirect()->back()->with('warning', 'The order does not exist or was already deleted');
    }

    Bill::servers()->remove($invoice->server_id);
    $invoice->delete();
    return redirect()->back()->with('warning', 'The order was deleted');
  }

  public function manageOrder($id)
  {

    $invoice = Bill::invoices()->find($id);

    if(!isset($invoice)) {
      return redirect()->back()->with('warning', 'The order you selected cannot be edited due to errors. Missing some data related to order.');
    }

    $bill_user = Bill::users()->find($invoice->user_id);
    $user = Auth::user()->find($invoice->user_id);
    $servеr = Bill::getInvoiceServer($id);
    $invoice_logs = Bill::logs()->getInvoiceLog($id, $invoice->user_id);
    if(!isset($servеr->allocation_id)) {
      return redirect()->back()->with('warning', 'Server for this order could not be found. It may have been manually deleted by an Admin or deleted my schedular if it was overdue.');
    }

    $allocation = DB::table('allocations')->where('id', $servеr->allocation_id)->first();
    $plans = Bill::plans()->getArrayKeyData();

    $data = [
      'invoice_logs' => $invoice_logs,
      'invoice' => $invoice,
      'bill_user' => $bill_user,
      'user' => $user,
      'settings' => Bill::settings()->getAll(),
      'server' => $servеr,
      'allocation' => $allocation,
      'plan' => $plans[$invoice->plan_id],
    ];
    return view('templates.' . $this->template . '.billing.admin.manage_order', ['order' => $data]);
  }

  public function updateOrder($id, Request $request)
  {
    
    if(isset($request->expiration) AND isset($request->status)) {
      $updateOrder = Bill::invoices()->updateInvoice($id, $request->status, $request->expiration);

      if(!$updateOrder) {
        return redirect()->back()->with('warning', 'Unable to proccess your request. Please check the provided information.');
      }

      Bill::events()->create('admin', Auth::user()->id, 'admin:order:updated', Auth::user()->username.' (admin) updated order #'.$id);
      return redirect()->back()->with('success', 'Order has been updated successfully!');

    }

  }

  public function tickets()
  {
    return view('templates.' . $this->template . '.billing.admin.tickets.list', ['tickets' => Bill::tickets()->orderByRaw('updated_at DESC')->paginate(15)]);
  }

  public function manageTicket($id)
  {
    $ticket =  Bill::tickets()->findOrFail($id);
    $responses = Bill::tickets()->response()->where('uuid', $ticket->uuid)->latest()->paginate(5);
    $user = User::findOrFail($ticket->user_id);

    return view('templates.' . $this->template . '.billing.admin.tickets.manage', ['ticket' => $ticket, 'responses' => $responses, 'user' => $user]);
  }

  public function games()
  {
    return view('templates.' . $this->template . '.billing.admin.games', ['biling_games' => Bill::games()->get()]);
  }

  public function createGame(Request $request)
  {

    $validated = $request->validate([
      'label' => 'required|max:40',
      'link' => 'required',
      'icon' => 'required',
    ]);
    $game = Bill::games();
    $game->label = $request->input('label');
    $game->link = $request->input('link');
    $game->icon = $request->input('icon');
    $game->save();

    Bill::events()->create('admin', Auth::user()->id, 'admin:game:create', Auth::user()->username.' (admin) created a new game called '.$game->label);
    return redirect()->back()->with('success', $game->label . ' has been added to game list.');
  }

  public function editGame(Request $request)
  {
    $validated = $request->validate([
      'game_id' => 'required',
      'label' => 'required|max:40',
      'link' => 'required',
      'icon' => 'required',
    ]);
    $game = Bill::games()->find($request->input('game_id'));
    $game->label = $request->input('label');
    $game->link = $request->input('link');
    $game->icon = $request->input('icon');
    $game->save();

    Bill::events()->create('admin', Auth::user()->id, 'admin:game:updated', Auth::user()->username.' (admin) updated a game '.$game->label);
    return redirect()->back()->with('success', $game->label . ' has been edited successfully.');
  }

  public function deleteGame(Request $request)
  {
    $validated = $request->validate([
      'game_id' => 'required',
    ]);
    if (!empty(Bill::plans()->where('game_id', $request->input('game_id'))->first())) {
      return redirect()->back()->with('warning', Bill::lang()->get('err_remove_game'));
    }
    $game = Bill::games()->find($request->input('game_id'));
    $game->delete();

    Bill::events()->create('admin', Auth::user()->id, 'admin:game:deleted', Auth::user()->username.' (admin) deleted a game # '.$request->input('game_id'));
    return redirect()->back()->with('warning', $game->label . ' has been deleted successfully.');
  }


  public function plans()
  {
    $nodes = Bill::servers()->getNodes();
    $eggs = Bill::servers()->getEggs();
    $plans = Bill::plans();
    $games_arr = array();
    foreach (Bill::games()->get() as $game) {
      $games_arr[$game->id] = $game;
    }
    return view('templates.' . $this->template . '.billing.admin.plans', ['nodes' => $nodes, 'eggs' => $eggs, 'settings' => Bill::settings()->getAll(), 'plans' => $plans->get(), 'games' => $games_arr]);
  }

  public function createPlan(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|max:40',
      'price' => 'required',
      'discount' => 'digits_between:0,2|numeric',
      'game_id' => 'required',
      'egg' => 'required',
      'memory' => 'required',
      'disk_space' => 'required',
      'node' => 'required',
      'limit' => 'required',
    ]);

    $plan = Bill::plans();
    $plan->name = $request->input('name');
    $plan->price = $request->input('price');
    $plan->discount = $request->input('discount');
    $plan->icon = $request->input('icon');
    $plan->cpu_model = $request->input('cpu_model');
    $plan->game_id = $request->input('game_id');
    $plan->egg = $request->input('egg');
    $plan->days = $request->input('days');
    $plan->cpu_limit = $request->input('cpu_limit');
    $plan->memory = $request->input('memory');
    $plan->disk_space = $request->input('disk_space');
    $plan->database_limit = $request->input('database_limit');
    $plan->allocation_limit = $request->input('allocation_limit');
    $plan->backup_limit = $request->input('backup_limit');
    $plan->description = $request->input('description');
    $plan->node = $request->input('node')[0];
    $plan->limit = $request->input('limit');
    $plan->plugins = $request->input('plugins');
    $plan->subdomain = $request->input('subdomain');
    if (!empty($request->input('variables'))) {
      $variables = explode(PHP_EOL, $request->input('variables'));
      $variables_data = array();
      foreach ($variables as $value) {
        $arr = explode('=', trim($value));
        $variables_data[] = array(
          trim($arr['0']) => trim($arr['1'])
        );
      }
      $variables_data = json_encode($variables_data);
    }
    $plan->variable = $variables_data;
    $plan->save();
    Bill::nodes()->createSubNodes($plan->id, $request->input('node'));
    Bill::events()->create('admin', Auth::user()->id, 'admin:plan:create', Auth::user()->username.' (admin) created a new plan called '.$plan->name);
    return redirect()->back()->with('success', $plan->name . ' has been added successfully.');
  }

  public function editPlan(Request $request)
  {
    $validated = $request->validate([
      'plan_id' => 'required',
      'name' => 'required|max:40',
      'price' => 'required',
      'discount' => 'digits_between:0,2|numeric',
      'node' => 'required',
      'limit' => 'required',
    ]);

    $plan = Bill::plans()->find($request->input('plan_id'));
    $plan->name = $request->input('name');
    $plan->price = $request->input('price');
    $plan->discount = $request->input('discount');
    $plan->icon = $request->input('icon');
    $plan->cpu_model = $request->input('cpu_model');
    $plan->description = $request->input('description');
    $plan->node = $request->input('node')[0];
    $plan->limit = $request->input('limit');
    $plan->plugins = $request->input('plugins');
    $plan->subdomain = $request->input('subdomain');
    if (!empty($request->input('variables'))) {
      $variables = explode(PHP_EOL, $request->input('variables'));
      $variables_data = array();
      foreach ($variables as $value) {
        $arr = explode('=', trim($value));
        $variables_data[] = array(
          trim($arr['0']) => trim($arr['1'])
        );
      }
      $variables_data = json_encode($variables_data);
    }
    $plan->variable = $variables_data;
    $plan->save();
    Bill::nodes()->createSubNodes($plan->id, $request->input('node'));
    Bill::events()->create('admin', Auth::user()->id, 'admin:plan:updated', Auth::user()->username.' (admin) updated a plan called '.$plan->name);
    return redirect()->back()->with('success', $plan->name . ' has been edited successfully.');
  }

  public function deletePlan(Request $request)
  {
    $validated = $request->validate([
      'plan_id' => 'required',
    ]);
    $plan = Bill::plans()->find($request->input('plan_id'));
    $plan->delete();
    Bill::nodes()->where('plan_id', $request->input('plan_id'))->delete();
    Bill::events()->create('admin', Auth::user()->id, 'admin:plan:deleted', Auth::user()->username.' (admin) deleted plan # '.$request->input('plan_id'));
    return redirect()->back()->with('warning', $plan->name . ' has been deleted successfully.');
  }


  // Users Function
  public function users()
  {
    return view('templates.' . $this->template . '.billing.admin.users', ['users' => Bill::users()->getAllUsers(), 'settings' => Bill::settings()->getAll()]);
  }

  public function newBalance(Request $request)
  {
    $validated = $request->validate([
      'user_id' => 'required',
      'count' => 'required',
    ]);
    $user = Bill::users()->find($request->input('user_id'));
    $user->editBalance($request->input('count'), '=');
    Bill::events()->create('admin', Auth::user()->id, 'admin:balance:update', Auth::user()->username.' (admin) updated balance of user #'.$request->input('user_id').' with $'. $request->input('count'));
    return redirect()->back()->with('success', 'You have edited ' . $user . ' balance successfully.');
  }

  public function userInvoices($id)
  {
    $billding_user = Bill::users()->where('user_id', $id)->first();
    $invoices = Bill::invoices()->where('user_id', $billding_user->user_id)->get();
    return view('templates.' . $this->template . '.billing.admin.users_invoices', ['plans' => Bill::plans()->getArrayKeyData(), 'invoices' => $invoices, 'billding_user' => $billding_user, 'settings' => Bill::settings()->getAll()]);
  }

  public function userPayments($id)
  {
    $billding_user = Bill::users()->where('user_id', $id)->first();
    $logs = Bill::logs()->where('user_id', $billding_user->user_id)->where('type', 'paypal')->get();
    return view('templates.' . $this->template . '.billing.admin.users_payments', ['logs' => $logs, 'billding_user' => $billding_user, 'settings' => Bill::settings()->getAll()]);
  }

  public function Emails()
  {
    return view('templates.' . $this->template . '.billing.admin.emails', ['settings' => Bill::settings()->getAll()]);
  }

  public function sendEmails()
  {

    // Send Mail
    $subject = $_POST['subject'];
    $intro = $_POST['intro_message'];
    $outro = $_POST['outro_message'];
    $button_name = $_POST['button_name'];
    $button_url = $_POST['button_URL'];

    Bill::mail()->EmailAllUsers($subject, $intro, $outro, $button_name, $button_url);
    Bill::events()->create('admin', Auth::user()->id, 'mail:sent:everyone', Auth::user()->username.' (admin) sent emails to all users');
    return redirect()->back()->with('success', 'You have sent emails to all users.');
  }

  public function userEmails($name, $email)
  {
    return view('templates.' . $this->template . '.billing.admin.users_email', ['settings' => Bill::settings()->getAll(), 'email' => $email, 'name' => $name]);
  }

  public function sendUserEmail()
  {

    // Send Mail
    $receiver = $_POST['receiver'];
    $name = $_POST['name'];
    $intro = $_POST['intro_message'];
    $outro = $_POST['outro_message'];
    $button_name = $_POST['button_name'];
    $button_url = $_POST['button_URL'];

    if (isset($_POST['receiver'], $_POST['name'], $_POST['intro_message'], $_POST['outro_message'], $_POST['button_name'], $_POST['button_URL'])) {
      Bill::mail()->EmailUser($receiver, $name, $intro, $outro, $button_name, $button_url);
      return redirect()->back()->with('success', 'Email has been sent successfully to ' . $receiver);
    } else {
      return redirect()->back()->with('warning', 'Please fill in all fields before sending an email.');
    }
  }

  public function Webhooks()
  {
    return redirect()->back()->with('warning', 'This feature is still being developed!');

    // return view('templates.' . $this->template . '.billing.admin.webhooks', ['settings' => Bill::settings()->getAll()]);

  }

  public function discord()
  {
    return view('templates.' . $this->template . '.billing.admin.discord', ['settings' => Bill::settings()->getAll(),]);
  }

  public function alerts()
  {
    return view('templates.' . $this->template . '.billing.admin.alerts', ['settings' => Bill::settings()->getAll(),]);
  }

  public function portal()
  {
    return view('templates.' . $this->template . '.billing.admin.portal', ['settings' => Bill::settings()->getAll(),]);
  }

  public function portalUpdate()
  {
    if (isset($_POST['faq_save'])) {
      if (isset($_POST['faq_content'])) {
        Bill::settings()->updateFaq($_POST['faq_content']);
      } else {
        Bill::settings()->where('name', 'faq_content')->delete();
      }
    } elseif (isset($_POST['team_save'])) {
      if (isset($_POST['team_content'])) {
        Bill::settings()->updateTeam($_POST['team_content']);
      } else {
        Bill::settings()->where('name', 'team_content')->delete();
      }
    }
    return redirect()->back()->with('success', 'Portal settings have been saved successfully.');
  }

  public function domain()
  {
    if(!Bill::allowed('subdomain')) {
      return $this->denied();
    }

    return view('templates.' . $this->template . '.billing.admin.domain.subdomain', ['subdomain' => Bill::subdomain(null)->getAllSubDomain(), 'users' => Bill::users()->getAllUsers()]);
  }

  public function domainAPI()
  {
    if(!Bill::allowed('subdomain')) {
      return $this->denied();
    }

    return view('templates.' . $this->template . '.billing.admin.domain.apisettings', ['apis' => Bill::subdomain(null)->getAPIs()]);
  }

  public function domainPOST(Request $request)
  {
    if(!Bill::allowed('subdomain')) {
      return $this->denied();
    }
    
    if (isset($_POST['delete_domain_id'])) {
      Bill::subdomain(null)->remove($request->input('delete_domain_id'));
    } elseif (isset($_POST['delete_api_id'])) {
      Bill::subdomain(null)->removeAPI($request->input('delete_api_id'));
    } elseif (isset($_POST['create_api'])) {
      $data['type'] = 'cloudflare';
      $data['domain'] = $request->input('domain');
      $data['data'] = [
        'email' => $request->input('email'),
        'key' => $request->input('key'),
        'zone_id' => $request->input('zone_id'),
      ];
      Bill::subdomain(null)->updateOrCreateAPI($data);
    }
    return redirect()->back()->with('success', 'Domain has been added successfully.');
  }

  public function meta()
  {
    return view('templates.' . $this->template . '.billing.admin.meta', ['settings' => Bill::settings()->getAll(),]);
  }

  public function update()
  {
    return view('templates.' . $this->template . '.billing.admin.update', ['settings' => Bill::settings()->getAll(),]);
  }

  public function updateInstall()
  {
    Artisan::call("billing:install stable " . Bill::settings()->getParam('license_key'));
    return redirect()->back();
  }

  public function getPages()
  {
    $pages = Bill::pages()->get();
    return view('templates.' . $this->template . '.billing.admin.pages', ['pages' => $pages]);
  }

  public function createPage()
  {
    return view('templates.' . $this->template . '.billing.admin.edit_pages');
  }

  public function updatePage($id)
  {
    $page = DB::table('custom_pages')->where('id', $id)->first();
    return view('templates.' . $this->template . '.billing.admin.edit_pages', ['page_id' => $id, 'page' => $page]);
  }

  public function giftcard()
  {
    $giftcard = DB::table('billing_giftcards')->get();
    return view('templates.' . $this->template . '.billing.admin.giftcard', ['giftcard' => $giftcard, 'settings' => Bill::settings()->getAll()]);
  }

  public function giftcardManage(Request $request)
  {
    if ($request->has('delete_card_id')) {
      $validated = $request->validate([
        'delete_card_id' => 'required',
      ]);
      DB::table('billing_giftcards')->where('id', $request->input('delete_card_id'))->delete();
    } elseif ($request->has('edit_card_id')) {
      $validated = $request->validate([
        'edit_card_id' => 'required',
        'edit_card_limit' => 'required|numeric',
        'edit_card_value' => 'required|numeric',
        'edit_card_code' => 'required',
      ]);
      DB::table('billing_giftcards')->where('id', $request->input('edit_card_id'))->update(array(
        'name' => $request->input('edit_card_name'),
        'limit' => $request->input('edit_card_limit'),
        'code' => $request->input('edit_card_code'),
        'value' => $request->input('edit_card_value'),
      ));
    } else {
      $validated = $request->validate([
        'edit_card_limit' => 'required|numeric',
        'edit_card_value' => 'required|numeric',
        'edit_card_code' => 'required',
      ]);
      DB::table('billing_giftcards')->insert(array(
        'name' => $request->input('edit_card_name'),
        'limit' => $request->input('edit_card_limit'),
        'code' => $request->input('edit_card_code'),
        'value' => $request->input('edit_card_value'),
      ));
    }
    Bill::events()->create('admin', Auth::user()->id, 'giftcard:manage', Auth::user()->username.' (admin) created/updated GiftCards');
    return redirect()->route('admin.billing.giftcard')->with('success', 'Successfully updated giftcard');
  }

  public function giftcardMail()
  {

    // Send Mail
    $receiver = $_POST['receiver_email'];
    $name = $_POST['receiver_name'];
    $giftcard = $_POST['receiver_code'];

    if (isset($_POST['receiver_email'], $_POST['receiver_name'])) {
      Bill::mail()->EmailUser($receiver, $name, "Good news! There was a giftcard generated for your account. <br> <br>Your giftcard code can be found below, the giftcard can be redeemed on our website.", "Your giftcard can be redeemed on our website under the balance section. If you have any questions, don't hesitate to contact us :)", $giftcard, route('billing.balance'));

      return redirect()->back()->with('success', 'Email has been sent successfully to ' . $receiver);
    } else {
      return redirect()->back()->with('warning', 'Please fill in all fields before sending an email.');
    }
  }


  public function savePage(Request $request)
  {
    $validated = $request->validate([
      'url' => 'required',
      'type' => 'required',
      'name' => 'required',
    ]);

    if (isset($_POST['page_id'])) {
      DB::table('custom_pages')->where('id', $request->input('page_id'))->update(array(
        'url' => $request->input('url'),
        'icon' => $request->input('icon'),
        'type' => $request->input('type'),
        'custom' => $request->input('name'),
        'auth' => 1,
        'data' => htmlentities($request->input('content')),
      ));
    } else {
      DB::table('custom_pages')->insert(array(
        'url' => $request->input('url'),
        'icon' => $request->input('icon'),
        'type' => $request->input('type'),
        'custom' => $request->input('name'),
        'auth' => 1,
        'data' => htmlentities($request->input('content')),
      ));
    }

    Bill::events()->create('admin', Auth::user()->id, 'admin:page:updated', Auth::user()->username.' (admin) created/updated custom pages');
    return redirect()->route('admin.billing.pages')->with('success', 'Your page has been saved successfully.');
  }

  public function deletePage(Request $request)
  {
    $validated = $request->validate([
      'page_id' => 'required',
    ]);
    DB::table('custom_pages')->where('id', $request->input('page_id'))->delete();
    Bill::events()->create('admin', Auth::user()->id, 'admin:page:delete', Auth::user()->username.' (admin) deleted page #'.$request->input('page_id'));

    return redirect()->back()->with('warning', 'Page has been deleted successfully.');
  }


  public function order(Request $request)
  {
    $data = $request->json()->all()['order'];
    switch ($data[0]) {
      case 'games':
        unset($data[0]);
        foreach ($data as $id => $order) {
          Bill::games()->where('id', $id)->update(['order' => $order]);
        }
        break;
      case 'plans':
        unset($data[0]);
        foreach ($data as $id => $order) {
          Bill::plans()->where('id', $id)->update(['order' =>  $order]);
        }
        break;
      case 'pages':
        unset($data[0]);
        foreach ($data as $id => $order) {
          Bill::pages()->where('id', $id)->update(['order' =>  $order]);
        }
        break;
      default:
        # code...
        break;
    }
  }

  private function denied()
  {
    return redirect()->back()->withError('You have discovered a Premium Feature, to access upgrade your plan. Upgrade here: https://wemx.net/pricing');
  }
}
