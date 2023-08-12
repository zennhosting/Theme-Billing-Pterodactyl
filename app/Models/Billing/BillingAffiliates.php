<?php

namespace Pterodactyl\Models\Billing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Pterodactyl\Models\User;
use Illuminate\Support\Facades\DB;

use Bill;

class BillingAffiliates extends Model
{
  use HasFactory;

  public function issetOrCreateAffiliate()
  {
    if (empty($this->where('user_id', Auth::user()->id)->first())) {
      $this->user_id = Auth::user()->id;
      $this->code = Str::random(8);
      $this->creator_commision = 5;
      $this->discount = 10;
      $this->total_earned = 0;
      $this->clicks = 0;
      $this->purchases = 0;

      $this->save();
    }
    return true;
  }

  public function EditAffiliate($id, $code, $earned, $commision, $discount)
  {
    $this->where('user_id', $id)->update([
      'code' => $code,
      'total_earned' => $earned,
      'creator_commision' => $commision,
      'discount' => $discount,
    ]);

    return true;
  }

  public function getAuth()
  {
    return $this->where('user_id', Auth::user()->id)->first();
  }

  public function getAffiliate($code)
  {
    return $this->where('code', $code)->first();
  }

  public function UpdateClicks($code)
  {
    $this->where('code', $code)->increment('clicks', 1);
  }

  public function AddBalance($code, $amount) {
    $this->where('code', $code)->increment('total_earned', $amount);
    $this->where('code', $code)->increment('purchases', 1);
  }

  public function Cashout($amount)
  {
      $this->where('user_id', Auth::user()->id)->decrement('total_earned', $amount);
      DB::table("billing_users")->where('user_id', Auth::user()->id)->increment('balance', $amount);
  }

  public static function getAllAffiliates()
  {
    $data = array();
    foreach (self::paginate(15) as $key => $user) {
      $data[$user->user_id]['billing'] = $user;
      $data[$user->user_id]['ptero'] = User::find($user->user_id);
    }
    return $data;
  }

  public static function getCount()
  {
    return count(self::get());
  }
}
