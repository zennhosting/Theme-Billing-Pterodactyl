<?php

namespace Pterodactyl\Models\Billing\PteroAPI\Aplications;

use GuzzleHttp\Client;

class Locations 
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
		$resp = $this->client->get('api/application/locations');
		return json_decode($resp->getBody()->getContents(), true);
	}

	public function get(int $id)
	{
		return $this->client->get('api/application/locations/' . $id)->getStatusCode();
	}
}