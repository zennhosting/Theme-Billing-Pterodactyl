<?php

namespace Pterodactyl\Models\Billing\PteroAPI\Aplications;

use GuzzleHttp\Client;

class Users
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
}