{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}


@extends('layouts.admin')
@include('templates.Carbon.billing.admin.nav', ['activeTab' => 'basic'])

@section('title')
Billing
@endsection

@section('content-header')
<h1>Billing Module</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('admin.index') }}">Admin</a></li>
  <li class="active">Billing</li>
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
                  <h3 class="box-title">Global Settings</h3>
              </div>
              <div class="box-body">
                  <div class="row">
                      <div class="form-group col-md-4">
                        <label class="control-label">API key</label>
                          <div>
                              <input type="password" required="" class="form-control" name="api_key" value="@if(isset($settings['api_key'])){{ $settings['api_key'] }}@endif">
                              <p class="text-muted small">REQUIRED: <a href="/admin/api">Create</a></p> 
                          </div>
                      </div>

                      <div class="form-group col-md-4">
                        <label class="control-label">Delete suspended servers</label>
                        <div>
                            <select class="form-control" name="remove_suspendet" id="">
                              @if(isset($settings['remove_suspendet']))
                                <option value="true" @if($settings['remove_suspendet'] == 'true') selected @endif>Enabled</option>
                                <option value="false" @if($settings['remove_suspendet'] == 'false') selected @endif>Disabled</option>
                              @else
                                <option value="true">Enabled</option>
                                <option value="false" selected>Disabled</option>
                              @endif

                            </select>
                            <p class="text-muted small">Suspended servers will be automatically deleted after <code>10</code> days.</p>
                        </div>
                    </div>
                      <div class="form-group col-md-4">
                        <label class="control-label">Schedular / CronTab command:</label>
                        <br><a href="{{ route('admin.billing.schedular') }}" class="btn btn-primary"><span class="label label-success ">Active</span> Force Run Schedular</a>
                        Last Run-Time: {{ Cache::get('bill_scheduler') }}
                      </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-md-4">
                      <label class="control-label">Module Path</label>
                        <div>
                            <input type="text" disabled="" class="form-control" value="{{ config('billing.path') }}">
                            <p class="text-muted small">{{ config('app.url') }}/{{ config('billing.path') }}</p> 
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                      <label class="control-label">Author</label>
                        <div>
                            <input type="text" disabled="" class="form-control" value="{{ config('billing.author') }}">
                            <p class="text-muted small">Developers of the billing module.</p> 
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                      <label class="control-label">Version</label>
                        <div>
                            <input type="text" disabled="" class="form-control" value="{{ config('billing.version') }}">
                            <p class="text-muted small">Current Billing Module version</p> 
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                      <label class="control-label">Portal</label>
                        <div>
                            <input type="text" disabled="" class="form-control" value="@if(config('billing.portal') == "true") Enabled @else Disabled @endif">
                            <p class="text-muted small">Status of portal page</p> 
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                      <label class="control-label">Default Language</label>
                        <div>
                            <input type="text" disabled="" class="form-control" value="{{ config('billing.language') }}">
                            <p class="text-muted small">Default Billing Module Language</p> 
                        </div>
                    </div>
                    
                    <div class="form-group col-md-4">
                      <label class="control-label">Animated Background UUID</label>
                        <div>
                            <input type="text" disabled="" class="form-control" value="{{ config('billing.animation') }}">
                            <p class="text-muted small"><code>https://www.youtube.com/watch?v={{ config('billing.animation') }}</code></p> 
                        </div>
                    </div>
                    <p style="margin-left: 15px;"> Disabled settings can be set in the following file: <code>{{ base_path('config/billing.php') }}</code></p>


                </div>
          <div class="row">
              </div>
           </div>
          </div>

          <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Billing Appearance</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label class="control-label">Billing Logo</label>
                        <div>
                            <input type="text" required="" class="form-control" name="logo" value="@if(isset($settings['logo'])){{ $settings['logo'] }}@else /assets/svgs/pterodactyl.svg @endif">
                            <p class="text-muted small">This is the logo displayed through out the site.</p>
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label class="control-label">Primary Color</label>
                      <div>
                          <input type="text" required="" class="form-control" name="primary_color" value="@if(isset($settings['primary_color'])){{ $settings['primary_color'] }}@else #4723d9 @endif">
                          <p class="text-muted small">This is the primary color of the panel.</p>
                      </div>
                  </div>


                  <div class="form-group col-md-3">
                    <label class="control-label">Plans Background Image URL</label>
                    <div>
                        <input type="text" required="" class="form-control" name="plans_img_url" value="@if(isset($settings['plans_img_url'])){{ $settings['plans_img_url'] }}@else /billing-src/img/plans.png @endif">
                    </div>
                </div>
                
                <div class="form-group col-md-3">
                  <label class="control-label">Preloader</label>
                  <div>
                    <select class="form-control" name="preloader" required>
                      <option value="@if(isset($settings['preloader'])){{ $settings['preloader'] }}@endif" selected="">@isset($settings['preloader'])@if( $settings['preloader'] == "false") Preloader Disabled @else Preloader Enabled  @endif
                        @endisset</option>
                      <option value="true">Enable</option>
                      <option value="false">Disable</option>
                  </select>
                  <p class="text-muted small">Enable preloader on Billing pages?</p>

                  </div>
                </div>

                <div class="form-group col-md-6">
                  <label class="control-label">Profile Background Image URL</label>
                  <div>
                      <input type="text" required="" class="form-control" name="profile_img_url" value="@if(isset($settings['profile_img_url'])){{ $settings['profile_img_url'] }}@else /billing-src/img/profile-background.jpg @endif">
                  </div>
              </div>

              <div class="form-group col-md-6">
                <label class="control-label">Favicon URL</label>
                <div>
                    <input type="text" required="" class="form-control" name="favicon" value="@if(isset($settings['favicon'])){{ $settings['favicon'] }}@else /favicons/favicon-32x32.png @endif">
                </div>
            </div>

            <div class="form-group col-md-12">
              <label class="control-label">About us</label>
              <div>
                  <textarea type="text" required="" class="form-control" name="billing_about_us" value="@if(isset($settings['billing_about_us'])){{ $settings['billing_about_us'] }}@endif">@if(isset($settings['billing_about_us'])){{ $settings['billing_about_us'] }}@endif</textarea>
                  <p class="text-muted small">Write something about your company</p>
              </div>
          </div>

          <div class="form-group col-md-12">
            <label class="control-label">Footer Contact information</label>
            <div>
                <textarea type="text" required="" class="form-control" name="footer_address" value="@if(isset($settings['footer_address'])){{ $settings['footer_address'] }}@endif">@if(isset($settings['footer_address'])){{ $settings['footer_address'] }}@else <p>A108 Adam Street <br>New York, NY 535022<br>United States <br><br><strong>Phone:</strong> +1 5589 55488 55<br><strong>Email:</strong> info@example.com<br></p> @endif</textarea>
                <p class="text-muted small">Write something about your company</p>
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