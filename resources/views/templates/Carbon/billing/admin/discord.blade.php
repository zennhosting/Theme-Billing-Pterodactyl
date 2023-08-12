{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}


@extends('layouts.admin')
@include('templates.Carbon.billing.admin.nav', ['activeTab' => 'discord'])

@section('title')
Discord
@endsection

@section('content-header')
<h1>Billing Discord Widget Bot</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('admin.index') }}">Admin</a></li>
  <li><a href="{{ route('admin.billing') }}">Billing Module</a></li>
  <li class="active">Meta</li>
</ol>
@endsection



@section('content')
@yield('billing::nav')

<div class="row">
  <div class="col-xs-12">
      <form action="{{ route('admin.billing.set.settings') }}" method="POST">
        @csrf

          <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Discord Widget Configuration</h3>
            </div>
            <div class="box-body">
                <div class="row">
                  
                      <div class="form-group col-md-4">
                        <label class="control-label">Status</label>
                        <div>
                            <select name="ds_widget_status" class="form-control">
                              <option @if(isset($settings['ds_widget_status']) and $settings['ds_widget_status'] == 'true') selected @endif value="true">Enabled</option>
                              <option @if(isset($settings['ds_widget_status']) and $settings['ds_widget_status'] == 'false') selected @elseif(!isset($settings['ds_widget_status'])) selected @endif value="false">Disabled</option>
                            </select>
                            <p class="text-muted small"> </p>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                      <label class="control-label">Server ID</label>
                      <div>
                          <input type="text" required="" class="form-control" name="ds_widget_server" value="@if(isset($settings['ds_widget_server'])){{ $settings['ds_widget_server'] }} @endif">
                          <p class="text-muted small"> </p>
                      </div>
                  </div>

                  <div class="form-group col-md-4">
                    <label class="control-label">Channel ID</label>
                    <div>
                        <input type="text" required="" class="form-control" name="ds_widget_channel" value="@if(isset($settings['ds_widget_channel'])){{ $settings['ds_widget_channel'] }}@endif">
                        <p class="text-muted small"> </p>
                    </div>
                </div>

              @if(Bill::allowed('advancedlogs'))
                <div style="padding:20px;">
                <h3>Discord Event Log System</h3>
                <p>
                  Discord Event Logger is a new feature that was added recently. Essentially, it sends notifications of all events to a webhook on Discord. This can be a private channel. <br>
                  Be mindful that enabling this feature will add a significantly longer loading speed on certain options since the server has to proccess the webhook all in the background.
                </p>
                </div>

                <div class="form-group col-md-4">
                        <label class="control-label">Discord Event Webhook</label>
                        <div>
                            <select name="discord_events" class="form-control">
                            <option value="@if(isset($settings['discord_events']) and $settings['discord_events'] == 'true') true @else false @endif" selected>Currently @if(isset($settings['discord_events']) and $settings['discord_events'] == 'true') Enabled @else Disabled @endif</option>

                              <option value="true">Enabled</option>
                              <option value="false">Disabled</option>
                            </select>
                            <p class="text-muted small"> </p>
                        </div>
                    </div>

                <div class="form-group col-md-8">
                    <label class="control-label">Webhook URL</label>
                    <div>
                        <input type="text" placeholder="https://discordapp.com/api/webhooks/XXXXXXXXXXXXXXXXX/XXXXXXXXXXXXXXXXX" class="form-control" name="discord_events_webhook" value="@if(isset($settings['discord_events_webhook'])){{ $settings['discord_events_webhook'] }}@endif">
                        <p class="text-muted small"> </p>
                    </div>
                </div>
                @endif
                    

                    </div>
                  </div>
                </div>

          <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Discord Server</h3>
            </div>
            <div class="box-body">
                <div class="row">

                    <div class="form-group col-md-4">
                      <label class="control-label">Discord Server Link</label>
                      <div>
                          <input type="text" required="" class="form-control" name="discord_server" value="@if(isset($settings['discord_server'])){{ $settings['discord_server'] }} @endif">
                          <p class="text-muted small">Set the link to your Discord server for people to join</p>
                      </div>
                  </div>                    

                    </div>
                  </div>
                </div>

            </div>
        </div>

        
          
          <div class="box box-primary">
              <div class="box-footer">
                  <button type="submit" name="_method"  class="btn btn-sm btn-primary pull-right">Save</button>
              </div>
          </div>
      </form>
  </div>
</div>

@endsection