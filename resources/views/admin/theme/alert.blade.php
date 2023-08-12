@extends('layouts.admin')
@include('partials/admin.theme.nav', ['activeTab' => 'alert'])

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
                    <h3 class="box-title">Alert settings</h3>
                </div>
                <form action="{{ route('admin.theme.alert.update') }}" method="POST">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Type of alert</label>
                                <div>
                                    <select class="form-control" name="typealert">
                                        <option value="disabled" @if(!empty($theme) && $theme->typealert === 'disabled') selected @endif>disabled</option>
                                        <option value="info" @if(!empty($theme) && $theme->typealert === 'info') selected @endif>Info</option>
                                        <option value="warning" @if(!empty($theme) && $theme->typealert === 'warning') selected @endif>Warning</option>
                                        <option value="error" @if(!empty($theme) && $theme->typealert === 'error') selected @endif>Error</option>
                                        <option value="success" @if(!empty($theme) && $theme->typealert === 'success') selected @endif>Success</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-8">
                                <label class="control-label">Alert description</label>
                                <div>
                                    <textarea id="logo" type="text" class="form-control" name="alertdescription" required>@if(!empty($theme)){{$theme->alertdescription}}@endif</textarea>
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
