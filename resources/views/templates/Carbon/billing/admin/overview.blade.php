{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}


@extends('layouts.admin')
@include('templates.Carbon.billing.admin.nav', ['activeTab' => 'overview'])

@section('title')
overview
@endsection

@section('content-header')
<h1>Billing Overview</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('admin.index') }}">Admin</a></li>
  <li><a href="{{ route('admin.billing') }}">Billing Module</a></li>
  <li class="active">Overview</li>
</ol>
@endsection



@section('content')
@yield('billing::nav')

<div class="box-body">
    <div class="row">
    <div class="col-sm-4">
    <div class="box box-success">
          <div class="box-header with-border">
              <h3 class="box-title">Estimated Monthly Revenue</h3>
          </div>
           <div class="box-body primary">
             <div class="flex center space-between color-white">
                  <h2 class="color-white"><strong>$@if(isset($orders['revenue'])){{$orders['revenue']}}@else 0 @endif / Monthly</strong><br><p style="font-size: 15px;">Estimated Monthly Revenue</p></h2>
                  <div class="circle">
                 <i class="fas fa-shopping-basket"></i>
               </div>
              </div>
              <a class="btn btn-success btn-card w-100" href="{{ route('admin.billing.orders') }}"> More Info <i class="fas fa-arrow-right"></i></a>
           </div>       
    </div>
</div>

<div class="col-sm-4">
    <div class="box box-success">
          <div class="box-header with-border">
              <h3 class="box-title">Active Orders</h3>
          </div>
           <div class="box-body primary">
             <div class="flex center space-between color-white">
                  <h2 class="color-white"><strong>@if(isset($orders['orders'])){{$orders['orders']}}@else 0 @endif Orders</strong><br><p style="font-size: 15px;">Active Orders</p></h2>
                  <div class="circle">
                 <i class="fas fa-cube"></i>
               </div>
              </div>
              <a class="btn btn-success btn-card w-100" href="{{ route('admin.billing.orders') }}"> More Info <i class="fas fa-arrow-right"></i></a>

           </div>       
    </div>
</div>

<div class="col-sm-4">
    <div class="box box-success">
          <div class="box-header with-border">
              <h3 class="box-title">Total Users</h3>
          </div>
           <div class="box-body primary">
             <div class="flex center space-between color-white">
                  <h2 class="color-white"><strong>@if(isset($orders['clients'])){{$orders['clients']}}@else 0 @endif Clients</strong><br><p style="font-size: 15px;">Total Clients</p></h2>
                  <div class="circle">
                 <i class="fas fa-users"></i>
               </div>
              </div>
              <a class="btn btn-success btn-card w-100" href="{{ route('admin.billing.users') }}"> More Info <i class="fas fa-arrow-right"></i></a>

           </div>       
    </div>
</div>

<div class="col-xs-9">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Recent Events</h3>
                <div class="box-tools">

                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th class="">Section</th>
                            <th class="">User</th>
                            <th class="">Event</th>
                            <th class="">Description</th>
                            <th class="text-right">Time</th>
                            <th class="text-right">Actions</th>
                        </tr>
                              @foreach($events as $key => $event)
                                @if(isset($event))
                                <tr>
                                  <td><code>{{ $event->id }}</code></td>
                                  <td><span class="label  @if($event->section == 'global') label-warning @elseif($event->section == 'admin') label-danger @else label-primary @endif ">{{ $event->section }}</span></td>
                                  <td>@if($event->user_id == 0) N/A @else #{{ $event->user_id }} @endif</td>
                                  <td>{{ $event->event }}</td>
                                  <td>{{ $event->description }}</td>
                                  <td class="text-right">{{ $event->created_at->diffForHumans() }}</td>

                                  <td class="text-right">
                                    <a href="/admin/users/view/{{$event->user_id}}" class="btn @if($event->user_id == 0) disabled @endif btn-primary btn-sm">Find User</a>
                                  </td>
                                </tr>
                                @endif
                              @endforeach

                    </tbody>
                </table>
            </div>
        </div>
            <div class="d-flex justify-content-center">
            {{ Bill::events()->paginate(15)->links() }}
            </div>
    </div>

    <div class="col-sm-3">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Subscription Details</h3>
            </div>
            <div class="box-body">
                <p class="text-muted">
                @if($subscription->response)
                    <span class="card-small-icon primary-2"><i class="fas fa-solid fa-check"></i></span>Active Subscription: {{ $subscription->subscription }}<br>
                    <span class="card-small-icon primary-2"><i class="fas fa-solid fa-check"></i></span>Domain: {{ config('app.url') }}<br>
                    <span class="card-small-icon primary-2"><i class="fas fa-solid fa-check"></i></span>Expires in: {{ $subscription->expiry_in_days }} days ({{ $subscription->expiry }})<br>
                    <span class="card-small-icon primary-2"><i class="fas fa-solid fa-check"></i></span>Bought by: {{ $subscription->buyer }}<br>
                    <span class="card-small-icon primary-2"><i class="fas fa-solid fa-check"></i></span>Status: {{ $subscription->status }}<br>
                @else
                {{ $subscription->description }}
                @endif
                </p>
            </div>
            <div class="box-footer">
                <a href="https://wemx.net/dashboard/" class="btn btn-sm btn-default w-100">Manage Subscription</a>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">System Health</h3>
            </div>
            <div class="box-body">
                <p class="text-muted">
                    <span class="card-small-icon"><i class="fas fa-solid fa-check"></i></span>Billing Version: {{ config('billing.version') }} <br>
                    <span class="card-small-icon"><i class="fas fa-solid fa-check"></i></span>Pterodactyl Version: {{ config('app.version') }} <br>
                    <span class="card-small-icon"><i class="fas fa-solid fa-check"></i></span>SSL Connection: @if(request()->secure()) Active(secure) @else Inactive(not secured) @endif<br>
                    <span class="card-small-icon"><i class="fas fa-solid fa-check"></i></span>Laravel Version: {{ app()->version() }} <br>
                    <span class="card-small-icon"><i class="fas fa-solid fa-check"></i></span>Operating System: {{ PHP_OS }} <br>
                    <span class="card-small-icon"><i class="fas fa-solid fa-check"></i></span>PHP Version: {{ phpversion() }} <br>
                </p>
            </div>
            <div class="box-footer">
                <a href="{{ route('admin.update') }}" class="btn btn-sm btn-default w-100">Look for updates</a>
            </div>
        </div>
    </div>

  </div>
</div>

@endsection
