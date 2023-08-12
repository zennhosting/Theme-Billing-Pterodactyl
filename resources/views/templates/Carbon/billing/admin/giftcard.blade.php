{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}


@extends('layouts.admin')
@include('templates.Carbon.billing.admin.nav', ['activeTab' => 'giftcard'])

@section('title')
GiftCard
@endsection

@section('content-header')
    <h1>GiftCard</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.billing') }}">Billing Module</a></li>
        <li class="active">GiftCard</li>
    </ol>
@endsection

@section('content')
@yield('billing::nav')

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">GiftCard List</h3>
                <div class="box-tools">
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newCardModal">Create New</button>
                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th class="text-center">Limit</th>
                            <th class="text-center">Money</th>
                            <th class="text-right">Actions</th>
                        </tr>
                          @foreach($giftcard as $key => $card)
                            <tr>
                              <td><code>{{ $card->id }}</code></td>
                              <td>{{ $card->name }}</td>
                              <td><code>{{ $card->code }}</code></td>
                              <td class="text-center"><code>{{ $card->limit }}</code></td>
                              <td class="text-center"><code>{{ $card->value }}</code></td>

                              <td class="text-right">
                                <a data-toggle="modal" data-target="#EmailCardModal{{ $card->id }}" class="btn btn-success btn-sm">Email Card</a>
                                <a data-toggle="modal" data-target="#editCardModal{{ $card->id }}" class="btn btn-primary btn-sm">Edit</a>
                                <a onclick="deleteModal('{{ $card->id }}')" data-toggle="modal" data-target="#deleteCardModal" class="btn btn-danger btn-sm">Delete</a>
                              </td>
                            </tr>

                            <div class="modal fade" id="EmailCardModal{{ $card->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.billing.giftcard.mail') }}" method="POST" id="">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Emailing Card <code>{{ $card->code }}</code></h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                            
                                                  <div class="col-md-12">
                                                      <label for="receiver_name" class="form-label">Receiver Name</label>
                                                      <input required="" type="text" name="receiver_name" id="receiver_name" class="form-control" value="" />
                                                      <p class="text-muted small">Name of the receiver</p>
                                                  </div>
                            
                                                  <div class="col-md-12">
                                                    <label for="receiver_email" class="form-label">Receiver Email</label>
                                                    <input required="" type="text" name="receiver_email" id="receiver_email" class="form-control" value="" />
                                                    <p class="text-muted small">Email of the receiver</p>
                                                </div>

                                                <div class="col-md-12">
                                                    <label for="receiver_code_d" class="form-label">GiftCard Code</label>
                                                    <input disabled type="text" name="receiver_code_d" id="receiver_code_d" class="form-control" style="cursor: no-drop; " value="{{ $card->code }}" />
                                                </div>

                                                <div class="col-md-12" style="display: none;">
                                                    <label for="receiver_code" class="form-label">GiftCard Code</label>
                                                    <input required type="text" name="receiver_code" id="receiver_code" class="form-control" style="cursor: no-drop; " value="{{ $card->code }}" />
                                                </div>
                            
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                {!! csrf_field() !!}
                                                <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success btn-sm">Send Email</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="editCardModal{{ $card->id }}" tabindex="-1" role="dialog">
                              <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                      <form action="{{ route('admin.billing.giftcard.manage') }}" method="POST">
                                          <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                              <h4 class="modal-title">Edit card</h4>
                                          </div>
                                          <div class="modal-body">
                                              <div class="row">
                            
                                                  <div class="col-md-12">
                                                      <label for="edit_card_name" class="form-label">Giftcard Name</label>
                                                      <input required="" type="text" name="edit_card_name" id="edit_card_name" class="form-control" value="{{ $card->name }}" />
                                                      <p class="text-muted small">Name of the card</p>
                                                  </div>

                                                  <div class="col-md-12">
                                                    <label for="edit_card_code" class="form-label">Giftcard Redeem Code</label>
                                                    <input required="" type="text" name="edit_card_code" id="edit_card_code" class="form-control" value="{{ $card->code }}" />
                                                    <p class="text-muted small">Enter the secret code to redeem the giftcard</p>
                                                  </div>

                                                  <div class="col-md-6">
                                                    <label for="edit_card_limit" class="form-label">Giftcard Limit (Global)</label>
                                                    <input required="" type="number" name="edit_card_limit" id="edit_card_limit" class="form-control" value="{{ $card->limit }}" />
                                                    <p class="text-muted small">This is how many times the giftcard can be used</p>
                                                  </div>

                                                  <div class="col-md-6">
                                                    <label for="edit_card_value" class="form-label">Giftcard Money value in  @if(isset($settings['paypal_currency'])) {{$settings['paypal_currency'] }}@endif</label>
                                                    <input required=""  type="number" name="edit_card_value" id="edit_card_value" class="form-control" value="{{ $card->value }}" />
                                                    <p class="text-muted small">Money Loaded on the giftcard</p>
                                                  </div>
                                                  
                                              </div>
                                          </div>
                                          <div class="modal-footer">
                                              {!! csrf_field() !!}
                                              <input type="hidden" id="edit_card_id" name="edit_card_id" value="{{ $card->id }}">
                                              <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Cancel</button>
                                              <button type="submit" class="btn btn-success btn-sm">Submit</button>
                                          </div>
                                      </form>
                                  </div>
                              </div>
                            </div>
                          @endforeach
                            
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="newCardModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.billing.giftcard.manage') }}" method="POST" id="create_plan_id">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Create Card</h4>
                </div>
                <div class="modal-body">
                    <div class="row">

                      <div class="col-md-12">
                          <label for="edit_card_name" class="form-label">Giftcard Name</label>
                          <input required="" type="text" name="edit_card_name" id="edit_card_name" class="form-control" value="" />
                          <p class="text-muted small">Name of the card</p>
                      </div>

                      <div class="col-md-12">
                        <label for="edit_card_code" class="form-label">Giftcard Redeem Code</label> <a type="button" onclick="CreateCode()" class="btn btn-warning btn-sm" style="margin-bottom: 5px;">Generate</a>
                        <input required="" type="text" name="edit_card_code" id="new_card_code" class="form-control" value="" />
                        <p class="text-muted small">Enter the secret code to redeem the giftcard</p>
                      </div>

                      <div class="col-md-6">
                        <label for="edit_card_limit" class="form-label">Giftcard Limit (Global)</label>
                        <input required="" type="number" name="edit_card_limit" id="edit_card_limit" class="form-control" value="1" />
                        <p class="text-muted small">This is how many times the giftcard can be used</p>
                      </div>

                      <div class="col-md-6">
                        <label for="edit_card_value" class="form-label">Giftcard Money value in  @if(isset($settings['paypal_currency'])) {{$settings['paypal_currency'] }}@endif</label>
                        <input required=""  type="number" name="edit_card_value" id="edit_card_value" class="form-control" value="" />
                        <p class="text-muted small">Money Loaded on the giftcard</p>
                      </div>

                    </div>
                </div>
                <div class="modal-footer">
                    {!! csrf_field() !!}
                    <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="deleteCardModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <form id="create_game_id" action="{{ route('admin.billing.giftcard.manage') }}" method="POST">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Delete Plan</h4>
              </div>
              <div class="modal-body">
             
                    <strong class="text-center">Are you sure?</strong> 
            
              </div>
              <div class="modal-footer">
                  {!! csrf_field() !!}
                  <input type="hidden" id="delete_card_id" name="delete_card_id" value="">
                  <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-success btn-sm">Submit</button>
              </div>
          </form>
      </div>
  </div>
</div>



  <script type="text/javascript"> 
  

  function deleteModal(id){
    document.getElementById('delete_card_id').value = id;
  }
  
function CreateCode() {

    let rand = (Math.random() + 1).toString(36).substring(3);
    var s= document.getElementById('new_card_code');
    s.value = rand;
}

  </script>

@endsection
