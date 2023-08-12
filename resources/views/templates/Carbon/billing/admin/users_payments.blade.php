{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}


@extends('layouts.admin')
@include('templates.Carbon.billing.admin.nav', ['activeTab' => 'users'])

@section('title')
User Payments
@endsection

@section('content-header')
    <h1>Payments</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.billing') }}">Billing Module</a></li>
        <li><a href="{{ route('admin.billing.users') }}">Users</a></li>
        <li class="active">Payments </li>
    </ol>
@endsection

@section('content')
@yield('billing::nav')

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Payments List</h3>
                <div class="box-tools">

                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>TXN ID</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th class="text-right">Status</th>
                        </tr>
                        @foreach($logs as $key => $log)
                        <tr>
                          <td><code>{{ $log->txn_id }}</code></td>
                          <td>@if(isset($settings['currency_symbol'])){{ $settings['currency_symbol'] }}@endif
                            @php
                              $log->data = json_decode($log->data);
                            @endphp
                            @if(isset($log->data->mc_gross))
                            {{ $log->data->mc_gross }}
                            @elseif(isset($log->data->amount))
                            {{ $log->data->amount }}
                            @endif 
                            @if(isset($settings['paypal_currency'])){{ $settings['paypal_currency'] }}
                            @endif
                          </td>
                          <td>{{ $log->created_at }}</td>
                          
                          <td class="text-right">{{ $log->status }}</td>
                        </tr>
                  
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection
