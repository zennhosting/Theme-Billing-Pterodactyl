<?php

namespace Pterodactyl\Models\Billing\Logs;

use Illuminate\Support\Facades\Auth;
use Pterodactyl\Models\Billing\Bill;
use Mail;


class BillingMailer
{

  // Application Variables
  protected $app_name;
  protected $receiver;
  protected $sender;
  protected $sender_name;

  // User Variables
  protected $username;
  protected $user_email;

  /**
   * Mail constructor.
   */
  public function __construct()
  {
    $this->app_name = config('app.name');
    $this->sender = config('mail.from.address');
    $this->sender_name = config('mail.from.name');

    $this->username = Auth::user()->username;
    $this->user_email = Auth::user()->email;
  }

  public function Plans($intro, $outro, $button_name, $button_url)
  {
    if (config('billing.emails')) {
      $data = array(
        'name' => $this->username,
        'intro' => $intro,
        'outro' => $outro,
        'button_name' => $button_name,
        'button_url' => $button_url,
      );

      try {
        Mail::send('templates.Carbon.emails.mail', $data, function ($message) {
          $message->to($this->user_email, $this->username)->subject(config('mail.from.name'));

          $message->from($this->sender, $this->sender_name);
        });
      } catch (\Throwable $th) {
        //throw $th;
      }
    }
  }

  public function EmailUser($receiver, $name, $intro, $outro, $button_name, $button_url)
  {
    $this->receiver = $receiver;
    $this->name = $name;

    $data = array(
      'name' => $name,
      'intro' => $intro,
      'outro' => $outro,
      'button_name' => $button_name,
      'button_url' => $button_url,
    );

    try {
      Mail::send('templates.Carbon.emails.mail', $data, function ($message) {
        $message->to($this->receiver, $this->name)->subject(config('mail.from.name'));

        $message->from($this->sender, $this->sender_name);
      });
    } catch (\Throwable $th) {
      //throw $th;
    }
  }

  public function EmailAllUsers($subject, $intro, $outro, $button_name, $button_url)
  {

    foreach (Bill::users()->getAllUsers() as $user) {

      if (isset($user['ptero']['email'])) {
        $this->receiver = $user['ptero']['email'];
        $this->name = $user['ptero']['name'];
        $this->subject = $subject;

        $data = array(
          'name' => $this->name,
          'intro' => $intro,
          'outro' => $outro,
          'button_name' => $button_name,
          'button_url' => $button_url,
        );

        Mail::send('templates.Carbon.emails.mail', $data, function ($message) {
          $message->to($this->receiver, $this->name)->subject($this->subject);

          $message->from($this->sender, $this->sender_name);
        });
      }
    }
  }
}
