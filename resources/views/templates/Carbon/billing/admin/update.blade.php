{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}

@extends('layouts.admin')
@include('templates.Carbon.billing.admin.nav', ['activeTab' => 'update']) 

@section('title')
Updates
@endsection

@section('content-header')
<h1>Billing Module Updates</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('admin.index') }}">Admin</a></li>
    <li><a href="{{ route('admin.billing') }}">Billing Module</a></li>
  <li class="active">Update </li>
</ol>
@endsection

@section('content')

@yield('billing::nav') 

<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Billing Module Licenses</h3> 
  </div>
  <div class="box-body">
    <div class="alert alert-success" role="alert">
      <h4 class="alert-heading">Activate Billing License</h4>
      <p> The billing module will not work until a valid license key has been entered.
        <br>You must activate your Billing license to enable the billing module, the module will be automatically activated if you provide a valid license key.<br>  
      <br>You can contact us @ our Discord server to get a unique license key.
      <a href="https://pterodactyl-resources.com/discord" style="width: 100%; border: none;" class="btn btn-primary btn-sm">Join Discord</a>
      </p>
      </div>
    <div class="row">
      <form action="{{ route('admin.billing.set.settings') }}" method="POST">
        @csrf
      <div class="form-group col-md-6">
        <label class="control-label">License Key</label>
        <div>
          <input type="text" required="" class="form-control" name="license_key" value="@if(isset($settings['license_key'])){{ $settings['license_key'] }}@endif">
          <p class="text-muted small">Enter a license key to activate the Billing Module</p>
        </div>
      </div>
    <div class="form-group col-md-6">
      <label class="control-label">Panel URL</label>
      <div>
        <input type="text" disabled="" class="form-control" name="license_url" value="{{ config('app.url') }}">
        <p class="text-muted small"> </p>
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

<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">currently running version {{ config('billing.version') }} of the {{ config('billing.name') }} Module.</h3>
      </div>
      @if(Bill::upd()->getData()->ver_num == config('billing.version'))
          {!! Bill::upd()->getData()->ver_content !!}
          <br>
      @else
          {!! Bill::upd()->getData()->ver_description !!}
          <br>
      @endif
{{--        <a href="{{ route('admin.update.install') }}">Update</a>--}}
    </div>
  </div>
</div>
@endsection