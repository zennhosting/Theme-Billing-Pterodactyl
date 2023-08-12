<?php

namespace Pterodactyl\Http\Controllers\Billing;

use Pterodactyl\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Pterodactyl\Models\User;

use Bill;

class TicketsController extends Controller
{

  public function __construct(Request $request)
  {
    $this->request = $request;
    //dd(Bill::tickets()->response()->new('ajkdad', 'this is a test response'));
  }

  private function getTemplate()
  {
    return $this->request->template;
  }

  public function index()
  {
    $tickets = Bill::tickets()->where('user_id', Auth::user()->id)->get();

    return view('templates.' . $this->getTemplate() . '.billing.tickets.core', ['tickets' => $tickets,'settings' => Bill::settings()->getAll()]);
  }

  public function newTicket()
  {
    $billding_user = Bill::users()->getAuth();
    $invoices = Bill::invoices()->where('user_id', $billding_user->user_id)->get();

    return view('templates.' . $this->getTemplate() . '.billing.tickets.new_ticket', ['invoices' => $invoices, 'settings' => Bill::settings()->getAll()]);
  }

  public function newTicketCreate(Request $request)
  {
    $validated = $request->validate([
      'subject' => 'required|max:255',
      'service' => 'required|max:255',
      'priority' => 'required|max:50',
      'response' => 'required|max:3000',
    ]);
    
    $ticket = Bill::tickets()->createTicket($request->input('subject'), $request->input('service'), 'Open', $request->input('priority'), $request->input('response'));
    Bill::events()->create('client', Auth::user()->id, 'client:ticket:created', Auth::user()->username.' has created a new ticket #'.$ticket->uuid);

    return redirect(route('tickets.manage', ['uuid' => $ticket->uuid]))->withSuccess('Your ticket has been created');
  }

  public function manage($uuid)
  {
    $ticket = Bill::tickets()->where('uuid', $uuid)->first();
    
    if($ticket == NULL) {
      return redirect(route('tickets.index'))->withErrors('We could not locate your ticket, it must have been deleted.');
    }

    if($ticket->user_id !== Auth::user()->id) {
      return redirect()->back()->withErrors('You dont have permissions to access this resource');
    }

    $responses = Bill::tickets()->response()->where('uuid', $uuid)->orderBy('id', 'DESC')->get();
    $user = User::findOrFail($ticket->user_id);

    return view('templates.' . $this->getTemplate() . '.billing.tickets.manage', ['ticket' => $ticket, 'responses' => $responses, 'user' => $user,'settings' => Bill::settings()->getAll()]);
  }

  public function addResponse($uuid, Request $request)
  {
    $validated = $request->validate([
      'response' => 'required|max:3000',
    ]);

    if(strlen($request->input('response')) < 100) {
      return redirect()->back()->withErrors('Your response must be greater than 4 characters.');
    }

    $ticket = Bill::tickets()->where('uuid', $uuid)->first();
    
    if($ticket == NULL) {
      return redirect('billing.tickets')->withErrors('We could not locate your ticket, it must have been deleted.');
    }

    if($ticket->user_id !== Auth::user()->id AND !Auth::user()->root_admin) {
      return redirect()->back()->withErrors('You dont have permissions to access this resource');
    }

    Bill::tickets()->response()->new($uuid, $request->input('response'));
    return redirect()->back();
  }

  public function delete($uuid)
  {
    $ticket = Bill::tickets()->where('uuid', $uuid)->first();
    if (!Auth::user()->root_admin) {
      return redirect()->back();
    }

    $responses = Bill::tickets()->response()->where('uuid', $uuid)->get();
    foreach($responses as $response) {
      $response->delete();
    }

    $ticket->delete();
    Bill::events()->create('admin', Auth::user()->id, 'admin:ticket:delete', Auth::user()->username.' (admin) has deleted ticket #'.$uuid);

    return redirect(route('admin.tickets'))->withSuccess('Ticket has been deleted.');
  }

  public function statusSwitch($uuid)
  {
    $ticket = Bill::tickets()->where('uuid', $uuid)->first();
    if (Auth::user()->id != $ticket->user_id AND !Auth::user()->root_admin) {
      return redirect()->back();
    }
    if($ticket->status == 'Open'){
      $ticket->status = 'Closed';
    } else {
      $ticket->status = 'Open';
    }
    $ticket->save();
    return redirect()->back();
  }

}
