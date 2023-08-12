<?php

namespace Pterodactyl\Models\Billing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Pterodactyl\Models\Billing\BillingTicketResponses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BillingTickets extends Model
{
  use HasFactory;

  public function createTicket($subject, $service, $status, $priority, $response)
  {

    // Lets create the ticket
    $ticket = new BillingTickets;
    $ticket->user_id = Auth::user()->id;
    $ticket->uuid = Str::random(8);
    $ticket->subject = $subject;
    $ticket->service = $service;
    $ticket->status = $status;
    $ticket->priority = $priority;
    $ticket->save();

    // Lets add the first response to the ticket
    Bill::tickets()->response()->new($ticket->uuid, $response);

    return $ticket;
  }

  public function response()
  {
    return new BillingTicketResponses;
  }
  
}