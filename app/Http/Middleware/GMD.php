<?php

namespace Pterodactyl\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class GMD
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    $this->darkMode($request);
    $this->templatePath($request);
    return $next($request);
  }

  private function darkMode(Request $request)
  {
    if (Auth::check()) {
      if (!Cache::has('dark_mode' . Auth::user()->id)) {
        Cache::put('dark_mode' . Auth::user()->id, true);
      }
      $dark_mode = Cache::get('dark_mode' . Auth::user()->id);
      $request->merge(compact('dark_mode'));  //set global request variable dd($request->dark_mode);
      view()->share('dark_mode', $dark_mode);  //set global blade variable @dd($dark_mode)
    }
  }

  private function templatePath(Request $request)
  {
    if (!Cache::has('active_template')) {
      Cache::put('active_template', 'Carbon');
    }
    $template = Cache::get('active_template');
    $request->merge(compact('template'));
    view()->share('template', $template);
  }
}
