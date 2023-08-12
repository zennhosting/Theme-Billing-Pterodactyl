<?php

namespace Pterodactyl\Models\Billing\PteroAPI\Aplications;

use GuzzleHttp\Client;

class Eggs
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

    public function getAll(int $nest_id)
	{
		$resp = $this->client->get('api/application/nests/' . $nest_id . '/eggs?include=nest,servers,variables');
		return json_decode($resp->getBody()->getContents(), true);
	}

	public function get(int $nest_id , int $id)
	{
		$resp = $this->client->get('api/application/nests/'. $nest_id . '/eggs/' . $id . '?include=variables');
		return json_decode($resp->getBody()->getContents(), true);
	}
}