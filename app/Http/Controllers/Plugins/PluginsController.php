<?php

namespace Pterodactyl\Http\Controllers\Plugins;

use Pterodactyl\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Pterodactyl\Models\Billing\BillingSettings;
use Pterodactyl\Models\Billing\BillingUsers;
use Illuminate\Support\Facades\Auth;
use Pterodactyl\Models\Plugins\PluginsModule;
use Pterodactyl\Models\Plugins\ServerCore;
use Illuminate\Support\Facades\Cache;

class PluginsController extends Controller
{

  public function __construct(Request $request)
  {
    $this->request = $request;
    BillingSettings::scheduler();
  }

  private function getTemplate()
  {
    return $this->request->template;
  }

  public static function isPerms($server)
  {
    $uServers = BillingUsers::getUserServersData(Auth::user()->id);

    if (!isset($uServers[$server])) {
      return false;
    }
    return true;
  }

  public function index($server, $p = 1)
  {
    if (!self::isPerms($server)) {
      return redirect()->back();
    }
    if (!$this->serverChek()) {
      return redirect()->to('/');
    }
    $data = PluginsModule::getAllPlugins(array('size' => 21, 'page' => $p));
    if (empty($data)) {
      return view('templates/' . $this->getTemplate() . '/plugins.error', ['template' => $this->getTemplate()]);
    }

    $data = [
      'page' => 'plugins',
      'categories' => PluginsModule::getPluginsCategories(),
      'plugins' => $data,
      'server' => $server,
      'server_name' => \DB::table('servers')->where('uuidShort', $server)->first()->name,
      'p' => $p,
      'url' => "/server/{$server}/plugins/",
      'app_url' => config('app.url'),
      'template' => $this->getTemplate()
    ];
    return view('templates/' . $this->getTemplate() . '/plugins.core', $data);
  }
  public function category($server, $id, $p = 1)
  {
    if (!$this->serverChek()) {
      return redirect()->to('/');
    }
    $data = PluginsModule::getPluginsInCategory($server, $id, array('size' => 21, 'page' => $p));
    if (empty($data)) {
      return view('templates/' . $this->getTemplate() . '/plugins.error', ['template' => $this->getTemplate()]);
    }

    $data = [
      'page' => 'categories',
      'categories' => PluginsModule::getPluginsCategories(),
      'plugins' => $data,
      'server' => $server,
      'server_name' => \DB::table('servers')->where('uuidShort', $server)->first()->name,
      'p' => $p,
      'url' => "/server/{$server}/plugins/category/{$id}/",
      'app_url' => config('app.url'),
      'template' => $this->getTemplate()
    ];
    return view('templates/' . $this->getTemplate() . '/plugins.core', $data);
  }
  public function search($server, $find, $p)
  {
    if (!$this->serverChek()) {
      return redirect()->to('/');
    }
    $data = PluginsModule::search($find, $p);
    if (empty($data)) {
      return redirect()->back();
    }
    $data = [
      'page' => 'search',
      'categories' => PluginsModule::getPluginsCategories(),
      'plugins' => $data,
      'server' => $server,
      'server_name' => \DB::table('servers')->where('uuidShort', $server)->first()->name,
      'p' => $p,
      'url' => "/server/{$server}/plugins/search/{$find}/",
      'app_url' => config('app.url'),
      'template' => $this->getTemplate()
    ];
    return view('templates/' . $this->getTemplate() . '/plugins.core', $data);
  }

  public function installed($server)
  {
    if (!$this->serverChek()) {
      return redirect()->to('/');
    }
    $plugins = PluginsModule::installed($server);
    $data = [
      'page' => 'instsalled',
      'categories' => PluginsModule::getPluginsCategories(),
      'server' => $server,
      'server_name' => \DB::table('servers')->where('uuidShort', $server)->first()->name,
      'plugins' => $plugins,
      'url' => "/server/{$server}/plugins/",
      'app_url' => config('app.url'),
      'template' => $this->getTemplate()
    ];
    return view('templates/' . $this->getTemplate() . '/plugins.installed', $data);
  }

  public function core($server)
  {
    if (!$this->serverChek()) {
      return redirect()->to('/');
    }
    $data = [
      'page' => 'serve_core',
      'server' => $server,
      'server_name' => \DB::table('servers')->where('uuidShort', $server)->first()->name,
      'core' => ServerCore::installed($server),
      'paper' => ServerCore::getPaperData(),
      'url' => "/server/{$server}/core/",
      'app_url' => config('app.url'),
      'template' => $this->getTemplate()
    ];
    return view('templates/' . $this->getTemplate() . '/plugins.server_core', $data);
  }

  public function setCore($server)
  {
    if (!$this->serverChek()) {
      return redirect()->to('/');
    }
    foreach (['project', 'version', 'name'] as $key => $value) {
      if (!isset($_POST[$value]) or empty($_POST[$value])) {
        return redirect()->back();
      }
    }
    ServerCore::installCore($server, $_POST['project'], $_POST['version'], $_POST['name'], $_POST['autoupdate']);
    return redirect()->back();
  }

  public function removeCore($server)
  {
    if (!$this->serverChek()) {
      return redirect()->to('/');
    }
    // $core = ServerCore::where('server', $server)->first();
    // ServerCore::removeCoreFile($server, $core->name);
    ServerCore::where('server', $server)->delete();
    return redirect()->back();
  }








  public function upload($server, $pl_id, $pl_mane)
  {
    PluginsModule::installPlugin($server, $pl_id, $pl_mane);
  }

  public function getUpURL($server)
  {
    return PluginsModule::getUpURL($server) . '&directory=/plugins';
  }

  public function plRemove($server, $pl_id)
  {
    PluginsModule::where('id', $pl_id)->delete();
  }

  public function serverChek()
  {
    if (url()->getRequest()->segment(1) == 'server') {
      if (PluginsModule::isMinecraft(url()->getRequest()->segment(2))) {
        return true;
      }
    }
    return false;
  }

  public function isMinecraft($server)
  {
    if (PluginsModule::isMinecraft($server)) {
      return response()->json(['resp' => true]);
    } else {
      return response()->json(['resp' => false]);
    }
  }










  // Plugin auto-update switch
  public function plAutoupdate($server, $pl_id)
  {
    $pl = PluginsModule::where('id', $pl_id)->first();
    if (!empty($pl)) {
      if ($pl->autoupdate == 1) {
        $pl->autoupdate = 0;
      } else {
        $pl->autoupdate = 1;
      }
      $pl->save();
      return true;
    }
    return false;
  }

  public function scheduler()
  {
    if (!Cache::has('pl_scheduler')) {
      $plugins = PluginsModule::getPluginsAutoupdate();
      foreach ($plugins as $key => $pl) {
        $spigot = PluginsModule::getPluginData($pl->pl_id);
        if ($spigot['version']['id'] > $pl->ver_id) {
          PluginsModule::installPlugin($pl->server, $pl->pl_id, $pl->name);
        }
      }
      ServerCore::autoupdate();
      Cache::put('pl_scheduler', 'scheduler', now()->addMinutes(60));
    }
  }
}
