<?php

namespace Pterodactyl\Models\Plugins;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class PluginsModule extends Model
{

  // return all categories (array)
  public static function getPluginsCategories()
  {
    $REQUEST_URL = "https://api.spiget.org/v2/categories?size=100";
    $response    = file_get_contents($REQUEST_URL, false);
    $data = json_decode($response, true);
    return $data;
  }

  // Param: $category_id - (int), $options - example array('size' => 50, 'page' => 2)
  // return array
  public static function getPluginsInCategory($server, $category_id, $options = NULL)
  {

    if ($options != NULL) {
      $options_str = '?sort=-downloads';
      foreach ($options as $key => $value) {
        $options_str = $options_str . '&' . $key . '=' . $value;
      }
    } else {
      $options_str = '';
    }
    $REQUEST_URL = "https://api.spiget.org/v2/categories/{$category_id}/resources{$options_str}";
    $response    = file_get_contents($REQUEST_URL, false);
    $data = json_decode($response, true);

    return $data;
  }

  // Param: $options - example array('size' => 50, 'page' => 2)
  // return array
  public static function getAllPlugins($options = NULL)
  {
    if ($options != NULL) {
      $options_str = '?sort=-downloads';
      foreach ($options as $key => $value) {
        $options_str = $options_str . '&' . $key . '=' . $value;
      }
    } else {
      $options_str = '';
    }
    $REQUEST_URL = "https://api.spiget.org/v2/resources{$options_str}";
    $response    = file_get_contents($REQUEST_URL, false);
    $data = json_decode($response, true);
    return $data;
  }

  public static function getPluginData($pl_id)
  {
    $REQUEST_URL = "https://api.spiget.org/v2/resources/{$pl_id}";
    $response    = file_get_contents($REQUEST_URL, false);
    $data = json_decode($response, true);
    return $data;
  }

  public static function search($find, $p = 1)
  {
    $REQUEST_URL = "https://api.spiget.org/v2/search/resources/{$find}?size=21&sort=-downloads&page={$p}";
    try {
      $response    = file_get_contents($REQUEST_URL, false);
      $data = json_decode($response, true);
    } catch (\Throwable $th) {
      $data = self::getAllPlugins();
      $data['error'] = $find . ' plugin not found';
    }

    return $data;
  }

  // return server upload url
  public static function getUpURL($server)
  {

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => config('app.url') . '/api/client/servers/' . $server . '/files/upload',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_COOKIE => 'pterodactyl_session=' . $_COOKIE['pterodactyl_session'],
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      $response = json_decode($response);
      return $response->attributes->url;
    }
  }

  // save plugin
  public static function installPlugin($server, $pl_id, $file_name)
  {
    $file_path =  self::getPluginURL($file_name, $pl_id);
    $path_parts = pathinfo($file_path);
    $pl_name = preg_replace("/\[[^\]]*\]/", '', $file_name);
    $pl_name = preg_replace("/[0-9]/", "",  $pl_name);
    $pl_name = explode('(', $pl_name);
    $order   = array(" ", "!", ",", ".", "[", "]", "|", "-", "_", "=", "(", ")");
    $pl_name = str_replace($order, '', $pl_name['0']);
    $pl_name = substr($pl_name, 0, 25);
    $file_name = $pl_name . '.' . $path_parts['extension'];

    $url = self::getUpURL($server) . '&directory=/plugins/';
    $headers = [
      "Accept: application/json",
      "Content-Type: multipart/form-data",
    ];

    $fields = [
      'files' => new \CurlFile($file_path, '', $file_name),
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_exec($ch);
    curl_error($ch);
    self::saveDB($server, $pl_id, $pl_name, 0);
  }

  public static function getPluginURL($file_name, $pl_id)
  {
    $other_plugins = [
      'ServerUtils' => 'https://serverutils.fvdh.dev/api/v1/Bukkit'
    ];
    foreach ($other_plugins as $key => $value) {
      if (str_contains($file_name, $key)) {
        if ($key == 'ServerUtils') {
          $data = Http::get($value)->json();
          array_pop(($data['error']['extra']['possibleValues']));
          $ver = end($data['error']['extra']['possibleValues']);
          $value = "https://repo.fvdh.dev/releases/net/frankheijden/serverutils/ServerUtils-Bukkit/{$ver}/ServerUtils-Bukkit-{$ver}.jar";
        }
        return $value;
      }
    }

    return self::getFileUrl($pl_id);
  }


  public static function getFileUrl($id)
  {
    $host = "https://api.spiget.org/v2/resources/{$id}/download";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $host);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, false);
    curl_setopt($ch, CURLOPT_REFERER, "https://vartisanpro.com");
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    $result = explode('g to ', $result);
    $result = trim($result['1']);
    return $result;
  }

  public static function saveDB($server, $pl_id, $pl_name, $autoupdate = 0)
  {
    $pl = self::getPluginData($pl_id);
    if (empty($db = PluginsModule::where('server', $server)->where('pl_id', $pl_id)->first())) {
      $db = new PluginsModule;
    }
    $db->server = $server;
    $db->name = $pl_name;
    $db->pl_id = $pl_id;
    $db->ver_id = $pl['version']['id'];
    // $db->autoupdate = $autoupdate;
    $db->save();
  }

  public static function getInstalled($server)
  {
    $pls = self::where('server', $server)->orderBy('created_at', 'desc')->get();
    $resp = [];
    foreach ($pls as $key => $pl) {
      $resp[$pl->pl_id] = $pl->attributesToArray();
    }
    return $resp;
  }

  // return true/false
  public static function isMinecraft($server = '')
  {
    if (!empty($server)) {
      $server = DB::table('servers')->where('uuidShort', $server)->first();
      if (!empty($server)) {
        $nest = DB::table('nests')->find($server->nest_id);
        if ($nest->name == 'Minecraft') {
          return true;
        }
      }
    }
    return false;
  }

  public static function installed($server)
  {
    $installed = self::getInstalled($server);
    $data = [];
    foreach ($installed as $key => $plugin) {
      $data[$plugin['id']]['inst'] = $plugin;
      $data[$plugin['id']]['spigot'] = self::getPluginData($plugin['pl_id']);
    }
    return $data;
  }

  public static function getPluginsAutoupdate()
  {
    return self::where('autoupdate', 1)->get();
  }
}
