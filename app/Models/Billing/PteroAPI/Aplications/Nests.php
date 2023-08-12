<?php

namespace Pterodactyl\Models\Billing\PteroAPI\Aplications;

use GuzzleHttp\Client;

class Nests
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
		$resp = $this->client->get('api/application/nests');
		return json_decode($resp->getBody()->getContents(), true);
	}

	public function get(int $id)
	{
		$resp = $this->client->get('api/application/nests/' . $id);
		return json_decode($resp->getBody()->getContents(), true);
	}
}