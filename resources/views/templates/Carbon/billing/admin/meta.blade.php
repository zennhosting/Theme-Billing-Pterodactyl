{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}


@extends('layouts.admin')
@include('templates.Carbon.billing.admin.nav', ['activeTab' => 'meta'])

@section('title')
Meta
@endsection

@section('content-header')
<h1>Billing Meta Configuration</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('admin.index') }}">Admin</a></li>
  <li><a href="{{ route('admin.billing') }}">Billing Module</a></li>
  <li class="active">Meta</li>
</ol>
@endsection



@section('content')
@yield('billing::nav')

<div class="row">
  <div class="col-xs-12">
      <form action="{{ route('admin.billing.set.settings') }}" method="POST">
        @csrf

          <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Meta Configuration</h3>
            </div>
            <div class="box-body">
                <div class="row">
                  

                      <div class="form-group col-md-4">
                        <label class="control-label">Title</label>
                        <div>
                            <input type="text" required="" class="form-control" name="meta_title" value="@if(isset($settings['meta_title'])){{ $settings['meta_title'] }}@else {{ config('app.name') }} @endif">
                            <p class="text-muted small"> </p>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                      <label class="control-label">Image URL</label>
                      <div>
                          <input type="text" required="" class="form-control" name="meta_image" value="@if(isset($settings['meta_image'])){{ $settings['meta_image'] }}@else https://cdn.resourcemc.net/zAsa7/rIBOyeRU58.png/raw @endif">
                          <p class="text-muted small"> </p>
                      </div>
                  </div>

                  <div class="form-group col-md-4">
                    <label class="control-label">Theme Color</label>
                    <div>
                        <input type="text" required="" class="form-control" name="meta_color" value="@if(isset($settings['meta_color'])){{ $settings['meta_color'] }}@else #0967d3 @endif">
                        <p class="text-muted small"> </p>
                    </div>
                </div>
                    
                    <div class="form-group col-md-12">
                        <label class="control-label">Meta Description</label>
                        <div>
                          <textarea name="meta_desc" rows="3" class="form-control" required> @if(isset($settings['meta_desc'])){{ $settings['meta_desc'] }}@else Manage your server with an easy-to-use Panel @endif</textarea>
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