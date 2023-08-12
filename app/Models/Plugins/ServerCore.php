<?php

namespace Pterodactyl\Models\Plugins;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class ServerCore extends Model
{
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
      $res = json_decode($response);
      if (isset($res->attributes)) {
        return $res->attributes->url;
      } else {
        dd($response);
      }
    }
  }

  public static function installCore($server, $core, $version, $file_name, $autoupdate = 1)
  {
    $file_path = self::getCoreUrl(trim($core), $version);

    $url = self::getUpURL($server) . '&directory=/';
    $headers = [
      "Accept: application/json",
      "Content-Type: multipart/form-data",
    ];

    $fields = [
      'files' => new \CurlFile($file_path, '', trim($file_name)),
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
    self::saveDB($server, $core, $version, $file_name, $autoupdate);
  }

  public static function saveDB($server, $core, $version, $file_name, $autoupdate = 0)
  {
    if (empty($db = ServerCore::where('server', $server)->first())) {
      $db = new ServerCore;
    }
    $db->server = $server;
    $db->name = $file_name;
    $db->core = $core;
    $db->version = $version;
    $db->autoupdate = $autoupdate;
    $db->save();
  }

  public static function getCoreUrl($core, $version)
  {
    $core = strtolower($core);
    switch ($core) {
      case 'paper':
        $builds = Http::get("https://api.papermc.io/v2/projects/{$core}/versions/{$version}/builds")->object();
        $build = end($builds->builds)->build;
        return "https://api.papermc.io/v2/projects/{$core}/versions/{$version}/builds/{$build}/downloads/{$core}-{$version}-{$build}.jar";
        break;
      case 'travertine':
        $builds = Http::get("https://api.papermc.io/v2/projects/{$core}/versions/{$version}/builds")->object();
        $build = end($builds->builds)->build;
        return "https://api.papermc.io/v2/projects/{$core}/versions/{$version}/builds/{$build}/downloads/{$core}-{$version}-{$build}.jar";
        break;
      case 'waterfall':
        $builds = Http::get("https://api.papermc.io/v2/projects/{$core}/versions/{$version}/builds")->object();
        $build = end($builds->builds)->build;
        return "https://api.papermc.io/v2/projects/{$core}/versions/{$version}/builds/{$build}/downloads/{$core}-{$version}-{$build}.jar";
        break;
      case 'velocity':
        $builds = Http::get("https://api.papermc.io/v2/projects/{$core}/versions/{$version}/builds")->object();
        $build = end($builds->builds)->build;
        return "https://api.papermc.io/v2/projects/{$core}/versions/{$version}/builds/{$build}/downloads/{$core}-{$version}-{$build}.jar";
        break;
    }
  }

  public static function getPaperPojects()
  {
    return Http::get("https://api.papermc.io/v2/projects")->object()->projects;
  }

  public static function getPaperPojectData($project)
  {
    return Http::get("https://api.papermc.io/v2/projects/{$project}")->object();
  }

  public static function getPaperData()
  {
    foreach (self::getPaperPojects() as $key => $project) {
      $data[$project] = self::getPaperPojectData($project)->versions;
    }
    return $data;
  }


  public static function installed($server)
  {
    $installed = self::where('server', $server)->first();
    return $installed;
  }

  public static function autoupdate()
  {
    $installed = self::where('autoupdate', 1)->get();
    foreach ($installed as $key => $value) {
      self::installCore($value->server, $value->core, $value->version, $value->name, 1);
    }
  }
}
