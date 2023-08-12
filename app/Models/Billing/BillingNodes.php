<?php

namespace Pterodactyl\Models\Billing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingNodes extends Model
{
    use HasFactory;

    public function createSubNodes($plan_id, $nodes_ids){
      self::where('plan_id', $plan_id)->delete();
      foreach ($nodes_ids as $key => $value) {
        self::insert([
          'plan_id' => $plan_id,
          'node_id' => $value
        ]);
      }
    }

    public function getPlanNodes($plan_id){
      $data = self::where('plan_id', $plan_id)->get();
      if (!empty($data)) {
      $resp = array();
        foreach ($data as $key => $value) {
          $resp[$value->node_id] = true;
        }
      }
      return $resp;
    }
}
