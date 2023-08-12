@extends('layouts.admin')
@include('partials/admin.theme.nav', ['activeTab' => 'social'])

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
                    <h3 class="box-title">Social Manager</h3>
                </div>
                <form action="{{ route('admin.theme.social.update') }}" method="POST">
                    <div class="box-body">
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label class="control-label">Website link</label>
                                <div>
                                    <input id="logo" type="text" class="form-control" name="website" @if(!empty($theme)) value="{{ $theme->website }}" @endif required />
                                    <p class="text-muted"><small>File in 'none' to disable this option.</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Discord link</label>
                                <div>
                                    <input id="logo" type="text" class="form-control" name="discord" @if(!empty($theme)) value="{{ $theme->discord }}" @endif required />
                                    <p class="text-muted"><small>File in 'none' to disable this option.</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Billing link</label>
                                <div>
                                    <input id="logo" type="text" class="form-control" name="billing" @if(!empty($theme)) value="{{ $theme->billing }}" @endif required />
                                    <p class="text-muted"><small>File in 'none' to disable this option.</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Status link</label>
                                <div>
                                    <input id="logo" type="text" class="form-control" name="status" @if(!empty($theme)) value="{{ $theme->status }}" @endif required />
                                    <p class="text-muted"><small>File in 'none' to disable this option.</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Knowledgebase link</label>
                                <div>
                                    <input id="logo" type="text" class="form-control" name="knowledgebase" @if(!empty($theme)) value="{{ $theme->knowledgebase }}" @endif required />
                                    <p class="text-muted"><small>File in 'none' to disable this option.</small></p>
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
