{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}


@extends('layouts.admin')
@include('templates.Carbon.billing.admin.nav', ['activeTab' => 'pages'])

@section('title')
Custom Pages
@endsection

@section('content-header')
    <h1>Pages</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.billing') }}">Billing Module</a></li>
        <li class="active">Custom Pages</li>
    </ol>
@endsection

@section('content')
@yield('billing::nav')

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Pages</h3>
                <div class="box-tools">
                    <a class="btn btn-sm btn-primary" href="{{ route('admin.billing.pages.new') }}">Create New</a>
                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th>URL</th>
                            {{-- <th>Auth</th> --}}
                            <th class="text-right">Actions</th>
                        </tr>
                        @if(isset($pages))
                          @foreach($pages as $key => $page)
                          <tr class="tr-body" id="{{ $page->id }}" draggable='true' ondragstart='start()' ondragover='dragover()'>
                              <td><code>{{ $page->id }}</code></td>
                              <td>{{ $page->url }}</td>
                              {{-- <td>@if($page->auth == 1) Enable @else Disable @endif</td> --}}
                              <td class="text-right">
                                <a class="btn btn-info btn-sm"> <i class="fa fa-solid fa-sort"></i> </a>
                                <a href="{{ route('billing.custom.page', ['page' => $page->url]) }}" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-external-link-alt"></i></a>
                                <a href="{{ route('admin.billing.pages.edit', ['id' => $page->id]) }}" class="btn btn-primary btn-sm">Edit</a>
                                <a onclick="deleteModal('{{ $page->id }}')" data-toggle="modal" data-target="#deletePageModal" class="btn btn-danger btn-sm">Delete</a>
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


<div class="modal fade" id="deletePageModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <form id="create_game_id" action="{{ route('admin.billing.pages.delete') }}" method="POST">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Delete Page</h4>
              </div>
              <div class="modal-body">
             
                    <strong class="text-center">Are you sure?</strong> 
            
              </div>
              <div class="modal-footer">
                  {!! csrf_field() !!}
                  <input type="hidden" id="delete_page_id" name="page_id" value="">
                  <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-success btn-sm">Submit</button>
              </div>
          </form>
      </div>
  </div>
</div>


<script>  
  function deleteModal(id){
    document.getElementById('delete_page_id').value = id;
  }

  function saveOrder()
  {
    var tr = document.querySelectorAll('tr.tr-body');
    var orders = [];
    orders[0] = 'pages';
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
    ).then(
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
