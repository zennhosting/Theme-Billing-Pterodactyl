{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}


@extends('layouts.admin')
@include('templates.Carbon.billing.admin.nav', ['activeTab' => 'manage_order'])

@section('title')
Managing order #{{$order['invoice']['id']}}
@endsection

@section('content-header')
    <h1>Order #{{$order['invoice']['id']}}</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.billing') }}">Billing Module</a></li>
        <li><a href="{{ route('admin.billing.orders') }}">Orders</a></li>
        <li class="active">Order #{{$order['invoice']['id']}}</li>
    </ol>
@endsection

@section('content')
@yield('billing::nav')

    @if(!empty($order))
    <div class="col-sm-12">
    <form action="{{ route('admin.billing.order.update', ['id' => $order['invoice']['id']]) }}" method="POST">
        @csrf
        <div class="box @if($order['invoice']['status'] == "Paid")box-success @else box-danger @endif">
            <div class="box-header with-border">
                <h3 class="box-title flex center space-between">#{{ $order['invoice']['id'] }} {{$order['plan']['name']}} <span class="label @if($order['invoice']['status'] == "Paid")label-success @else label-danger @endif">{{ $order['invoice']['status'] }}</span></h3>
            </div>
            <div class="box-body">
                <div>
                    <h4><img src="https://www.gravatar.com/avatar/{{ $order['user']['email'] }}?s=64" style="border-radius: 20px;" class="user-image" alt="User Image"> {{ $order['user']['username']  }} <strong>(<a href="/admin/users/view/{{$order['user']['id'] }}" target="_BLANK">{{ $order['user']['email']  }}</a>)</strong></h4>
                </div>  
                    <!-- <h4>Invoice Date: {{ $order['invoice']['invoice_date'] }}</h4>
                    <h4>Due Date: {{ $order['invoice']['due_date'] }}</h4> -->

                    <div class="form-group col-md-6">
                  <label class="control-label">Payment Status</label>
                  <div>
                    <select class="form-control" name="status" required>
                      <option value="{{$order['invoice']['status']}}" selected="">{{$order['invoice']['status']}}</option>
                      <option value="Paid">Paid</option>
                      <option value="Unpaid">Unpaid</option>
                  </select>
                  <p class="text-muted small">Set the payment status</p>
                  </div>
                </div>

                <div class="form-group col-md-6">
                <label class="control-label">Expiration Date / Due date</label>
                <div>
                    <input type="date" required="" class="form-control" name="expiration" value="{{ $order['invoice']['due_date'] }}">
                </div>
            </div>

                <button type="submit" name="_method" class="btn btn-primary w-100">Update</button>
             </form>
            </div>       
        </div>
    </div>
    @endif

@endsection
