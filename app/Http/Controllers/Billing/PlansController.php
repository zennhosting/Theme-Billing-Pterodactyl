<?php

namespace Pterodactyl\Http\Controllers\Billing;

use Exception;
use Pterodactyl\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Bill;

class PlansController extends Controller
{

  public function __construct(Request $request)
  {
    $this->request = $request;
    Bill::settings()->scheduler();
  }

  private function getTemplate()
  {
    return $this->request->template;
  }

  public function getPlans($game_type)
  {
    $game = Bill::games()->where('link', $game_type)->first();
    $plans = Bill::plans();
    
    try {
      $plans = $plans->where('game_id', $game->id)->get();
    } catch (Exception $e) {
      return redirect()->back()->withErrors(Bill::lang()->get('err_plans_in_game'));
    }

    return view('templates.' . $this->getTemplate() . '.billing.plans', ['plans' => $plans, 'game' => $game, 'settings' => Bill::settings()->getAll()]);
  }

  public function configure($game_type) 
  {
    $game = Bill::games()->where('link', $game_type)->first();
    $plans = Bill::plans();
    try {
      $plans = $plans->where('game_id', $game->id)->get();
    } catch (Exception $e) {
      return redirect()->back()->withErrors(Bill::lang()->get('err_plans_in_game'));
    }

    return view('templates.' . $this->getTemplate() . '.billing.configure_plan', ['plans' => $plans, 'game' => $game, 'settings' => Bill::settings()->getAll()]);
  }
}
