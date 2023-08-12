<?php

namespace Pterodactyl\Models\Billing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Pterodactyl\Models\Server;

class BillingInvoices extends Model
{
  use HasFactory;

  public function stats()
  {
  $data = array();
  $data['revenue'] = 0;
  foreach (self::get() as $key => $order) {
    if($order['status'] == 'Paid') {

      if(Bill::plans()->where('id', $order['plan_id'])->exists())
      {
        $plan = Bill::plans()->find($order['plan_id']);
        $data['revenue'] += Bill::plans()->find($order['plan_id'])->price;
      }

    }
  }
  $data['orders'] = self::count();
  $data['clients'] = Bill::users()->count();

  return $data;
  }

  public function updateInvoice($id, $status, $date)
  {
    $this->where('id', $id)->update([
      'status' => $status,
      'due_date' => $date,
    ]);

    return true;
  }

  public function upgradeOrDowngrade($invoice_id, $upgrade_plan_id, $upgrade_cost = NULL)
  {
    // Update Plan
    $invoice = $this->findOrFail($invoice_id);
    $invoice->plan_id = $upgrade_plan_id;
    $invoice->save();

    // deduct from balance
    if($upgrade_cost !== NULL) {
    $user = Bill::users()->getAuth();
    $user->editBalance($upgrade_cost, '-');
    }

    // Update Server Resources
    $plan =  Bill::plans()->find($upgrade_plan_id);
    $server = Server::find($invoice->server_id);
    $server->memory = $plan->memory;
    $server->disk = $plan->disk_space;
    $server->cpu = $plan->cpu_limit;
    $server->allocation_limit = $plan->allocation_limit;
    $server->backup_limit = $plan->backup_limit;
    $server->database_limit = $plan->database_limit;
    $server->save();

    return true;
  }
  
}