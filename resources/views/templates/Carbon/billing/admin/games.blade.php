{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}


@extends('layouts.admin')
@include('templates.Carbon.billing.admin.nav', ['activeTab' => 'games'])

@section('title')
Games
@endsection

@section('content-header')
    <h1>Games</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.billing') }}">Billing Module</a></li>
        <li class="active">Games</li>
    </ol>
@endsection

@section('content')
@yield('billing::nav')

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Games List</h3>
                <div class="box-tools">
                    <button onclick="createModal('{{ route('admin.billing.create.game') }}')" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newGameModal">Create New</button>
                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th class="text-center">Game Name</th>
                            <th class="text-right">Actions</th>
                        </tr>
                          @if(!empty($biling_games))

                            @foreach($biling_games as $key => $game)
                              <tr class="tr-body" id="{{ $game->id }}" draggable='true' ondragstart='start()' ondragover='dragover()'>
                                <td><code>{{ $game->id }}</code></td>
                                <td class="text-center">{{ $game->label }}</td>
                                <td class="text-right">
                                  <a class="btn btn-info btn-sm"> <i class="fa fa-solid fa-sort"></i> </a>
                                  <a data-toggle="modal" data-target="#newGameModal" onclick="editModal('{{ $game->id }}', '{{ $game->label }}', '{{ $game->link }}', '{{ $game->icon }}', '{{ route('admin.billing.edit.game') }}')" class="btn btn-primary btn-sm">Edit</a>
                                  <a data-toggle="modal" data-target="#deleteGameModal" onclick="deleteModal('{{ $game->id }}')" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                              </tr>
                            @endforeach
                          @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="newGameModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="create_game_id" action="{{ route('admin.billing.create.game') }}" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Create Game</h4>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6">
                            <label for="game_" class="form-label">Game Name</label>
                            <input type="text" name="label" id="game_label" class="form-control" required/>
                            <p class="text-muted small">Name of the game</p>
                        </div>

                        <div class="col-md-6">
                            <label for="game_" class="form-label">Icon URL</label>
                            <input type="text" name="icon" id="game_icon" class="form-control" required/>
                            <p class="text-muted small">Icon of game, image must end with an extension</p>
                        </div>

                        <div class="col-md-6">
                            <label for="game_" class="form-label">Game Path / Link</label>
                            <input type="text" name="link" id="game_link" class="form-control" placeholder="example: minecraft" required/>
                            <p class="text-muted small">Must be a single word, for example <code>minecraft</code> with no spaces.</p>
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
function editModal(id, label, link, icon, url){
  document.getElementById('create_game_id').action = url;
  document.getElementById('game_id').value = id;
  document.getElementById('game_label').value = label;
  document.getElementById('game_link').value = link;
  document.getElementById('game_icon').value = icon;
}

function createModal(url){
  document.getElementById('create_game_id').action = url;
  document.getElementById('game_id').value = '';
  document.getElementById('game_label').value = '';
  document.getElementById('game_link').value = '';
  document.getElementById('game_icon').value = '';
}

function deleteModal(id){
  document.getElementById('delete_game_id').value = id;
}

function saveOrder()
{
  var tr = document.querySelectorAll('tr.tr-body');
  var orders = [];
  orders[0] = 'games';
  for (i = 0; i < tr.length; ++i) {
    orders[tr[i].id] = i + 1;
  }
  const url = '{{ route('admin.billing.order') }}';
  fetch(url, {
      method : "POST",
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({order: orders}),
  }).then(
      // response => response.text()
  ).then(
      // html => console.log(html)
  );
}

var row;
function start(){
  row = event.target;
}
function dragover(){
  var e = event;
  e.preventDefault();

  let children= Array.from(e.target.parentNode.parentNode.children);
  if(children.indexOf(e.target.parentNode)>children.indexOf(row))
    e.target.parentNode.after(row);
  else
    e.target.parentNode.before(row);
}

document.addEventListener("dragend", function(event) {
  saveOrder();
}, false);


</script>

@endsection
