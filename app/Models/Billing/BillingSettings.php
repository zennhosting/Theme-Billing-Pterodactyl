<?php

namespace Pterodactyl\Models\Billing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

use Bill;

class BillingSettings extends Model
{
  use HasFactory;
  protected $fillable = ['name', 'type', 'data'];
  protected $table = 'billing_settings';

  public static function getAll()
  {
    $settings = array();
    if (count(self::get())) {
      foreach (self::get() as $value) {
        if (isset($value->name)) {
          $settings[$value->name] = $value->data;
        }
      }
    }
    return $settings;
  }

  public static function getParam($param)
  {
    $settings = self::where('name', $param)->first();
    if (!empty($settings->data)) {
      return $settings->data;
    } else {
      return '';
    }
  }

  public function setSetting(Request $request)
  {

    foreach ($request->input() as $key => $value) {
      self::updateOrCreate(
        [
          'name'   => $key,
        ],
        [
          'name' => $key,
          'data' => $value
        ],
      );
    }
    return redirect()->back();
  }

  public static function scheduler()
  {
    if (!Cache::has('bill_scheduler')) {
      $dt = date("Y-m-d");
      $invoices = Bill::invoices()->where('due_date', '<', $dt)->get();
      if (!empty($invoices)) {
        
        foreach ($invoices as $invoice) {
          DB::table('servers')->where('id', $invoice->server_id)->update(['status' => 'suspended']);
          $invoice = Bill::invoices()->find($invoice->id);
          $invoice->status = 'Unpaid';
          $invoice->save();
        }

        Bill::events()->create('global', false, 'schedular:run', 'Schedular was executed.');

      }

      if (self::getParam('remove_suspendet') == "true") {
        $date = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s") . " - 10 day"));
        $invoices = Bill::invoices()->whereDate('updated_at', '<=', $date)->where('status', '=', 'Unpaid')->get();
        foreach ($invoices as $value) {
          Bill::servers()->remove($value->attributes['server_id']);
          Bill::invoices()->find($value->attributes['id'])->delete();
        }
      }
      Cache::put('bill_scheduler', date('H:i:s Y-m-d'), now()->addMinutes(500));
    }
    return 'done';
  }

  public static function forceScheduler()
  {
    if (Cache::has('bill_scheduler')) {
      Cache::forget('billing');
      Cache::forget('bill_scheduler');
      Bill::settings()->scheduler();
    }
    
    Bill::events()->create('admin', Auth::user()->id, 'schedular:force:run', 'Schedular was force-ran by an Admin user.');

    return true;
  }

  public static function getCustomPages()
  {
    return Bill::pages()->get();
  }

  public static function updateFaq(array $faq)
  {
    foreach ($faq as $key => $value) {
      if (empty($value['title'])) {
        unset($faq[$key]);
      }
    }
    self::updateOrCreate(
      [
        'name'   => 'faq_content',
      ],
      [
        'name' => 'faq_content',
        'data' => json_encode($faq)
      ],
    );
  }

  public static function getFaqs()
  {
    return json_decode(self::getParam('faq_content'), true);
  }

  public static function updateTeam(array $teams)
  {
    foreach ($teams as $key => $value) {
      if (empty($value['name'])) {
        unset($teams[$key]);
      }
    }
    self::updateOrCreate(
      [
        'name'   => 'team_content',
      ],
      [
        'name' => 'team_content',
        'data' => json_encode($teams)
      ],
    );
  }

  public static function getTeams()
  {
    return json_decode(self::getParam('team_content'), true);
  }
}
