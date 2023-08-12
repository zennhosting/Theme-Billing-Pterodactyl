<?php

namespace Pterodactyl\Models\Billing\PteroAPI\Client\Server;

use GuzzleHttp\Client;

class Network 
{
  public function __construct($key, $url)
  {
    $this->key = $key;
    $this->url = $url;
    $this->client = new Client([
      'base_uri'    => $this->url,
      'http_errors' => false,
      'headers'     => [
        'Accept'       => 'application/json',
        'Content-Type' => 'application/json',
        'Authorization' => "Bearer {$this->key}",
      ],
    ]);
  }

  public function set($server_identifier, int $allocation_id, $params)
  {
    return $this->client->post('api/client/servers/'. $server_identifier .'/network/allocations/' . $allocation_id, 
      array('form_params' => $params)
    );
  }
}