{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}


@extends('layouts.admin')
@include('templates.Carbon.billing.admin.nav', ['activeTab' => 'orders'])

@section('title')
Orders
@endsection

@section('content-header')
    <h1>Orders</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.billing') }}">Billing Module</a></li>
        <li class="active">Orders</li>
    </ol>
@endsection

@section('content')
@yield('billing::nav')

<div class="row">

    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border" style="margin-bottom: 20px;">
                <h3 class="box-title">All Orders</h3>
                <div class="box-tools">
                    <button onclick="createModal('{{ route('admin.billing.create.game') }}')" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newOrderModal">Create New</button>
                </div>
            </div>
                          @if(!empty($orders))
                            @foreach($orders as $key => $order)
                            @php $user = Auth::user()->find($order['user_id']); $plan = Bill::plans()->find($order['plan_id'])
                            @endphp
                            <div class="col-sm-4">
                                <div class="box @if($order['status'] == "Paid")box-success @else box-danger @endif">
                                    <div class="box-header with-border">
                                        <h3 class="box-title flex center space-between">#{{ $order['id'] }} {{ $plan->name }} <span class="label @if($order['status'] == "Paid")label-success @else label-danger @endif">{{ $order['status'] }}</span></h3>
                                    </div>
                                    <div class="box-body">
                                        <p>
                                            <h4><img src="https://www.gravatar.com/avatar/{{ $user->email }}?s=32" style="border-radius: 20px;" class="user-image" alt="User Image"> {{ $user->username }} <strong>(<a href="/admin/users/view/{{$user->id}}" target="_BLANK">{{ $user->email }}</a>)</strong></h4>
                                            <h4>Invoice Date: {{ $order['invoice_date'] }}</h4>
                                            <h4>Due Date: {{ $order['due_date'] }}</h4>

                                            <strong>Warning!</strong> This feature has not been fully tested and may have bugs.
                                        </p>
                                        <div class="flex">
                                        <a href="{{ route('admin.billing.order.manage', ['id' => $order['id']]) }}" class="btn btn-primary w-100">Manage</a>
                                        <a href="#" onCLick="deleteOrder('{{ route('admin.billing.order.delete', ['id' => $order['id']]) }}')" style="margin-left: 10px" class="btn btn-danger"><i style="padding-left: 0px;" class="fas fa-trash-alt"></i> </a>
                                        </div>

                                    </div>       
                                </div>
                            </div>
                            @endforeach
                          @endif
                </div>
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                  {{ $orders->links() }}
             </div>
            </div>
        </div>




<div class="modal fade" id="newOrderModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="create_order_id" action="{{ route('admin.billing.order.create') }}" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Create Order</h4>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <label for="email" class="form-label">Owner Email Address</label>
                            <input type="email" required name="email" id="email" class="form-control" />
                            <p class="text-muted small">Enter the email address of the owner</p>
                        </div>

                        <div class="col-md-12">
                        <label for="plan" class="form-label">Plan</label>
                        <select onchange="" name="plan" id="plan" class="form-control">
                            @if(isset($plans))

                            <option value="0">Select a plan</option>
                            @foreach($plans as $key => $plan)
                            <option value="{{ $plan['id'] }}">{{ $plan['name'] }}</option>
                            @endforeach
                            @endif
                        </select>
                        <p class="text-muted small">Select a plan for this order</p>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    {!! csrf_field() !!}
                    <input type="hidden" id="game_id" name="game_id" value="">
                    <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteGameModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <form id="create_game_id" action="{{ route('admin.billing.delete.game') }}" method="POST">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Delete Game</h4>
              </div>
              <div class="modal-body">
             
                    <strong class="text-center">Are you sure?</strong> 
            
              </div>
              <div class="modal-footer">
                  {!! csrf_field() !!}
                  <input type="hidden" id="delete_game_id" name="game_id" value="">
                  <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-success btn-sm">Submit</button>
              </div>
          </form>
      </div>
  </div>
</div>

<script>
function deleteOrder(url)
{
  if (confirm('Are you sure you want to delete this product?') == true) {
    window.location.href = url;
  }
}
</script>

@endsection
