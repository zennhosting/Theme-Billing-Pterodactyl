{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}


@extends('layouts.admin')
@include('templates.Carbon.billing.admin.nav', ['activeTab' => 'emails'])

@section('title')
Emails
@endsection

@section('content-header')
<h1>Billing Email System</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('admin.index') }}">Admin</a></li>
  <li><a href="{{ route('admin.billing') }}">Billing Module</a></li>
  <li class="active">Emails</li>
</ol>
@endsection



@section('content')
@yield('billing::nav')

<div class="row">

  <div class="col-xs-4">

        <div class="box">
          <div class="box-header with-border">
              <h3 class="box-title">Email to a specific user</h3>
          </div>
          <div class="box-body">
              <div class="row">
                
                    <div class="form-group col-md-12">
                      <label class="control-label">Enter Username</label>
                      <div>
                          <input type="text" class="form-control" id="user_name" value="{{ Auth::user()->username }}">
                          <p class="text-muted small">Enter the name of the emailer.</p>
                      </div>
                  </div>

                    <div class="form-group col-md-12">
                      <label class="control-label">Enter Email Address</label>
                      <div>
                          <input type="email" class="form-control" id="user_email" value="{{ Auth::user()->email }}">
                          <p class="text-muted small">Enter the email address you want to send the email to.</p>
                      </div>
                  </div>

                  </div>
                  <a onClick="SendMail()" class="btn btn-primary" style="width: 100%;">Compose Email</a>

                </div>
              </div>
    </div>

  <div class="col-xs-8">
      <form action="{{ route('admin.billing.emails.send') }}" method="POST">
        @csrf

          <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Send emails to all users.</h3>
            </div>
            <div class="box-body">
                <div class="row">

                      <div class="form-group col-md-12">
                        <label class="control-label">All User Email Addresses</label>
                        <div>
                            <input type="text" required="" disabled class="form-control" value="@foreach (Bill::users()->getAllUsers() as $user)@if(isset($user['ptero']['email'])){{ $user['ptero']['email'] }}, @endif @endforeach">
                            <p class="text-muted small">All emails registered to Billing Module</p>
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                      <label class="control-label">Email Subject</label>
                      <div>
                          <input type="text" required="" class="form-control" name="subject" value="{{ config('mail.from.name') }}">
                          <p class="text-muted small">Subject of the email</p>
                      </div>
                  </div>

                  <div class="form-group col-md-12">
                    <label class="control-label">Email Message</label>
                    <div>
                        <textarea type="text" required="" class="form-control" rows="5" id="#editable" name="intro_message" placeholder="We are emailing you to inform that..."></textarea>
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
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#EmailModal" style="width: 100%">
                      Send Emails
                    </button>
                  </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="EmailModal" tabindex="-1" role="dialog" aria-labelledby="EmailModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="EmailModalLabel">Are you sure?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="alert alert-info" role="alert">
                  Note: Completing this action will send all users on your panel an email. <br>
                  Emails: 
                  <br>@foreach (Bill::users()->getAllUsers() as $user) @if(isset($user['ptero']['email']))<code>{{ $user['ptero']['email'] }}</code>, @endif @endforeach
                </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-default btn-sm pull-left" data-dismiss="modal">Close</button>
                <button type="submit" name="_method"  class="btn btn-primary">Send Emails</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal End -->

      </form>
  </div>

</div>



@endsection

<script>
  function SendMail() {
    var user = document.getElementById("user_name").value;
    var mail = document.getElementById("user_email").value;
  
    let url_build = user.concat('/', mail);
    window.location.href = "/billing/admin/email/" + url_build;
  }
  
  </script>