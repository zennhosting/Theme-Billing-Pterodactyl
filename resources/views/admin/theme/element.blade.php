@extends('layouts.admin')
@include('partials/admin.theme.nav', ['activeTab' => 'element'])

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
            <form action="{{ route('admin.theme.element.update') }}" method="POST">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">General Settings</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Top info element</label>
                                <div>
                                    <select class="form-control" name="infoelement">
                                        <option value="1" @if(empty($theme) || $theme->infoelement) selected @endif>Enabled</option>
                                        <option value="0" @if(!empty($theme) && !$theme->infoelement) selected @endif>Disabled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Type of serverlist</label>
                                <div>
                                    <select class="form-control" name="newserverlist">
                                        <option value="table" >Table</option>
                                        <option value="cards" @if(!empty($theme) && $theme->newserverlist === 'cards') selected @endif>Cards</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">SubNavigation bar</label>
                                <div>
                                    <select class="form-control" name="subnavigation">
                                        <option value="1" @if(empty($theme) || $theme->subnavigation) selected @endif>Enabled</option>
                                        <option value="0" @if(!empty($theme) && !$theme->subnavigation) selected @endif>Disabled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Side Graph</label>
                                <div>
                                    <select class="form-control" name="sidegraph">
                                        <option value="1" @if(empty($theme) || $theme->sidegraph) selected @endif>Enabled</option>
                                        <option value="0" @if(!empty($theme) && !$theme->sidegraph) selected @endif>Disabled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Stat Cards</label>
                                <div>
                                    <select class="form-control" name="graphcard">
                                        <option value="1" @if(empty($theme) || $theme->graphcard) selected @endif>Enabled</option>
                                        <option value="0" @if(!empty($theme) && !$theme->graphcard) selected @endif>Disabled</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-sm btn-primary pull-right">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
