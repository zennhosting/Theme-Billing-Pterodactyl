<?php

namespace Pterodactyl\Http\Controllers\Billing;

use Exception;
use Pterodactyl\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Bill;

class PortalController extends Controller
{

  public function __construct(Request $request)
  {
    $this->request = $request;

    if (config('billing.portal') !== "true") {
      header("Location: /auth/login");
    }
  }

  private function getTemplate()
  {
    return $this->request->template;
  }

  public function portal()
  {
    return view('templates.' . $this->getTemplate() . '.portal.index', ['games' => Bill::games()->get(), 'settings' => Bill::settings()->getAll()]);
  }

  public function plans($game_type)
  {
    $games = Bill::games()->get();
    $game = Bill::games()->where('link', $game_type)->first();
    $plans = Bill::plans();
    try {
      $plans = $plans->where('game_id', $game->id)->get();
    } catch (Exception $e) {
      return redirect()->back()->withErrors(Bill::lang()->get('err_plans_in_game'));
    }

    return view('templates.' . $this->getTemplate() . '.portal.plans', ['plans' => $plans, 'games' => $games, 'game' => $game, 'settings' => Bill::settings()->getAll()]);
  }
}
