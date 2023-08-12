<?php

namespace Pterodactyl\Models\Billing\PteroAPI;

use Pterodactyl\Models\Billing\PteroAPI\Aplications\Servers;
use Pterodactyl\Models\Billing\PteroAPI\Aplications\Locations;
use Pterodactyl\Models\Billing\PteroAPI\Aplications\Allocations;
use Pterodactyl\Models\Billing\PteroAPI\Aplications\Users;
use Pterodactyl\Models\Billing\PteroAPI\Aplications\Databases;
use Pterodactyl\Models\Billing\PteroAPI\Aplications\Nests;
use Pterodactyl\Models\Billing\PteroAPI\Aplications\Eggs;
use Pterodactyl\Models\Billing\PteroAPI\Aplications\Node;

use Pterodactyl\Models\Billing\PteroAPI\Client\Server\Network;

class PteroAPI
{
  public $api;
  public $url;

  public $servers;
  public $locations;
  public $allocations;
  public $users;
  public $databases;
  public $nests;
  public $eggs;
	public $node;

  public $network;

  public function __construct($api_key, $base_url)
  {

    $this->api = $api_key;
    $this->url = $base_url;

    $this->servers = new Servers($this->api, $this->url);
    $this->locations = new Locations($this->api, $this->url);
    $this->allocations = new Allocations($this->api, $this->url);
    $this->users = new Users($this->api, $this->url);
    $this->databases = new Databases($this->api, $this->url);
    $this->nests = new Nests($this->api, $this->url);
    $this->eggs = new Eggs($this->api, $this->url);
		$this->node = new Node($this->api, $this->url);

    $this->network = new Network($this->api, $this->url);
  }
}
