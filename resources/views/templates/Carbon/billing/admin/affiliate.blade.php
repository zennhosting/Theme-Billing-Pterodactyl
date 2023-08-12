{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}


@extends('layouts.admin')
@include('templates.Carbon.billing.admin.nav', ['activeTab' => 'affiliates'])

@section('title')
Users
@endsection

@section('content-header')
    <h1>Affiliates</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.billing') }}">Billing Module</a></li>
        <li class="active">Affiliates </li>
    </ol>
@endsection

@section('content')
@yield('billing::nav')

<div class="row">
    <div class="col-xs-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Affiliates List</h3>
                <div class="box-tools">

                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th class="">Code</th>
                            <th class="">Email</th>
                            <th class="">Earned Balance</th>
                            <th class="">Clicks</th>
                            <th class="">Purchases</th>
                            <th class="">Commision</th>
                            <th class="">Discount</th>

                            <th class="text-right">Actions</th>
                        </tr>
                              @foreach($affiliates as $key => $user)
                                @if(isset($user['ptero']->id))
                                <tr>
                                  <td><code>{{ $user['ptero']->id }}</code></td>
                                  <td><code>{{ $user['billing']->code }}</code></td>
                                  <td><a href="{{ route('admin.users.view', ['user' => $user['ptero']->id]) }}">{{ $user['ptero']->email }}</td>
                                  <td>@if(isset($settings['currency_symbol'])){{ $settings['currency_symbol'] }}@endif{{ $user['billing']->total_earned }} @if(isset($settings['paypal_currency'])){{ $settings['paypal_currency'] }}@endif</td>
                                  <td>{{ $user['billing']->clicks }}</td>
                                  <td>{{ $user['billing']->purchases }}</td>
                                  <td>{{ $user['billing']->creator_commision }}%</td>
                                  <td>{{ $user['billing']->discount }}%</td>

                                  <td class="text-right">
                                    <a data-toggle="modal" data-target="#userAffiliate{{ $user['ptero']->id }}" href="#" class="btn btn-primary btn-sm">Edit</a>
                                  </td>
                                </tr>

                                <div class="modal fade" id="userAffiliate{{ $user['ptero']->id }}" tabindex="-1" role="dialog">
                                  <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                          <form id="create_game_id" action="{{ route('admin.billing.affiliate.edit') }}" method="POST">
                                              <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                  <h4 class="modal-title">Edit Affiliate {{ $user['ptero']->name }}</h4>
                                              </div>
                                              <div class="modal-body">
                                                <div class="row">
                                                <input class="form-control" type="text" name="id" value="{{ $user['ptero']->id }}" style="display: none;" required>

                                                <div class="col-md-6">
                                                      <label for="code" class="form-label">Affiliate Code</label>
                                                      <input class="form-control" type="text" name="code" value="{{ $user['billing']->code }}" required>
                                                      <p class="text-muted small">Affiliate Code of User</p>
                                                  </div>

                                                <div class="col-md-6">
                                                      <label for="plan_name" class="form-label">Total Earned</label>
                                                      <input class="form-control" type="number" name="total_earned" value="{{ $user['billing']->total_earned }}" required>
                                                      <p class="text-muted small">The amount of money the user earned</p>
                                                  </div>

                                                  <div class="col-md-6">
                                                      <label for="commision" class="form-label">Creator Commision in %</label>
                                                      <input class="form-control" type="number" name="commision" value="{{ $user['billing']->creator_commision }}" required>
                                                      <p class="text-muted small">Percentage creator receives</p>
                                                  </div>

                                                  <div class="col-md-6">
                                                      <label for="code" class="form-label">Discount for invited in %</label>
                                                      <input class="form-control" type="number" name="discount" value="{{ $user['billing']->discount }}" required>
                                                      <p class="text-muted small">Discounted invited users receive</p>
                                                  </div>

                                                </div>
                                              </div>
                                              <div class="modal-footer">
                                                  {!! csrf_field() !!}
                                                  <input type="hidden" name="user_id" value="{{ $user['billing']->id }}">
                                                  <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Cancel</button>
                                                  <button type="submit" class="btn btn-success btn-sm">Submit</button>
                                              </div>
                                          </form>
                                      </div>
                                  </div>
                                </div>
                                @endif
                              @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-center">
        {{ Bill::affiliates()->paginate(15)->links() }}
        </div>
    </div>

    <div class="col-xs-4">
          <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Meta Configuration</h3>
            </div>
            <div class="box-body">
                <div class="row">
                  

                      <div class="form-group col-md-4">
                        <label class="control-label">Min Cashout amount</label>
                        <div>
                            <input type="text"class="form-control" placeholder="10" value="{{ config('billing.affiliates.cashout') }}" disabled>
                            <p class="text-muted small"> </p>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                      <label class="control-label">Creator Reward in %</label>
                      <div>
                          <input type="text" class="form-control" value="{{ config('billing.affiliates.conversion') }}" disabled>
                          <p class="text-muted small"> </p>
                      </div>
                  </div>

                  <div class="form-group col-md-4">
                    <label class="control-label">Invited Discount in %</label>
                    <div>
                        <input type="text" class="form-control" placeholder="10" value="{{ config('billing.affiliates.discount') }}" disabled>
                        <p class="text-muted small"> </p>
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label class="control-label">Discord Webhook / Cashout Events</label>
                    <div>
                        <input type="text" class="form-control" value="{{ config('billing.affiliates.webhook') }}" disabled>
                        <p class="text-muted small">Edit values in /config/billing.php</p>
                    </div>
                </div>

                    </div>
                  </div>
                </div>
            </div>
        </div>
          
    </div>
</div>


@endsection
