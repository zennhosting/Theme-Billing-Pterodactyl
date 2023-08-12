{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}


@extends('layouts.admin')
@include('templates.Carbon.billing.admin.nav', ['activeTab' => 'gateways'])

@section('title')
Billing Gateways
@endsection

@section('content-header')
<h1>Gateways</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('admin.index') }}">Admin</a></li>
  <li class="active">Billing</li>
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
          <h3 class="box-title">Global Payments Configuration</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="form-group col-md-5">
              <label class="control-label">Currency</label>
              <div>
                <select name="paypal_currency" class="form-control">
                  @if(isset($settings['paypal_currency']))
                  <option selected value="{{ $settings['paypal_currency'] }}">{{ $settings['paypal_currency'] }} ({{ $currency_list[$settings['paypal_currency']] }})</option>
                  @endif
                  @foreach($currency_list as $key => $currency)
                  <option value="{{ $key }}">{{ $key }} ({{ $currency }})</option>
                  @endforeach

                </select>
                <p class="text-muted small">Currency</p>
              </div>
            </div>
            <div class="form-group col-md-2">
              <label class="control-label">Currency Symbol</label>
              <div>
                <input type="text" required="" class="form-control" name="currency_symbol" value="@if(isset($settings['currency_symbol'])){{ $settings['currency_symbol'] }} @else $ @endif">
                <p class="text-muted small">Currency Symbol: <code>$, €, £</code> etc...</p>
              </div>
            </div>
            <div class="form-group col-md-4">
              <label class="control-label">Giftcards</label>
              <div>
                <select class="form-control" name="giftcards" required>
                  <option value="@if(isset($settings['giftcards'])){{ $settings['giftcards'] }}@endif" selected="">@isset($settings['giftcards'])@if( $settings['giftcards'] == "true") Giftcards Enabled @else Giftcards Disabled @endif
                    @endisset</option>
                  <option value="true">Enable</option>
                  <option value="false">Disable</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">PayPal Configuration</h3>
        </div>
        <div class="box-body">
          <div class="row">

            <div class="form-group col-md-3">
              <label class="control-label">PayPal Payment Gateway</label>
              <div>
                <select class="form-control" name="paypal_gateway" required>
                  <option value="@if(isset($settings['paypal_gateway'])){{ $settings['paypal_gateway'] }}@endif" selected="">@isset($settings['paypal_gateway'])@if( $settings['paypal_gateway'] == "true") PayPal Enabled @else PayPal Disabled @endif
                    @endisset</option>
                  <option value="true">Enable</option>
                  <option value="false">Disable</option>
                </select>
              </div>
            </div>

            <div class="form-group col-md-5">
              <label class="control-label">PayPal Merchant Email</label>
              <div>
                <input type="text" required="" class="form-control" name="paypal_email" value="@if(isset($settings['paypal_email'])){{ $settings['paypal_email'] }}@endif">
              </div>
            </div>

            <div class="form-group col-md-3">
              <label class="control-label">PayPal Mode</label>
              <div>
                <select class="form-control" name="paypal_mode" required>
                  <option @if(isset($settings['paypal_mode']) and $settings['paypal_mode'] == "1") selected @endif value="1">Test</option>
                  <option @if(isset($settings['paypal_mode']) and $settings['paypal_mode'] == "0") selected @endif value="0">Live</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Stripe Configuration</h3>
        </div>
        <div class="box-body">
          <div class="row">

            <div class="form-group col-md-2">
              <label class="control-label">Stripe Payment Gateway</label>
              <div>
                <select class="form-control" name="stripe_gateway" required>
                  <option value="@if(isset($settings['stripe_gateway'])){{ $settings['stripe_gateway'] }}@endif" selected="">@isset($settings['stripe_gateway'])@if( $settings['stripe_gateway'] == "true") Stripe Enabled @else Stripe Disabled @endif
                    @endisset</option>
                  <option value="true">Enable</option>
                  <option value="false">Disable</option>
                </select>
              </div>
            </div>

            <div class="form-group col-md-5">
              <label class="control-label">Publishable key</label>
              <div>
                <input type="text" class="form-control" name="publishable_key" value="@if(isset($settings['publishable_key'])){{ $settings['publishable_key'] }}@endif">
              </div>
            </div>
            <div class="form-group col-md-5">
              <label class="control-label">Secret key</label>
              <div>
                <input type="password" class="form-control" name="secret_key" value="@if(isset($settings['secret_key'])){{ $settings['secret_key'] }}@endif">
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Bitcoin Payments <a href="https://bitpave.com/" target="_blank">BitPave</a></h3>
        </div>
        <div class="box-body">
          <div class="row">

            <div class="form-group col-md-2">
              <label class="control-label">Bitpave Gateway</label>
              <div>
                <select class="form-control" name="gateway_bitpave" required>
                  <option value="@if(isset($settings['gateway_bitpave'])){{ $settings['gateway_bitpave'] }}@endif" selected="">@isset($settings['gateway_bitpave'])@if( $settings['gateway_bitpave'] == "true") Bitpave Enabled @else Bitpave Disabled @endif
                    @endisset</option>
                  <option value="true">Enable</option>
                  <option value="false">Disable</option>
                </select>
              </div>
            </div>

            <div class="form-group col-md-5">
              <label class="control-label">Client ID</label>
              <div>
                <input type="text" class="form-control" name="bitpave_client" value="@if(isset($settings['bitpave_client'])){{ $settings['bitpave_client'] }}@endif">
              </div>
            </div>
            <div class="form-group col-md-5">
              <label class="control-label">Client Secret</label>
              <div>
                <input type="password" class="form-control" name="bitpave_client_secret" value="@if(isset($settings['bitpave_client_secret'])){{ $settings['bitpave_client_secret'] }}@endif">
              </div>
            </div>

            <div class="form-group col-md-5">
              <label class="control-label">Bitcoin Wallet Address</label>
              <div>
                <input type="text" class="form-control" name="bitpave_wallet" value="@if(isset($settings['bitpave_wallet'])){{ $settings['bitpave_wallet'] }}@endif">
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="box box-primary">
        <div class="box-footer">
          <button type="submit" name="gateways" class="btn btn-sm btn-primary pull-right">Save</button>
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
