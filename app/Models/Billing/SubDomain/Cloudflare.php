<?php

namespace Pterodactyl\Models\Billing\SubDomain;

use Illuminate\Database\Eloquent\Model;
use Cloudflare\API\Auth\APIKey;
use Cloudflare\API\Adapter\Guzzle;
use Cloudflare\API\Endpoints\DNS;
use Illuminate\Support\Facades\DB;

class Cloudflare extends Model
{

  public $dns;
  public $api_id;
  public $zoneID;
  public $domain;
  public $key;
  public $adapter;

  public function __construct($api_id = null)
  {
    if ($api_id != null) {
      $this->apiConstruct($api_id);
    }
  }

  public function apiConstruct($api_id)
  {
    $this->api_id = $api_id;
    $api = DB::table('billing_domain_api')->where('id', $this->api_id)->first();
    $api_data = json_decode($api->data, true);

    $this->key     = new APIKey($api_data['email'], $api_data['key']);
    $this->adapter = new Guzzle($this->key);
    $this->dns = new DNS($this->adapter);
    $this->zoneID = $api_data['zone_id'];
    $this->domain = $api->domain;
  }

  public static function getAllSubDomain()
  {
    $subdomain = DB::table('billing_subdomain')->get();
    if (!empty($subdomain)) {
      $resp = [];
      foreach ($subdomain as $key => $value) {
        $resp[$key] = $value;
        if (!empty($value->data)) {
          $resp[$key]->data = json_decode($value->data, true);
        }
      }
      return $resp;
    }
  }

  public function getList()
  {
    return $this->dns->listRecords($this->zoneID)->result;
  }

  public function getDataWhereName($name)
  {
    $data = $this->dns->listRecords($this->zoneID, '', $name)->result;
    if (!empty($data)) {
      return end($data);
    }
    return false;
  }


  public function getInvoiceSubDomain($invoice_id)
  {
    $sub = DB::table('billing_subdomain')->where('invoice_id', $invoice_id)->first();
    if (!empty($sub)) {
      $sub->data = json_decode($sub->data);
      return $sub;
    }
  }

  public function getAPIs()
  {
    $apis = DB::table('billing_domain_api')->get();
    if (!empty($apis)) {
      $resp = [];
      foreach ($apis as $key => $value) {
        $resp[$key] = $value;
        if (!empty($value->data)) {
          $resp[$key]->data = json_decode($value->data, true);
        }
      }
      return $resp;
    }
  }

  public function getAPI($id)
  {
    return DB::table('billing_domain_api')->where('id', $id)->first();
  }

  public function updateOrCreateAPI($data)
  {
    $api = DB::table('billing_domain_api')->where('domain', $data['domain'])->first();
    if (!empty($api)) {
      DB::table('billing_domain_api')->where('domain', $data['domain'])->update(array(
        'type' => $data['type'],
        'domain' => $data['domain'],
        'data' => json_encode($data['data']),
      ));
    } else {
      DB::table('billing_domain_api')->insert(array(
        'type' => $data['type'],
        'domain' => $data['domain'],
        'data' => json_encode($data['data']),
      ));
    }
  }

  public function removeAPI($id)
  {
    DB::table('billing_domain_api')->where('id', $id)->delete();
  }

  public function updateOrCreateSub($a_name, $data)
  {
    $sub = DB::table('billing_subdomain')->where('a_name', $a_name)->first();
    if (!empty($sub)) {
      DB::table('billing_subdomain')->where('a_name', $a_name)->update(array(
        'type' => $data['type'],
        'api_id' => $data['api_id'],
        'invoice_id' => $data['invoice_id'],
        'a_name' => $data['a_name'],
        'srv_name' => $data['srv_name'],
        'data' => $data['data'],
      ));
    } else {
      DB::table('billing_subdomain')->insert(array(
        'type' => $data['type'],
        'api_id' => $data['api_id'],
        'invoice_id' => $data['invoice_id'],
        'a_name' => $data['a_name'],
        'srv_name' => $data['srv_name'],
        'data' => $data['data'],
      ));
    }
  }


  public function createSRV($sub_domain, $server_ip, $server_port, $invoice_id)
  {
    $srvdata = array(
      "service" => "_minecraft",
      "proto" => "_tcp",
      "name" => $sub_domain,
      "weight" => 0,
      "port" => $server_port,
      "priority" => 0,
      "target" => $sub_domain . '.' . $this->domain
    );

    $srv_name = $srvdata['service'] . '.' . $srvdata['proto'] . '.' . $srvdata['target'];
    $a_name = $srvdata['target'];

    if (empty($this->dns->listRecords($this->zoneID, 'A', $srvdata['target'])->result)) {
      $this->dns->addRecord($this->zoneID, 'A', $sub_domain, $server_ip);
      if ($this->dns->addRecord($this->zoneID, "SRV", '', '', 0, false, '', $srvdata) === true) {

        $srvdata['server_ip'] = $server_ip;
        $db_data = [
          'type' => 'cloudflare',
          'api_id' => $this->api_id,
          'invoice_id' => $invoice_id,
          'a_name' => $a_name,
          'srv_name' => $srv_name,
          'data' => json_encode($srvdata)
        ];
        $this->updateOrCreateSub($a_name, $db_data);
        return redirect()->route('billing.cart')->with('success', 'Subdomain created: ' . $srvdata['target']);
      }
    }
    return redirect()->back()->withErrors('This domain is already in use, please try another.');
  }

  public function remove($subdomain_id)
  {
    $sub = DB::table('billing_subdomain')->where('id', $subdomain_id)->first();
    if (empty($sub)) {
      return false;
    }
    $this->apiConstruct($sub->api_id);
    $a_data = $this->getDataWhereName($sub->a_name);
    $srv_data = $this->getDataWhereName($sub->srv_name);
    if ($this->dns->deleteRecord($this->zoneID, $a_data->id)) {
      $this->dns->deleteRecord($this->zoneID, $srv_data->id);
      DB::table('billing_subdomain')->where('id', $subdomain_id)->delete();
      return true;
    }
  }
}
