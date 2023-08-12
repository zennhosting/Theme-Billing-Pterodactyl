<?php

namespace Pterodactyl\Http\Controllers\Billing;

use Pterodactyl\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Pterodactyl\Models\User;

use Bill;

class CoreController extends Controller
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
    Bill::users()->issetOrCreateUser();
    $games = Bill::games()->get();
    return view('templates.' . $this->getTemplate() . '.billing.games', ['games' => $games, 'settings' => Bill::settings()->getAll()]);
  }

  public function scheduler()
  {
    echo Bill::settings()->scheduler();
  }

  public function impersonate($id, $token)
  {

    $user = Auth::user();

    $validate = User::find($id);
    if($validate->root_admin) {
    return redirect()->back()->withErrors('You may not impersonate Admin Users due to security!');
    }
    
    if(Cache::has('impersonate_token') AND Cache::get('impersonate_token') == $token) {
      Auth::loginUsingId($id);
      header('Refresh: 1; URL='.route('billing.impersonate', ['id' => $id, 'token' => $token]) );
      echo 'You are being redirected...';
    }

    if(isset($user)) {
      return redirect('/account');
    }
        
  }

  public function getPage($page)
  {
    $page = DB::table('custom_pages')->where('url', $page)->first();
    return view('templates.' . $this->getTemplate() . '.billing.page_view', ['page' => $page, 'settings' => Bill::settings()->getAll()]);
  }

  public function toggleMode()
  {
    if (Auth::check()) {
      $mode = Cache::get('carbondarckmode' . Auth::user()->id);
      if ($mode == 'on') {
        $mode = 'off';
      } else {
        $mode = 'on';
      }
      Cache::put('carbondarckmode' . Auth::user()->id, $mode);
    } else {
      if (isset($_COOKIE['carbondarckmode'])) {
        $mode = $_COOKIE['carbondarckmode'];
      } else {
        $mode = 'on';
      }
      if ($mode == 'on') {
        $mode = 'off';
      } else {
        $mode = 'on';
      }
      setcookie('carbondarckmode', "", time() - 3600);
      setcookie('carbondarckmode', $mode, time() + 3600, '/');
    }
    return redirect()->back();
  }

  public function toggleUserLang($lang)
  {
    if (Auth::check()) {
      if (file_exists(app_path() . DIRECTORY_SEPARATOR . 'Models' . DIRECTORY_SEPARATOR . 'Billing' . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . $lang . '.php')) {
        Cache::put('billinguserlang' . Auth::user()->id, $lang);
      }
    } else {
      setcookie('billing_lang', "", time() - 3600);
      setcookie('billing_lang', $lang, time() + 3600, '/');
    }
    return redirect()->back();
  }

  public function buildData()
  {
    return 'true';
  }
}
