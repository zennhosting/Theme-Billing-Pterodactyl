<?php

namespace Pterodactyl\Models\Billing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Pterodactyl\Http\Controllers\Billing\Admin\OrderScope;

use Bill;

class BillingPlans extends Model
{
  use HasFactory;

  protected static function boot()
  {
    parent::boot();
    static::addGlobalScope(new OrderScope('order', 'asc'));
  }

  public function getGameName()
  {
    return Bill::games()->getNameToId($this->game_id);
  }

  public function getArrayKeyData()
  {
    $data = array();
    foreach ($this->get() as $key => $value) {
      $data[$value->id] = $value;
    }
    return $data;
  }

  public static function getCount()
  {
    return count(self::get());
  }

  public static function getPrice($plan_id)
  {
    $plan = self::find($plan_id)->first();
    if (empty($plan)) {
      return array('status' => false);
    }

    if ($plan->discount > 0) {
      $price = $plan->price - ($plan->price * ($plan->discount / 100));
      $discount_status = true;
    } else {
      $price = $plan->price;
      $discount_status = false;
    }
    return array(
      'status' => true,
      'discount' => $discount_status,
      'price' => $price,
      'discount_percent' => $plan->discount,
    );
  }

  public function price()
  {
    if ($this->discount > 0) {
      $price = $this->price - ($this->price * ($this->discount / 100));
      $discount_status = true;
    } else {
      $price = $this->price;
      $discount_status = false;
    }
    return array(
      'status' => true,
      'discount' => $discount_status,
      'price' => $price,
      'discount_percent' => $this->discount,
    );
  }
}
