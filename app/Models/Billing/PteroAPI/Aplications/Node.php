<?php

namespace Pterodactyl\Models\Billing\PteroAPI\Aplications;

use GuzzleHttp\Client;

class Node 
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
		$resp = $this->client->get('api/application/nodes');
		return json_decode($resp->getBody()->getContents(), true);
	}

	public function get(int $id)
	{
		$resp = $this->client->get('api/application/nodes/' . $id);
		return json_decode($resp->getBody()->getContents(), true);
	}

	public function getConf(int $id)
	{
		$resp = $this->client->get('api/application/nodes/' . $id . '/configuration');
		return json_decode($resp->getBody()->getContents(), true);
	}

	// public function create(int $id, array $params)
	// {
	// 	$resp = $this->client->post(
	// 		'api/application/nodes/'. $id .'/allocations', 
	// 		array('form_params' => $params)
	// 	);
	// 	return $resp->getStatusCode();
	// }

	// public function delete(int $id, int $alloc_id)
	// {
	// 	$resp = $this->client->delete('api/application/nodes/'. $id .'/allocations/' . $alloc_id);
	// 	return json_decode($resp->getBody()->getContents(), true);
	// }
}