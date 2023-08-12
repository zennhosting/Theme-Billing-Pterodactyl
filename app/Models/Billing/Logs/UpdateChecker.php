<?php

namespace Pterodactyl\Models\Billing\Logs;

use Pterodactyl\Models\Billing\Bill;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;


class UpdateChecker
{

  /**
   * This file checks for any new updates or security hotfixes.
   */

  /**
   * CheckUpdate constructor.
   */

  private $key;
  private $app;
  private $url;
  private $update;

  public function __construct()
  {
    $this->key = Bill::settings()->getParam('license_key');
    $this->app = parse_url(config('app.url'))['host'];
  }

public function update()
{
    if (!Cache::has('bill')) {
        $upd = false;
        if (\Route::is('admin.update')) {
            return;
        }

    if ($upd) {
        return redirect()->to('/billing/admin/update')->send();
    } else {
        Cache::put('bill', 'update', now()->addMinutes(120));
    }
    }

}

  public function getData()
  {
    return;
  }
}
