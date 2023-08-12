@extends('layouts.admin')

@section('title')
GMD Settings 
@endsection

@section('content-header')
<h1>GMD Settings</h1><small>General Settings Gigabait & Mubeen Development Addons</small>
<ol class="breadcrumb">
  <li><a href="{{ route('admin.index') }}">Admin</a></li>
  <li class="active"><a href="{{ route('admin.gmd') }}">GMD</a></li>
</ol>
@endsection

@section('content')

<div class="row">
  <div class="col-xs-12">
      <div class="nav-tabs-custom nav-tabs-floating">
          <ul class="nav nav-tabs">
              <li class="@if(!isset($activeTab))active @endif"><a href="{{ route('admin.gmd') }}"><i class="fa fa-delicious"></i> Templatas</a></li>
          </ul>
      </div>
    </div>
</div>

<form action="{{ route('set_template') }}" method="POST">
  @csrf
  <div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Active Template</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="form-group col-md-5">
                <select class="form-control" name="set_template">
                    @foreach($templates_list as $value)
                      <option value="{{ $value }}" @if($template == $value) selected @endif>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn btn-primary">Save</button>
        </div>
     </div>
  </div>
</form>

@endsection