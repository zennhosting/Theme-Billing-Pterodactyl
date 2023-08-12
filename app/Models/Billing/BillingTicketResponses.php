<?php

namespace Pterodactyl\Models\Billing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BillingTicketResponses extends Model
{
  use HasFactory;

  public function new($uuid, $response)
  {
    // create response in DB
    $TicketResponse = new BillingTicketResponses;
    $TicketResponse->user_id = Auth::user()->id;
    $TicketResponse->uuid = $uuid;
    $TicketResponse->response = $response;
    $TicketResponse->save();

    // update the updated_at in db for ticket
    $ticket = Bill::tickets()->where('uuid', $uuid)->first();
    $ticket->updated_at = Carbon::now();
    $ticket->save();

    return $response;
  }
  
}
