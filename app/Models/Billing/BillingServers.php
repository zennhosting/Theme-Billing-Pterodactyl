<?php

namespace Pterodactyl\Models\Billing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Pterodactyl\Models\Egg;
use Pterodactyl\Models\Node;
use Pterodactyl\Models\Allocation;
use Pterodactyl\Models\User;
use Pterodactyl\Models\Billing\PteroAPI\PteroAPI;

use Bill;


class BillingServers extends Model
{
  public static function getEggVariables($egg_id)
  {
    $eggs = DB::table('egg_variables')->where('egg_id', $egg_id)->get();
    $resp = [];
    if (!empty($eggs)) {
      foreach ($eggs as $value) {
        $resp[$value->env_variable] = $value->default_value;
      }
      return $resp;
    }
    return false;
  }

  public static function getEgg($id, $variables = false)
  {
    $egg = Egg::find($id)->attributesToArray();
    if (!$variables) {
      return $egg;
    }
    $egg['variables'] = self::getEggVariables($id);
    return $egg;
  }

  public static function getEggs()
  {
    $eggs = [];
    foreach (Egg::get() as $value) {
      $eggs[$value->id] = self::getEgg($value->id, true);
    }
    return $eggs;
  }

  public static function getAvailablePort(int $node, array $skip_ports = ['00000'])
  {

    $last_port = Allocation::where('node_id', $node)->whereNull('server_id')->first();
    if (!empty($last_port) and !in_array($last_port->port, $skip_ports)) {
      return $last_port->port;
    } else {
      $allocations = self::getAllocations($node);
      if (empty($allocations)) {
        $last_port = 25565;
      } else {
        $last_port = $allocations[array_key_first($allocations)]['port'] + 1;
      }

      while (true) {
        if (in_array($last_port, $skip_ports)) {
          $last_port++;
          continue;
        }
        if (empty(Allocation::where('node_id', $node)->where('port', $last_port)->whereNotNull('server_id')->first())) {
          return $last_port;
          break;
        } else {
          $last_port++;
        }
      }
    }
  }

  public static function getAllocations($node_id = 0)
  {
    $resp = [];
    if ($node_id == 0) {
      $allocations = Allocation::orderByDesc('port')->get();
    } else {
      $allocations = Allocation::where('node_id', $node_id)->orderByDesc('port')->get();
    }
    foreach ($allocations as $value) {
      $resp[$value->id] = $value->attributesToArray();
    }
    return $resp;
  }

  public static function getAllocationWherePort($node_id, $port)
  {
    $allocation = Allocation::where('port', $port)->where('node_id', $node_id)->whereNull('server_id')->first();
    if (!empty($allocation)) {
      return $allocation->attributesToArray();
    } else {
      $allocation = new Allocation;
      $allocation->port = $port;
      $allocation->node_id = $node_id;
      $allocation->ip = gethostbyname(self::getNodes($node_id)['fqdn']);
      $allocation->save();
      return Allocation::find(DB::getPdo()->lastInsertId())->attributesToArray();
    }
  }

  public static function setAlocation($node_id, $port, $server_id = NULL, $notes = NULL)
  {
    $allocation = Allocation::firstOrNew(['port' => $port]);
    $allocation->node_id = $node_id;
    $allocation->server_id = $server_id;
    $allocation->port = $port;
    $allocation->ip = gethostbyname(self::getNodes($node_id)['fqdn']);
    $allocation->notes = $notes;
    $allocation->save();
    return $allocation;
  }

  public static function getNodes($id = 0)
  {
    if ($id == 0) {
      $nodes = [];
      foreach (Node::get() as $value) {
        $nodes[$value->id] = $value->attributesToArray();
      }
      return $nodes;
    }
    if (!empty($node = Node::find($id))) {
      return $node->attributesToArray();
    }
    return false;
  }

  public static function chekNodeMemory(PteroAPI $api, $node_id, $require_disk, $require_memory)
  {
    $node = $api->node->get($node_id)['attributes'];

    $free_memory = $node['memory'] - $node['allocated_resources']['memory'];
    $free_disk = $node['disk'] - $node['allocated_resources']['disk'];
    if ($free_memory < $require_memory) {
      return false;
    }
    if ($free_disk < $require_disk) {
      return false;
    }
    return true;
  }

  public static function create($user_id, $plan_id)
  {
    $url = config('app.url');
    $api = Bill::settings()->getParam('api_key');
    $api = new PteroAPI($api, $url);

    $plan = Bill::plans()->find($plan_id);
    $egg = self::getEgg($plan->egg);
    $user = User::find($user_id);

    $plan_nodes = Bill::nodes()->getPlanNodes($plan->id);

    if (isset($plan_nodes['0'])) {
      foreach (Node::get() as $value) {
        if (self::chekNodeMemory($api, $value->id, $plan->disk_space, $plan->memory)) {
          $plan->node = $value->id;
          break;
        }
      }
      if ($plan->node == 0) {
        return ['status' => false, 'text' => Bill::lang()->get('error_full_node')];
      }
    } else {
      if (!empty($plan_nodes)) {
        foreach ($plan_nodes as $key => $value) {
          if (self::chekNodeMemory($api, $key, $plan->disk_space, $plan->memory)) {
            $plan->node = $key;
            break;
          }
        }
      } else {
        if (!self::chekNodeMemory($api, $plan->node, $plan->disk_space, $plan->memory)) {
          return ['status' => false, 'text' => Bill::lang()->get('error_full_node')];
        }
      }


    }

    $server_port = self::getAvailablePort($plan->node);
    $allocation = self::getAllocationWherePort($plan->node, $server_port);

    $environment = json_decode($plan->variable, true);
    $env = [];
    $rcon_port = self::getAvailablePort($plan->node, [$server_port]);
    foreach ($environment as $value) {
      foreach ($value as $key => $val) {
        if ($key == 'RCON_PORT') {
          $env[$key] = $rcon_port;
          continue;
        }
        if ($key == 'APP_PORT') {
          $env[$key] = self::getAvailablePort($plan->node, [$server_port, $rcon_port]);
          continue;
        }
        $env[$key] = $val;
      }
    }

    $allocations_ids['default'] = $allocation['id'];
    if (isset($env['RCON_PORT'])) {
      $allocations_ids['rcon'] = self::getAllocationWherePort($plan->node, $env['RCON_PORT'])['id'];
    }
    if (isset($env['APP_PORT'])) {
      $allocations_ids['app'] = self::getAllocationWherePort($plan->node, $env['APP_PORT'])['id'];
    }

    $create_params = array(
      "name" => "[{$plan->name}] {$user->name}",
      "user" => $user->id,
      "egg" => $egg['id'],
      "docker_image" => array_values($egg['docker_images'])[0],
      "startup" => $egg["startup"],
      "environment" => $env,
      "limits" => array(
        "memory" => $plan->memory,
        "swap" => 0,
        "disk" => $plan->disk_space,
        "io" => 100,
        "cpu" => $plan->cpu_limit
      ),
      "feature_limits" => array(
        "databases" => $plan->database_limit,
        "backups" => $plan->backup_limit,
        "allocations" => $plan->allocation_limit
      ),
      "allocation" => $allocations_ids
    );

    $server = $api->servers->create($create_params);
    if (!isset($server['errors'])) {
      $invoice = Bill::invoices();
      $invoice->user_id = $user->id;
      $invoice->plan_id = $plan->id;
      $invoice->server_id = $server['attributes']['id'];
      $dt = date("Y-m-d");
      $invoice->invoice_date = $dt;
      $invoice->due_date = date("Y-m-d", strtotime("{$dt} +{$plan->days} day"));
      $invoice->status = 'Paid';
      $invoice->save();
      Bill::logs()->setInvoiceLog($plan->price, '-', $invoice->id, $user->id);

      if (isset($env['RCON_PORT'])) {
        self::setAlocation($plan->node, $env['RCON_PORT'], $server['attributes']['id'], 'RCON_PORT');
      }
      if (isset($env['APP_PORT'])) {
        self::setAlocation($plan->node, $env['APP_PORT'], $server['attributes']['id'], 'APP_PORT');
      }
      return ['status' => true];
    } else {

      if (isset($server['errors'])) {
        $errors = [];
        foreach ($server['errors'] as  $value) {
          array_push($errors, $value['detail']);
        }
        return ['status' => false, 'text' => $errors];
      } else {
        dd($server);
      }
    }
  }

  public static function remove($server_id)
  {
    $api = new PteroAPI(Bill::settings()->getParam('api_key'), request()->getSchemeAndHttpHost());
    $api->servers->forceDelete($server_id);
  }

  public static function getCount()
  {
    return count(DB::table('servers')->whereNull('status')->get());
  }
}
