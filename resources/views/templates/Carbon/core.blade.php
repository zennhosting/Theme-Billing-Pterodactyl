<body id="body-pd">
  @include('templates.Carbon.inc.header')
  @include('templates.Carbon.inc.navbar', ['active_nav' => ''])

  <div class="grey-bg container-fluid">
    @extends('templates/wrapper', [
    'css' => ['body' => 'bg-neutral-800'],
    ])

    @section('container')
    <div id="modal-portal"></div>
    <div id="app"></div>
    @endsection
  </div>

  @include('templates.Carbon.inc.style')
  @include('templates.Carbon.inc.script')
