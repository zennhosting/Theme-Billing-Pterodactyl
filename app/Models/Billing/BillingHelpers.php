<?php

namespace Pterodactyl\Models\Billing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Bill;

class BillingHelpers
{
  public function daysToHuman($days)
  {

    if($days == 1) {
      return 'Daily';
    }

    if($days == 7) {
      return 'Weekly';
    }

    if($days == 14) {
      return 'Every 2 weeks';
    }

    if($days == 30) {
      return Bill::lang()->get('monthly');
    }

    if($days == 90) {
      return Bill::lang()->get('quarterly');
    }

    if($days == 365) {
      return 'Yearly';
    }

    if($days == 999) {
      return 'Unlimited';
    }

    return 'every '. $days .' '. Bill::lang()->get('days');
  }

}
