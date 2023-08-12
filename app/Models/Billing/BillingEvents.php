<?php

namespace Pterodactyl\Models\Billing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Bill;

class BillingEvents extends Model
{
  use HasFactory;

    /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'billing_events';

  public static function create($section, $user_id, $event_name, $description)
  {
    $event = new BillingEvents;
    $event->section = $section;
    $event->user_id = $user_id;
    $event->event = $event_name;
    $event->description = $description;
    // add other fields
    $event->save();

    $DiscordEvent = Bill::settings()->where('name', 'discord_events')->first();
    if(isset($DiscordEvent->data)) {
      if($DiscordEvent->data == "true") {
        BillingEvents::SendDiscordWebhook($section, $user_id, $event_name, $description);
      }
    }

    return true;
  }

  private static function SendDiscordWebhook($section, $user_id, $event_name, $description)
  {

    if($user_id) {
      $user = Auth::user()->find($user_id);
      $username = $user->username.' ('.$user->email.')';
    } else {
      $username = 'N/A';
    }

    $DiscordWebhook = Bill::settings()->where('name', 'discord_events_webhook')->first();
    if(isset($DiscordWebhook->data)) {
      $webkey = $DiscordWebhook->data;
    }

    $timestamp = date("c", strtotime("now"));

    $json_data = json_encode([

      // Embeds Array
      "embeds" => [
        [
          // Embed Title
          "title" => 'Billing Event Manager has logged new activity.',

          // Embed Type
          "type" => "rich",

          // Embed Description
          "description" => $description,

          // URL of title link
          "url" => config('app.url'),

          // Timestamp of embed must be formatted as ISO8601
          "timestamp" => $timestamp,

          // Embed left border color in HEX
          "color" => hexdec("fd5945"),


          // Additional Fields array
          "fields" => [

            // Field 1
            [
              "name" => 'Event Section',
              "value" => $section,
              "inline" => false
            ],

            // Field 2
            [
              "name" => 'User',
              "value" => $username,
              "inline" => false
            ],

            // Field 3
            [
              "name" => 'Event Trigger',
              "value" => $event_name,
              "inline" => false
            ],

            // Field 4
            [
              "name" => 'Description',
              "value" => $description,
              "inline" => false
            ],
            // Etc..
          ]
        ]
      ]

    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);


    $ch = curl_init($webkey);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);
    // If you need to debug, or find out why you can't send message uncomment line below, and execute script.
    // echo $response;
    curl_close($ch);
  }

}
