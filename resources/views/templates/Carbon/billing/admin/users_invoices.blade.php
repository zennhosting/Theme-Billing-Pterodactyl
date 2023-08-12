{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}


@extends('layouts.admin')
@include('templates.Carbon.billing.admin.nav', ['activeTab' => 'users'])

@section('title')
User Plans
@endsection

@section('content-header')
    <h1>User Billing Plans</h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.index') }}">Admin</a></li>
      <li><a href="{{ route('admin.billing') }}">Billing Module</a></li>
      <li><a href="{{ route('admin.billing.users') }}">Users</a></li>
      <li class="active">Plans </li>
    </ol>
@endsection

@section('content')
@yield('billing::nav')

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Plans List</h3>
                <div class="box-tools">

                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th class="">Plan</th>
                            <th class="">Price</th>
                            <th>Invoice Date</th>
                            <th>Due Date</th>
                            <th class="text-right">Status</th>
                        </tr>
                              @foreach($invoices as $key => $invoice)
                       
                                <tr>
                                  <td><code>{{ $invoice->id }}</code></td>
                                  <td>
                                    @if(isset($plans[$invoice->plan_id]))
                                      {{ $plans[$invoice->plan_id]->name }}
                                    @else
                                      deleted
                                    @endif
                                  </td>
                                  <td>@if(isset($plans[$invoice->plan_id]))
                                    @if(isset($settings['currency_symbol'])){{ $settings['currency_symbol'] }}@endif{{ $plans[$invoice->plan_id]->price }} @if(isset($settings['paypal_currency'])){{ $settings['paypal_currency'] }}@endif
                                    @else
                                      deleted
                                    @endif
                                  </td>
                                  <td>{{ $invoice->invoice_date }}</td>
                                  <td>{{ $invoice->due_date }}</td>
                                  @if($invoice->status == 'Paid')
                                    <td class="text-right"><span class="badge badge-pill badge-success" style="background: green;">{{ $invoice->status }}</span></td>
                                  @else
                                    <td class="text-right"><span class="badge badge-pill badge-danger" style="background: red;">{{ $invoice->status }}</span></td>
                                  @endif

                                </tr>
                       
                              @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection
