<?php

namespace Pterodactyl\Models\Billing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Pterodactyl\Models\User;

use Bill;

class BillingUsers extends Model
{
  use HasFactory;

  public function issetOrCreateUser()
  {
    if (empty($this->where('user_id', Auth::user()->id)->first())) {
      $this->user_id = Auth::user()->id;
      $this->balance = 0;
      $this->save();
    }
    return true;
  }

  public function getAuth()
  {
    $this->issetOrCreateUser();
    return $this->where('user_id', Auth::user()->id)->first();
  }

  public function editBalance($count, $param, $invoice_id = NULL)
  {
    if ($param == '+') {
      $this->increment('balance', $count);
    } elseif ($param == '-') {
      $this->decrement('balance', $count);
    } elseif ($param == '=') {
      $this->balance = $count;
      $this->save();
    }

    if ($invoice_id != NULL) {
      Bill::logs()->setInvoiceLog($count, $param, $invoice_id, $this->user_id);
    }
  }

  public static function getAllUsers()
  {
    $data = array();
    foreach (self::paginate(15) as $key => $user) {
      $data[$user->user_id]['billing'] = $user;
      $data[$user->user_id]['ptero'] = User::find($user->user_id);
    }
    return $data;
  }

  public static function getUserServersData($user_id)
  {
    $user = User::find($user_id);
    if (empty($user)) {
      return redirect()->back();
    }

    $user_servers = $user->servers()->getResults();
    $servers = array();
    foreach ($user_servers as $key => $value) {
      $data = $value->attributesToArray();
      $invoice = Bill::invoices()->where('server_id', $data['id'])->first();

      if (empty($invoice)) {
        continue;
      } else {
        $invoice = $invoice->attributesToArray();
        $bp = Bill::plans()->find($invoice['plan_id']);
        if (empty($bp)) {
          continue;
        }
        $plan = $bp->attributesToArray();
        if ($plan['plugins'] !== 1) {
          continue;
        }
        $data['plan_id'] = $invoice['plan_id'];
        $data['invoise_id'] = $invoice['id'];
        $data['plugins'] = $plan['plugins'];
        $servers[$data['uuidShort']] = $data;
      }
    }
    return $servers;
  }

  public static function getCount()
  {
    return count(self::get());
  }

  public static function pterodactyl($id)
  {
    return User::find($id);
  }
}
