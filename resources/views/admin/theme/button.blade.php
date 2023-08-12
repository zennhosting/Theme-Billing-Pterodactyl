@extends('layouts.admin')
@include('partials/admin.theme.nav', ['activeTab' => 'button'])

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
            <form action="{{ route('admin.theme.button.update') }}" method="POST">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">General Settings</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="control-label">Button & input border radius (in px)</label>
                                <div>
                                    <input type="text" class="form-control" name="borderradius" @if(!empty($theme)) value="{{ $theme->borderradius }}" @endif />
                                    <p class="text-muted"><small>Change the button and input border radius.</small></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Input dark mode</label>
                                <div>
                                    <input type="color" class="form-control" name="input" @if(!empty($theme)) value="{{ $theme->input }}" @endif />
                                    <p class="text-muted"><small>Change the input background color.</small></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Input light mode</label>
                                <div>
                                    <input type="color" class="form-control" name="linput" @if(!empty($theme)) value="{{ $theme->linput }}" @endif />
                                    <p class="text-muted"><small>Change the input background color.</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-sm btn-primary pull-right">Save</button>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Primary Button</h3>
                    </div>
                    <div class="box-body">
                        <p>The changes you do on this page will also change the primary color for the other elements, which you can change at the color tab</p>
                        <div class="row" style="margin-top:25px;">
                            <div class="col-md-12">
                                <h4>Primary Button in dark mode</h4>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Background color</label>
                                <div>
                                    <input type="color" class="form-control" name="primary" @if(!empty($theme)) value="{{ $theme->primary }}" @endif />
                                    <p class="text-muted"><small>Background color for the primary button.</small></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Background color when hover</label>
                                <div>
                                    <input type="color" class="form-control" name="primaryhover" @if(!empty($theme)) value="{{ $theme->primaryhover }}" @endif />
                                    <p class="text-muted"><small>Background when hover color for the primary button.</small></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Button example:</label>
                                <div style="background-color:{{ $theme->primary }};border-radius:{{ $theme->borderradius }}px;padding:1rem 1.5rem;color:white;">
                                    Primary Button
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Primary Button in light mode</h4>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Background color</label>
                                <div>
                                    <input type="color" class="form-control" name="lprimary" @if(!empty($theme)) value="{{ $theme->lprimary }}" @endif />
                                    <p class="text-muted"><small>Background color for the primary button in lightmode.</small></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Background color when hover</label>
                                <div>
                                    <input type="color" class="form-control" name="lprimaryhover" @if(!empty($theme)) value="{{ $theme->lprimaryhover }}" @endif />
                                    <p class="text-muted"><small>Background when hover color for the primary button in lightmode.</small></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Button example:</label>
                                <div style="background-color:{{ $theme->lprimary }};border-radius:{{ $theme->borderradius }}px;padding:1rem 1.5rem;color:white;">
                                    Primary Button
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-sm btn-primary pull-right">Save</button>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Secondary Button</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Secondary Button in dark mode</h4>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Background color</label>
                                <div>
                                    <input type="color" class="form-control" name="textbutton" @if(!empty($theme)) value="{{ $theme->textbutton }}" @endif />
                                    <p class="text-muted"><small>Background color for the secondary button.</small></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Background color when hover</label>
                                <div>
                                    <input type="color" class="form-control" name="textbuttonhover" @if(!empty($theme)) value="{{ $theme->textbuttonhover }}" @endif />
                                    <p class="text-muted"><small>Background when hover color for the secondary button.</small></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Button example:</label>
                                <div style="background-color:{{ $theme->textbutton }};border-radius:{{ $theme->borderradius }}px;padding:1rem 1.5rem;color:white;">
                                    Secondary Button
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Secondary Button in light mode</h4>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Background color</label>
                                <div>
                                    <input type="color" class="form-control" name="ltextbutton" @if(!empty($theme)) value="{{ $theme->ltextbutton }}" @endif />
                                    <p class="text-muted"><small>Background color for the secondary button in light mode.</small></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Background color when hover</label>
                                <div>
                                    <input type="color" class="form-control" name="ltextbuttonhover" @if(!empty($theme)) value="{{ $theme->ltextbuttonhover }}" @endif />
                                    <p class="text-muted"><small>Background when hover color for the secondary button light mode.</small></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Button example:</label>
                                <div style="background-color:{{ $theme->ltextbutton }};border-radius:{{ $theme->borderradius }}px;padding:1rem 1.5rem;color:black;">
                                    Secondary Button
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-sm btn-primary pull-right">Save</button>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Danger Button</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Danger Button in dark mode</h4>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Background color</label>
                                <div>
                                    <input type="color" class="form-control" name="dangerbutton" @if(!empty($theme)) value="{{ $theme->dangerbutton }}" @endif />
                                    <p class="text-muted"><small>Background color for the danger button.</small></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Background color when hover</label>
                                <div>
                                    <input type="color" class="form-control" name="dangerbuttonhover" @if(!empty($theme)) value="{{ $theme->dangerbuttonhover }}" @endif />
                                    <p class="text-muted"><small>Background when hover color for the danger button.</small></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Button example:</label>
                                <div style="background-color:{{ $theme->dangerbutton }};border-radius:{{ $theme->borderradius }}px;padding:1rem 1.5rem;color:white;">
                                    Danger Button
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Danger Button in light mode</h4>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Background color</label>
                                <div>
                                    <input type="color" class="form-control" name="ldangerbutton" @if(!empty($theme)) value="{{ $theme->ldangerbutton }}" @endif />
                                    <p class="text-muted"><small>Background color for the danger button in light mode.</small></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Background color when hover</label>
                                <div>
                                    <input type="color" class="form-control" name="ldangerbuttonhover" @if(!empty($theme)) value="{{ $theme->ldangerbuttonhover }}" @endif />
                                    <p class="text-muted"><small>Background when hover color for the danger button in light mode.</small></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Button example:</label>
                                <div style="background-color:{{ $theme->ldangerbutton }};border-radius:{{ $theme->borderradius }}px;padding:1rem 1.5rem;color:white;">
                                    Danger Button
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
