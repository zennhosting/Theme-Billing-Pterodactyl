@extends('layouts.admin')
@include('partials/admin.theme.nav', ['activeTab' => 'meta'])

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
                    <h3 class="box-title">Meta tags settings</h3>
                </div>
                <form action="{{ route('admin.theme.meta.update') }}" method="POST">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Meta Tags title</label>
                                <div>
                                    <input id="logo" type="text" class="form-control" name="title" @if(!empty($theme)) value="{{ $theme->title }}" @endif required />
                                    <p class="text-muted"><small>The embed title.</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Meta Tags discription</label>
                                <div>
                                    <textarea id="logo" type="text" class="form-control" name="discription" required>@if(!empty($theme)){{$theme->discription}}@endif</textarea>
                                    <p class="text-muted"><small>The embed discription.</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Meta Tags color</label>
                                <div>
                                    <input type="color" class="form-control" name="metacolor" @if(!empty($theme)) value="{{ $theme->metacolor }}" @endif />
                                    <p class="text-muted"><small>The embed title.</small></p>
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
