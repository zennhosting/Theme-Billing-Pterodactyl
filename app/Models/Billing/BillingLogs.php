<?php

namespace Pterodactyl\Models\Billing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingLogs extends Model
{
  use HasFactory;

  public static function setInvoiceLog($count, $param, $invoice_id, $user_id)
  {
    $log = new BillingLogs;

    $log->type = 'invoce' . $invoice_id;
    $log->user_id = $user_id;
    $log->txn_id = microtime(true);
    $log->status = $invoice_id;
    $log->data = $param . $count;
    $log->save();
  }


  public static function getInvoiceLog($invoice_id, $user_id)
  {
    $log = new BillingLogs;
    return $log->where('type', 'invoce' . $invoice_id)->where('user_id', $user_id)->get();
  }

  public static function getUserPayPalLog($user_id)
  {
    $log = new BillingLogs;
    return $log->where('type', 'paypal')->where('user_id', $user_id)->get();
  }

  public static function getAllPayPalLog()
  {
    $log = new BillingLogs;
    return $log->where('type', 'paypal')->get();
  }
}
