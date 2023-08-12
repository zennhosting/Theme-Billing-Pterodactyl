<?php

namespace Pterodactyl\Models\Billing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Pterodactyl\Http\Controllers\Billing\Admin\OrderScope;

class BillingGames extends Model
{
  use HasFactory;

  protected static function boot()
  {
    parent::boot();
    static::addGlobalScope(new OrderScope('order', 'asc'));
  }

  public static function getNameToId($id)
  {
    $game = self::find($id);
    return $game->label;
  }
}
