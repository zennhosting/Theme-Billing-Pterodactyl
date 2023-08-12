{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}


@extends('layouts.admin')
@include('templates.Carbon.billing.admin.nav', ['activeTab' => 'pages'])

@section('title')
Custom Pages
@endsection

@section('content-header')
    <h1>Pages</h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.index') }}">Admin</a></li>
      <li><a href="{{ route('admin.billing') }}">Billing Module</a></li>
      <li><a href="{{ route('admin.billing.pages') }}">Pages</a></li>
      <li class="active">Edit</li>
    </ol>
@endsection

@section('content')
@yield('billing::nav')

<script src="https://cdn.tiny.cloud/1/gtpqk4bhodntkjtjhc1iggqd0om3gkf8l1opje9m2uhjk0k8/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  @yield('js')
  
  <script>
    tinymce.init({
      selector: 'textarea#editable'
      , height : "600"
      , plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons'
      , toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl'
      , toolbar_mode: 'floating'
      , tinycomments_mode: 'embedded'
      , tinycomments_author: 'xGIGABAITx'
      , allow_html_in_named_anchor: true

    , });

  </script>

<div class="row">
    <div class="col-xs-12">

          <form action="{{ route('admin.billing.pages.save') }}" method="POST">
            @csrf

            <div class="box box-primary">
              <div class="box-header with-border">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input id="name" name="name" placeholder="Discord" class="form-control" value="@if(isset($page)) {{ $page->custom }}@endif">
                </div>
              </div>
            </div>

            <div class="box box-primary">
              <div class="box-header with-border">
                <div class="form-group">
                  <label for="type">Redirect url?</label>
                  <select onchange="setType(this.value)" class="form-control" id="type" name="type">
                    <option value="0" @if(isset($page) and $page->type == 0) selected @endif>Disable</option>
                    <option value="1" @if(isset($page) and $page->type == 1) selected @endif>Enable</option>
                  </select>
                </div>
              </div>
            </div>


            <div class="box box-primary">
              <div class="box-header with-border">
                <div class="form-group">
                  <label for="url">URL</label>
                  <div class="input-group"><span id="url_span" class="input-group-addon">{{ config('app.url') }}/page/</span>
                  <input id="url" name="url" placeholder="example" class="form-control" data-multiplicator="true" value="@if(isset($page)) {{ $page->url }} @endif">
                </div>

                </div>
              </div>
            </div>

            <div class="box box-primary">
              <div class="box-header with-border">
                <div class="form-group">
                  <label for="icon">Nav Icon <a href="https://boxicons.com/">Boxicons</a> </label>
                  <input class="form-control" id="icon" name="icon" placeholder="bx bx-terminal nav_icon sidebar-card" value="@if(isset($page)) {{ $page->icon }} @endif">
                </div>
              </div>
            </div>

            <div id="text_content" class="box box-primary">
              <div class="box-header with-border">
                <div class="form-group">
                  <label for="editable">Content</label>
                  <textarea name="content" rows="5" id="editable">
                    @if(isset($page))
                      {{ html_entity_decode($page->data) }}
                    @endif
                  </textarea>
                </div>
              </div>
            </div>

            <div class="form-group">
              @if(isset($page_id))
                <input type="hidden" name="page_id" value="{{ $page_id }}">
              @endif
              <button class="btn btn-success" type="submit">Submit</button>
            </div>
         </form>

    </div>
</div>

<script>
  function setType(val){
    var url_span = document.getElementById('url_span');
    var text_content = document.getElementById('text_content');
    if (val == 1) {
      url_span.style.visibility = "hidden";
      text_content.style.visibility = "hidden";
    } else {
      url_span.style.visibility = "visible";
      text_content.style.visibility = "visible";
    }
  }
</script>

@if(isset($page) and $page->type == 1)
<script>setType(1)</script>
@endif

@endsection
