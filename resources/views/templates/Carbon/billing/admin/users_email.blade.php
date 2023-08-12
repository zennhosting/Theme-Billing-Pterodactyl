{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}


@extends('layouts.admin')
@include('templates.Carbon.billing.admin.nav', ['activeTab' => 'users'])

@section('title')
Users
@endsection

@section('content-header')
<h1>Billing Email System</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('admin.index') }}">Admin</a></li>
  <li><a href="{{ route('admin.billing') }}">Billing Module</a></li>
  <li><a href="{{ route('admin.billing.users') }}">Users</a></li>
  <li><a href="{{ route('admin.billing.users') }}">{{$email}}</a></li>
  <li class="active">Email</li>
</ol>
@endsection



@section('content')
@yield('billing::nav')

<div class="row">
  <div class="col-xs-12">
      <form action="{{ route('admin.billing.user.email.post') }}" method="POST">
        @csrf

          <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Sending email to {{$name}}</h3>
            </div>
            <div class="box-body">
                <div class="row">
                  
                      <div class="form-group col-md-6">
                        <label class="control-label">Username</label>
                        <div>
                            <input type="text" required="" class="form-control" name="name" value="{{ $name }}">
                            <p class="text-muted small">The name the user is greeted with in the email.</p>
                        </div>
                    </div>

                      <div class="form-group col-md-6">
                        <label class="control-label">Receiver Email Address</label>
                        <div>
                            <input type="text" required="" class="form-control" name="receiver" value="{{ $email }}">
                            <p class="text-muted small">Enter the email address you want to send the email to.</p>
                        </div>
                    </div>

                  <div class="form-group col-md-12">
                    <label class="control-label">Email Message</label>
                    <div>
                        <textarea type="text" required="" class="form-control" name="intro_message" placeholder="We are emailing you to inform that..."></textarea>
                        <p class="text-muted small">Body of the email HTML is enabled.</p>
                    </div>
                </div>

                <div class="form-group col-md-6">
                  <label class="control-label">Email Button Name</label>
                  <div>
                      <input type="text" required="" class="form-control" name="button_name" value="{{ config('app.name') }}">
                      <p class="text-muted small">Name of the button</p>
                  </div>
              </div>
              
              <div class="form-group col-md-6">
                <label class="control-label">Email Button URL</label>
                <div>
                  <input type="text" required="" class="form-control" name="button_URL" value="{{ config('app.url') }}">
                  <p class="text-muted small">Set the URL that the button should prompt to</p>
                </div>
            </div>

            <div class="form-group col-md-12">
              <label class="control-label">Email Footer Message</label>
              <div>
                  <textarea type="text" required="" class="form-control" name="outro_message" placeholder="Looking forward hearing from you..."></textarea>
                  <p class="text-muted small">Bottom part of the email HTML is enabled.</p>
              </div>
          </div>

                    </div>
                  </div>
                </div>
            </div>
        </div>
          
          <div class="box box-primary">
              <div class="box-footer">
                  <button type="submit" name="_method"  class="btn btn-sm btn-primary pull-right">Save</button>
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