{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}


@extends('layouts.admin')
@include('templates.Carbon.billing.admin.nav', ['activeTab' => 'tickets'])

@section('title')
Tickets
@endsection

@section('content-header')
<h1>Billing Tickets</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('admin.index') }}">Admin</a></li>
  <li><a href="{{ route('admin.billing') }}">Billing Module</a></li>
  <li class="active">Tickets</li>
</ol>
@endsection



@section('content')
@yield('billing::nav')

<div class="row">

<div class="col-sm-3">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Ticket Statistics</h3>
        </div>
        <div class="box-body">
            <p class="text-muted">
              <i class="fas fa-solid fa-ticket" style="margin-right: 10px"></i>Total Tickets: ({{ Bill::tickets()->count() }})<br>
              <i class="fas fa-solid fa-ticket" style="margin-right: 10px"></i>Open Tickets: ({{ Bill::tickets()->where('status', 'Open')->count() }})<br>
              <i class="fas fa-solid fa-ticket" style="margin-right: 10px"></i>Closed Tickets: ({{ Bill::tickets()->where('status', 'Closed')->count() }})<br>

            </p>
        </div>
    </div>
</div>

<div class="col-xs-9">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">All Tickets</h3>
                <div class="box-tools">

                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>UUID</th>
                            <th class="">Status</th>
                            <th class="">Subject</th>
                            <th class="">User</th>
                            <th class="text-right">Time</th>
                            <th class="text-right">Actions</th>
                        </tr>
                              @foreach($tickets as $key => $ticket)
                                @if(isset($ticket))
                                <tr>
                                  <td><code>{{ $ticket->uuid }}</code></td>
                                  <td><span class="label  @if($ticket->status == 'Closed') label-danger @elseif($ticket->status == 'Open') label-success @else label-success @endif ">{{ $ticket->status }}</span></td>
                                  <td>{{ $ticket->subject }}</td>
                                  <td>@if(Bill::users()->pterodactyl($ticket->user_id) !== null)<a href="/admin/users/view/{{$ticket->user_id}}">{{ Bill::users()->pterodactyl($ticket->user_id)->username }}</a>@else Deleted @endif</td>
                                  <td class="text-right">Updated {{ $ticket->updated_at->diffForHumans() }}</td>

                                  <td class="text-right">
                                    <a href="{{ route('admin.ticket.manage', ['id' => $ticket->id]) }}" class="btn btn-primary btn-sm">Manage</a>
                                  </td>
                                </tr>
                                @endif
                              @endforeach
                    </tbody>
                </table>
            </div>
        </div>
            <div class="d-flex justify-content-center">
            {{ Bill::tickets()->paginate(15)->links() }}
            </div>
    </div>

</div>
@endsection
