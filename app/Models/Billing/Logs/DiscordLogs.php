<?php

namespace Pterodactyl\Models\Billing\Logs;

use Pterodactyl\Models\Billing\Bill;
use Illuminate\Support\Facades\Auth;


class DiscordLogs
{

  public function webhook($title, $description, $url, $name1, $value1, $name2, $value2)
  {

    $webkey = "";

    $timestamp = date("c", strtotime("now"));

    $json_data = json_encode([
      // Message
      "content" => $title,

      // Embeds Array
      "embeds" => [
        [
          // Embed Title
          "title" => $title,

          // Embed Type
          "type" => "rich",

          // Embed Description
          "description" => $description,

          // URL of title link
          "url" => $url,

          // Timestamp of embed must be formatted as ISO8601
          "timestamp" => $timestamp,

          // Embed left border color in HEX
          "color" => hexdec("3366ff"),


          // Additional Fields array
          "fields" => [

            // Field 1
            [
              "name" => $name1,
              "value" => $value1,
              "inline" => false
            ],

            // Field 2
            [
              "name" => $name2,
              "value" => $value2,
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

  public function SendWebLog()
  {
      return;
  }
}
