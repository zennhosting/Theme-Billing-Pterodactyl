@extends('layouts.admin')
@include('partials/admin.theme.nav', ['activeTab' => 'theme'])

@section('title')
    Theme Settings
@endsection

@section('content-header')
    <h1>Theme Settings<small>Configure Pterodactyl to your liking.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="active">Theme</li>
    </ol>
@endsection

@section('content')
    @yield('theme::nav')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Theme Settings</h3>
                </div>
                <form action="{{ route('admin.theme.update') }}" method="POST">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Small logo</label>
                                <div>
                                    <input id="logo" type="text" class="form-control" name="logo" @if(!empty($theme)) value="{{ $theme->logo }}" @endif required />
                                    <p class="text-muted"><small>The logo of the company for the theme.</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Background Image</label>
                                <div>
                                    <input id="logo" type="text" class="form-control" name="backgroundimage" @if(!empty($theme)) value="{{ $theme->backgroundimage }}" @endif required />
                                    <p class="text-muted"><small>The background image for the theme.</small></p>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="box-footer">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-sm btn-primary pull-right">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
