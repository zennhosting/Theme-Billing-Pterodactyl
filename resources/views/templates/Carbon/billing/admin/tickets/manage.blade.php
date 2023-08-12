{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}


@extends('layouts.admin')
@include('templates.Carbon.billing.admin.nav', ['activeTab' => 'tickets'])

@section('title')
Tickets
@endsection

@section('content-header')
<h1>Billing Tickets</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('admin.index') }}">Admin</a></li>
  <li><a href="{{ route('admin.billing') }}">Billing Module</a></li>
  <li class="active">Tickets</li>
</ol>
@endsection



@section('content')
@yield('billing::nav')

<div class="row">
<div class="col-sm-3">
    <div class="box @if($ticket->status == 'Closed') box-danger @else box-success @endif">
        <div class="box-header with-border">
            <h3 class="box-title">#{{ $ticket->uuid }}</h3>
        </div>
        <div class="box-body">
            <p class="text-muted">
                <span class="card-small-icon"><i class="fas fa-solid fa-check"></i></span>User: {{ $user->username }} (<a href="/admin/users/view/{{$user->id}}">{{  $user->email }}</a>)<br>
                <span class="card-small-icon"><i class="fas fa-solid fa-check"></i></span>Subject: {{$ticket->subject}} <br>
                <span class="card-small-icon"><i class="fas fa-solid fa-check"></i></span>Service: {{ $ticket->service }} <br>
                <span class="card-small-icon"><i class="fas fa-solid fa-check"></i></span>Priority: {{ $ticket->priority }} <br>
                <span class="card-small-icon"><i class="fas fa-solid fa-check"></i></span>Status: <span class="label  @if($ticket->status == 'Closed') label-danger @elseif($ticket->status == 'Open') label-success @else label-success @endif ">{{ $ticket->status }}</span> <br>

            </p>
        </div>
        <div class="box-footer">
            <a href="{{ route('tickets.switch', $ticket->uuid) }}" class="btn btn-sm btn-default w-100">Toggle Status</a>
            <a href="#" onClick="deleteTicket('{{ route('tickets.delete', $ticket->uuid) }}')" class="btn btn-sm btn-danger w-100" style="margin-top: 15px;">Delete Ticket</a>
        </div>
    </div>
</div>

<div class="col-xs-9">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Ticket Responses</h3>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border"><h3 class="box-title"><img alt="Image" src="https://www.gravatar.com/avatar/{{ md5(strtolower(Auth::user()->email)) }}?s=160" style="width: 32px; border-radius: 8px; margin-right: 10px;" >{{ Auth::user()->username }} @if(Auth::user()->root_admin)<span class="label label-danger">Admin</span>@else <span class="label label-primary">Client</span> @endif </h3></div>
            <div class="box-body">

                <form action="{{ route('tickets.manage.response', ['uuid' => $ticket->uuid]) }}" method="POST">
                  @csrf
                  <label class="form-control-label">Message</label>
                  <textarea required name="response"><code></code></textarea>
                  <div class="col-md-12" style="display: flex;justify-content: flex-end;">
                  </div>
            </div>
            <div class="box-footer text-right">
            <button type="submit" class="btn btn-primary mt-4" style="width: 15%">Send</button>

            </div>
        </div>
        </form>
    </div>

@php
use Pterodactyl\Models\User;
@endphp
@foreach($responses as $response)
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border"><h3 class="box-title"><img alt="Image" src="https://www.gravatar.com/avatar/{{ md5(strtolower(User::findOrFail($response->user_id)->email)) }}?s=160" style="width: 32px; border-radius: 8px; margin-right: 10px;" >{{ User::findOrFail($response->user_id)->username }} @if(User::findOrFail($response->user_id)->root_admin)<span class="label label-danger">Admin</span>@else <span class="label label-primary">Client</span> @endif </h3></div>
            <div class="box-body">
                {!! $response->response !!}
            </div>
            <div class="box-footer">
                <p class="no-margin text-muted small"><strong>Replied: {{ $response->created_at->diffForHumans() }}</strong> </p>
            </div>
        </div>
    </div>
@endforeach

    <div class="d-flex justify-content-center">
        {{ Bill::tickets()->response()->where('uuid', $ticket->uuid)->latest()->paginate(5)->links() }}
    </div>
</div>
</div>


  <script src="https://cdn.tiny.cloud/1/qagffr3pkuv17a8on1afax661irst1hbr4e6tbv888sz91jc/tinymce/4/tinymce.min.js"></script>
  <script>
    
    function deleteTicket(url)
    {
        if (confirm('Are you sure you want to delete this ticket?') == true) {
            window.location.href = url;
        }
    }

    tinymce.init({
      selector: 'textarea'
      , height: 150
      , theme: 'modern'
      , plugins: 'print preview fullpage powerpaste searchreplace autolink directionality advcode visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount tinymcespellchecker a11ychecker imagetools mediaembed  linkchecker contextmenu colorpicker textpattern help'
      , toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat'
      , image_advtab: true,

      content_css: [
        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i'
        , '//www.tinymce.com/css/codepen.min.css'
      ]
    });

  </script>

  <style>
    div#mceu_39 {
      display: none;
    }

  </style>
@endsection
