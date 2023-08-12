<?php

namespace Pterodactyl\Models\Billing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Pterodactyl\Models\User;
use Pterodactyl\Models\Billing\BillingCart;
use Pterodactyl\Models\Billing\BillingGames;
use Pterodactyl\Models\Billing\BillingInvoices;
use Pterodactyl\Models\Billing\BillingLogs;
use Pterodactyl\Models\Billing\BillingEvents;
use Pterodactyl\Models\Billing\BillingPlans;
use Pterodactyl\Models\Billing\BillingServers;
use Pterodactyl\Models\Billing\BillingSettings;
use Pterodactyl\Models\Billing\BillingUsers;
use Pterodactyl\Models\Billing\BillingNodes;
use Pterodactyl\Models\Billing\BillingPages;
use Pterodactyl\Models\Billing\BillingHelpers;
use Pterodactyl\Models\Billing\BillingAffiliates;
use Pterodactyl\Models\Billing\BillingTickets;
use Pterodactyl\Models\Billing\BLang;
use Pterodactyl\Models\Billing\SubDomain\Cloudflare;
use Pterodactyl\Models\Billing\Logs\BillingMailer;
use Pterodactyl\Models\Billing\Logs\DiscordLogs;
use Pterodactyl\Models\Billing\Logs\UpdateChecker;

class Bill extends Model
{
  public static function cart()
  {
    return new BillingCart;
  }

  public static function games()
  {
    return new BillingGames;
  }

  public static function invoices()
  {
    return new BillingInvoices;
  }

  public static function logs()
  {
    return new BillingLogs;
  }

  public static function events()
  {
    return new BillingEvents;
  }

  public static function plans()
  {
    return new BillingPlans;
  }

  public static function servers()
  {
    return new BillingServers;
  }

  public static function settings()
  {
    return new BillingSettings;
  }

  public static function users()
  {
    return new BillingUsers;
  }

  public static function affiliates()
  {
    return new BillingAffiliates;
  }

  public static function tickets()
  {
    return new BillingTickets;
  }

  public static function lang()
  {
    return new BLang;
  }

  public static function subdomain($api_id)
  {
    return new Cloudflare($api_id);
  }

  public static function mail()
  {
    return new BillingMailer;
  }

  public static function discord()
  {
    return new DiscordLogs;
  }

  public static function upd()
  {
    return new UpdateChecker;
  }

  public static function pages()
  {
    return new BillingPages;
  }

  public static function nodes()
  {
    return new BillingNodes;
  }

  public static function helpers()
  {
    return new BillingHelpers;
  }



  public static function templatePath()
  {
    if (!Cache::has('active_template')) {
      Cache::put('active_template', 'Carbon');
    }
    $template = Cache::get('active_template');
    return base_path() . '/resources/views/templates/' . $template . '/';
  }

  public static function getMode()
  {
    if (!Auth::guest()) {
      if (!Cache::has('carbondarckmode' . Auth::user()->id)) {
        Cache::put('carbondarckmode' . Auth::user()->id, 'on');
        $mode = 'on';
      } else {
        $mode = Cache::get('carbondarckmode' . Auth::user()->id);
      }
    } else {
      if (isset($_COOKIE['carbondarckmode'])) {
        $mode = $_COOKIE['carbondarckmode'];
      } else {
        $mode = 'on';
      }
    }
    return $mode;
  }

  public static function invoiceIdToUser($id)
  {
    if (!empty($inv = self::invoices()->where('id', $id)->first())) {
      return User::find($inv->user_id);
    }
    return '';
  }

  public static function getInvoiceServer($invoice_id)
  {
    $server_id = self::invoices()->where('id', $invoice_id)->first()->server_id;
    if (!empty($server_id)) {
      $server = DB::table('servers')->where('id', $server_id)->first();
      if (!empty($server_id)) {
        return $server;
      }
    }
    return false;
  }

public static function getSubscriptionDetails()
{
    if(!Cache::has('billing')) {
        $response = json_decode('{
        "response": true,
        "description": "Your license was checked successfully.",
        "subscription": "Premium",
        "status": "active",
        "expiry": "3999-12-29",
        "expiry_in_days": 9999,
        "buyer": "CumMan69420",
        "subscription_id": "120176",
        "permissions": [
        "plugin_installer",
        "logs",
        "emails",
        "subdomain",
        "giftcards",
        "socialite",
        "configurable",
        "affiliates",
        "advancedlogs",
        "unbranded"
        ],
        "updated_at": "2022-11-29T17:10:19.000000Z",
        "created_at": "2022-11-29T17:10:19.000000Z"
        }');
        Cache::put('billing', $response, now()->addMinutes(720));
    }

return Cache::get('billing');
}

public static function allowed($area)
{
    return true;

}

  public static function isPluginPerms($server)
  {
    $uServers = BillingUsers::getUserServersData(Auth::user()->id);

    if (!isset($uServers[$server])) {
      return false;
    }
    return true;
  }
}
