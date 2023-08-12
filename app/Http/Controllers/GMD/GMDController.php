<?php

namespace Pterodactyl\Http\Controllers\GMD;

use Pterodactyl\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;


class GMDController extends Controller
{
  public function __construct(Request $request)
  {
    $this->request = $request;
  }

  public function admin()
  {
    return view('templates.gmd.admin.core', ['templates_list' => $this->getTemplates()]);
  }

  public function toggleMode()
  {
    if (Auth::check()) {
      if (!Cache::has('dark_mode' . Auth::user()->id)) {
        Cache::put('dark_mode' . Auth::user()->id, true);
        return redirect()->back();
      }
      if (Cache::get('dark_mode' . Auth::user()->id)) {
        $mode = false;
      } else {
        $mode = true;
      }
      Cache::put('dark_mode' . Auth::user()->id, $mode);
    }
    return redirect()->back();
  }

  public function setTemplate()
  {
    Cache::put('active_template', $this->request->input('set_template'));
    return redirect()->back();
  }

  public function getTemplates()
  {
    $result = array();
    foreach (File::directories(base_path() . '/resources/views/templates') as $template) {
      if (!ctype_lower(basename($template)['0'])) {
        array_push($result, basename($template));
      }
    }
    return $result;
  }
}
