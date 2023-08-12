<?php

namespace Pterodactyl\Models\Billing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class BLang extends Model
{

  public static function path()
  {
    return app_path() . DIRECTORY_SEPARATOR . 'Models' . DIRECTORY_SEPARATOR . 'Billing' . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR;
  }
  public static function getActiveLang()
  {
    if (self::getUser() != false) {
      return $lang = self::getUser();
    }
    if (!empty(config('billing.language'))) {
      $lang = config('billing.language');
    } else {
      $lang = 'us';
    }
    return $lang;
  }

  public static function getDefault($key)
  {
    $term = require self::path() . 'us.php';
    if (isset($term[$key])) {
      return $term[$key];
    } else {
      return  'Undefined key: ' . $key;
    }
  }

  public static function get($key)
  {

    $lang = self::getActiveLang();
    $term = require self::path() . $lang . '.php';

    if (file_exists(self::path() . $lang . '.php')) {
      if (isset($term[$key])) {
        return $term[$key];
      } else {
        return self::getDefault($key);
      }
    } else {
      return self::getDefault($key);
    }
  }

  public static function getUser()
  {
    if (!Auth::guest()) {
      if (Cache::has('billinguserlang' . Auth::user()->id)) {
        return Cache::get('billinguserlang' . Auth::user()->id);;
      }
    } else {
      if (isset($_COOKIE['billing_lang'])) {
        return $_COOKIE['billing_lang'];
      } else {
        return 'us';
      }
    }
  }

  public static function getAll()
  {
    $langs = scandir(self::path());
    $language = array();
    foreach ($langs as $lang) {
      if ($lang == '..' or $lang == '.') {
        continue;
      }
      $language[basename($lang, '.php')] = strtoupper(basename($lang, '.php'));
    }
    return $language;
  }
}
