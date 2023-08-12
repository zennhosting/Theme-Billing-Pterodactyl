<?php

namespace Pterodactyl\Models\Billing\PteroAPI\Aplications;

use GuzzleHttp\Client;

class Servers
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

  public function getAll()
  {
    $resp = $this->client->get('api/application/servers');
    return json_decode($resp->getBody()->getContents(), true);
  }

  public function get(int $id)
  {
    $resp = $this->client->get('api/application/servers/' . $id);
    return json_decode($resp->getBody()->getContents(), true);
  }

  public function getExternal($id)
  {
    $resp = $this->client->get('api/application/servers/external/' . $id);
    return json_decode($resp->getBody()->getContents(), true);
  }

  public function create(array $params)
  {
    $resp = $this->client->post(
      'api/application/servers', 
      array('form_params' => $params)
    );
    return json_decode($resp->getBody()->getContents(), true);
  }

  public function unsuspend(int $id)
  {
    $resp = $this->client->post(
      'api/application/servers/' . $id . '/unsuspend'
    );
    return json_decode($resp->getBody()->getContents(), true);
  }

  public function suspend(int $id)
  {
    $resp = $this->client->post(
      'api/application/servers/' . $id . '/suspend'
    );
    return json_decode($resp->getBody()->getContents(), true);
  }

  public function delete(int $id)
  {
    $resp = $this->client->delete(
      'api/application/servers/' . $id
    );
    return json_decode($resp->getBody()->getContents(), true);
  }

  public function forceDelete(int $id)
  {
    $resp = $this->client->delete(
      'api/application/servers/' . $id . '/force'
    );
    return json_decode($resp->getBody()->getContents(), true);
  }
  
}
