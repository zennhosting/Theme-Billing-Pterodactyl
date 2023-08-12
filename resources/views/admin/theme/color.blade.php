@extends('layouts.admin')
@include('partials/admin.theme.nav', ['activeTab' => 'color'])

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
            <form action="{{ route('admin.theme.color.update') }}" method="POST">
                <div class="row" style="display:flex;">  
                    <div class="col-md-8">    
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Darkmode colors</h3>
                            </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="control-label">Primary Color</label>
                                            <div>
                                                <input type="color" class="form-control" name="primary" @if(!empty($theme)) value="{{ $theme->primary }}" @endif />
                                                <p class="text-muted"><small>Primary color for the theme.</small></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label">Secondary Color</label>
                                            <div>
                                                <input type="color" class="form-control" name="secondary" @if(!empty($theme)) value="{{ $theme->secondary }}" @endif />
                                                <p class="text-muted"><small>Secondary color for the theme.</small></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label">Background Color</label>
                                            <div>
                                                <input type="color" class="form-control" name="background" @if(!empty($theme)) value="{{ $theme->background }}" @endif />
                                                <p class="text-muted"><small>Background color for the theme.</small></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label">Primary Hover Color</label>
                                            <div>
                                                <input type="color" class="form-control" name="primaryhover" @if(!empty($theme)) value="{{ $theme->primaryhover }}" @endif />
                                                <p class="text-muted"><small>Primary Hover color for the theme.</small></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label">Secondary Hover Color</label>
                                            <div>
                                                <input type="color" class="form-control" name="secondaryhover" @if(!empty($theme)) value="{{ $theme->secondaryhover }}" @endif />
                                                <p class="text-muted"><small>Secondary Hover color for the theme.</small></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-4">
                                            <label class="control-label">Hightlight Color</label>
                                            <div>
                                                <input type="color" class="form-control" name="highlightcolor" @if(!empty($theme)) value="{{ $theme->highlightcolor }}" @endif />
                                                <p class="text-muted"><small>Hightlight color for the theme.</small></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label">Light Color</label>
                                            <div>
                                                <input type="color" class="form-control" name="lightcolor" @if(!empty($theme)) value="{{ $theme->lightcolor }}" @endif />
                                                <p class="text-muted"><small>Light color for the theme.</small></p>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label">Main Color</label>
                                            <div>
                                                <input type="color" class="form-control" name="color" @if(!empty($theme)) value="{{ $theme->color }}" @endif />
                                                <p class="text-muted"><small>Main color for the theme.</small></p>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label">Sub Color</label>
                                            <div>
                                                <input type="color" class="form-control" name="subcolor" @if(!empty($theme)) value="{{ $theme->subcolor }}" @endif />
                                                <p class="text-muted"><small>Sub color for the theme.</small></p>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label">Color #4</label>
                                            <div>
                                                <input type="color" class="form-control" name="color4" @if(!empty($theme)) value="{{ $theme->color4 }}" @endif />
                                                <p class="text-muted"><small>Color #4 for the theme.</small></p>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label">Color #5</label>
                                            <div>
                                                <input type="color" class="form-control" name="color5" @if(!empty($theme)) value="{{ $theme->color5 }}" @endif />
                                                <p class="text-muted"><small>Color #5 for the theme.</small></p>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label">Color #6</label>
                                            <div>
                                                <input type="color" class="form-control" name="color6" @if(!empty($theme)) value="{{ $theme->color6 }}" @endif />
                                                <p class="text-muted"><small>Color #6 for the theme.</small></p>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label">Dark Color</label>
                                            <div>
                                                <input type="color" class="form-control" name="dark" @if(!empty($theme)) value="{{ $theme->dark }}" @endif />
                                                <p class="text-muted"><small>Dark color for the theme.</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    {!! csrf_field() !!}
                                    <button type="submit" class="btn btn-sm btn-primary pull-right">Save</button>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="width:100%;height:calc(100% - 20px);background-color:{{ $theme->background }};border-radius:{{ $theme->borderradius }}px;padding:50px;">
                            <div style="width:100%;background-color:{{ $theme->secondary }};border-radius:{{ $theme->borderradius }}px;padding:25px;">
                                <div style="width:100%;background-color:{{ $theme->primary }};border-radius:{{ $theme->borderradius }}px;padding:10px;text-align:center;color:white;">
                                    BUTTON
                                </div>
                                <div style="width:100%;background-color:{{ $theme->textbutton }};border-radius:{{ $theme->borderradius }}px;padding:10px;text-align:center;margin-top:10px;color:white;">
                                    BUTTON
                                </div>
                                <div style="width:100%;background-color:{{ $theme->dangerbutton }};border-radius:{{ $theme->borderradius }}px;padding:10px;text-align:center;margin-top:10px;color:white;">
                                    BUTTON
                                </div>
                                <input style="width:100%;background-color:{{ $theme->input }};border-radius:{{ $theme->borderradius }}px;padding:10px;margin-top:10px;border:none;color:white;" placeholder="Input" value="Type area"/>
                                <h2 style="color:{{ $theme->highlightcolor }};">Hightlight Color<h2>
                                <h3 style="color:{{ $theme->lightcolor }};">Light Color<h3>
                                <h4 style="color:{{ $theme->color }};">Main color<h4>
                                <h5 style="color:{{ $theme->subcolor }};">Sub color<h5>
                                <p style="color:{{ $theme->color4 }};">Color #4<p>
                                <p style="color:{{ $theme->color5 }};">Color #5<p>
                                <small style="color:{{ $theme->color6 }};display:block;">Color #6</small>
                                <small style="color:{{ $theme->dark }};">Dark color</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="display:flex;">
                    <div class="col-md-8">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Lightmode colors</h3>
                            </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="control-label">Primary Color</label>
                                            <div>
                                                <input type="color" class="form-control" name="lprimary" @if(!empty($theme)) value="{{ $theme->lprimary }}" @endif />
                                                <p class="text-muted"><small>Primary color for the theme.</small></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label">Secondary Color</label>
                                            <div>
                                                <input type="color" class="form-control" name="lsecondary" @if(!empty($theme)) value="{{ $theme->lsecondary }}" @endif />
                                                <p class="text-muted"><small>Secondary color for the theme.</small></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label">Background Color</label>
                                            <div>
                                                <input type="color" class="form-control" name="lbackground" @if(!empty($theme)) value="{{ $theme->lbackground }}" @endif />
                                                <p class="text-muted"><small>Background color for the theme.</small></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label">Primary Hover Color</label>
                                            <div>
                                                <input type="color" class="form-control" name="lprimaryhover" @if(!empty($theme)) value="{{ $theme->lprimaryhover }}" @endif />
                                                <p class="text-muted"><small>Primary Hover color for the theme.</small></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label">Secondary Hover Color</label>
                                            <div>
                                                <input type="color" class="form-control" name="lsecondaryhover" @if(!empty($theme)) value="{{ $theme->lsecondaryhover }}" @endif />
                                                <p class="text-muted"><small>Secondary Hover color for the theme.</small></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-4">
                                            <label class="control-label">Hightlight Color</label>
                                            <div>
                                                <input type="color" class="form-control" name="lhighlightcolor" @if(!empty($theme)) value="{{ $theme->lhighlightcolor }}" @endif />
                                                <p class="text-muted"><small>Hightlight color for the theme.</small></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label">Light Color</label>
                                            <div>
                                                <input type="color" class="form-control" name="llightcolor" @if(!empty($theme)) value="{{ $theme->llightcolor }}" @endif />
                                                <p class="text-muted"><small>Light color for the theme.</small></p>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label">Main Color</label>
                                            <div>
                                                <input type="color" class="form-control" name="lcolor" @if(!empty($theme)) value="{{ $theme->lcolor }}" @endif />
                                                <p class="text-muted"><small>Main color for the theme.</small></p>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label">Sub Color</label>
                                            <div>
                                                <input type="color" class="form-control" name="lsubcolor" @if(!empty($theme)) value="{{ $theme->lsubcolor }}" @endif />
                                                <p class="text-muted"><small>Sub color for the theme.</small></p>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label">Color #4</label>
                                            <div>
                                                <input type="color" class="form-control" name="lcolor4" @if(!empty($theme)) value="{{ $theme->lcolor4 }}" @endif />
                                                <p class="text-muted"><small>Color #4 for the theme.</small></p>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label">Color #5</label>
                                            <div>
                                                <input type="color" class="form-control" name="lcolor5" @if(!empty($theme)) value="{{ $theme->lcolor5 }}" @endif />
                                                <p class="text-muted"><small>Color #5 for the theme.</small></p>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label">Color #6</label>
                                            <div>
                                                <input type="color" class="form-control" name="lcolor6" @if(!empty($theme)) value="{{ $theme->lcolor6 }}" @endif />
                                                <p class="text-muted"><small>Color #6 for the theme.</small></p>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label">Dark Color</label>
                                            <div>
                                                <input type="color" class="form-control" name="ldark" @if(!empty($theme)) value="{{ $theme->ldark }}" @endif />
                                                <p class="text-muted"><small>Dark color for the theme.</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    {!! csrf_field() !!}
                                    <button type="submit" class="btn btn-sm btn-primary pull-right">Save</button>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="width:100%;height:calc(100% - 20px);background-color:{{ $theme->lbackground }};border-radius:{{ $theme->borderradius }}px;padding:50px;">
                            <div style="width:100%;background-color:{{ $theme->lsecondary }};border-radius:{{ $theme->borderradius }}px;padding:25px;">
                                <div style="width:100%;background-color:{{ $theme->lprimary }};border-radius:{{ $theme->borderradius }}px;padding:10px;text-align:center;color:white;">
                                    BUTTON
                                </div>
                                <div style="width:100%;background-color:{{ $theme->ltextbutton }};border-radius:{{ $theme->borderradius }}px;padding:10px;text-align:center;margin-top:10px;color:black;">
                                    BUTTON
                                </div>
                                <div style="width:100%;background-color:{{ $theme->ldangerbutton }};border-radius:{{ $theme->borderradius }}px;padding:10px;text-align:center;margin-top:10px;color:white;">
                                    BUTTON
                                </div>
                                <input style="width:100%;background-color:{{ $theme->linput }};border-radius:{{ $theme->borderradius }}px;padding:10px;margin-top:10px;border:none;color:black;" placeholder="Input" value="Type area"/>
                                <h2 style="color:{{ $theme->lhighlightcolor }};">Hightlight Color<h2>
                                <h3 style="color:{{ $theme->llightcolor }};">Light Color<h3>
                                <h4 style="color:{{ $theme->lcolor }};">Main color<h4>
                                <h5 style="color:{{ $theme->lsubcolor }};">Sub color<h5>
                                <p style="color:{{ $theme->lcolor4 }};">Color #4<p>
                                <p style="color:{{ $theme->lcolor5 }};">Color #5<p>
                                <small style="color:{{ $theme->lcolor6 }};display:block;">Color #6</small>
                                <small style="color:{{ $theme->ldark }};">Dark color</small>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
