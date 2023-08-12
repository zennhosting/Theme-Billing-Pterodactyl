<?php

namespace Pterodactyl\Models\Billing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Pterodactyl\Http\Controllers\Billing\Admin\OrderScope;


class BillingPages extends Model
{

  use HasFactory;

  protected $table = 'custom_pages';

  protected static function boot()
  {
    parent::boot();
    static::addGlobalScope(new OrderScope('order', 'asc'));
  }
}
