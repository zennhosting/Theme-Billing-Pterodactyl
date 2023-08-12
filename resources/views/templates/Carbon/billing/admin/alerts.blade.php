{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}


@extends('layouts.admin')
@include('templates.Carbon.billing.admin.nav', ['activeTab' => 'alerts'])

@section('title')
Alerts
@endsection

@section('content-header')
<h1>Billing Meta Configuration</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('admin.index') }}">Admin</a></li>
  <li><a href="{{ route('admin.billing') }}">Billing Module</a></li>
  <li class="active">Alerts</li>
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
                <h3 class="box-title">Alerts Configuration</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    
                    <div class="form-group col-md-4">
                        <label class="control-label">Enable Alerts</label>
                        <div>
                          <select class="form-control" name="alerts_status" required>
                            <option value="@if(isset($settings['alerts_status'])){{ $settings['alerts_status'] }}@endif" selected="">@isset($settings['alerts_status'])@if( $settings['alerts_status'] == "true") Alerts Enabled @else Alerts Disabled  @endif
                              @endisset</option>
                            <option value="true">Enable</option>
                            <option value="false">Disable</option>
                        </select>
                        </div>
                      </div>

                      <div class="form-group col-md-4">
                        <label class="control-label">Closable Alert</label>
                        <div>
                          <select class="form-control" name="alerts_closable" required>
                            <option value="@if(isset($settings['alerts_closable'])){{ $settings['alerts_closable'] }}@endif" selected="">@isset($settings['alerts_closable'])@if( $settings['alerts_closable'] == "true") Alert closable @else Alert Not closable  @endif
                              @endisset</option>
                            <option value="true">Enable</option>
                            <option value="false">Disable</option>
                        </select>
                        </div>
                      </div>

                    <div class="form-group col-md-4">
                        <label class="control-label">Alert Type</label>
                        <div>
                          <select class="form-control" name="alerts_type" required>
                            <option value="@if(isset($settings['alerts_type'])){{ $settings['alerts_type'] }}@endif" selected="">Selected: @if(isset($settings['alerts_type'])){{ $settings['alerts_type'] }}@else none @endif</option>
                            <option value="primary">primary</option>
                            <option value="info">info</option>
                            <option value="success">success</option>
                            <option value="danger">danger</option>
                            <option value="warning">warning</option>
                            <option value="default">default</option>
                        </select>
                        </div>
                      </div>

                      <div class="form-group col-md-6">
                        <label class="control-label">Alert Title</label>
                        <div>
                            <input type="text" required="" class="form-control" name="alert_title" value="@if(isset($settings['alert_title'])){{ $settings['alert_title'] }}@else Alert! @endif">
                            <p class="text-muted small"> </p>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label class="control-label">Alert Description</label>
                        <div>
                          <textarea name="alert_desc" rows="3" class="form-control" required> @if(isset($settings['alert_desc'])){{ $settings['alert_desc'] }}@else This is the alert description @endif</textarea>
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

<style>

.game-img-card {
  display: flex;
  justify-content: center;
}

.game-img {
  width: 75px;
}

</style>