@include('templates.Carbon.inc.header')
@include('templates.Carbon.inc.navbar', ['active_nav' => 'new_ticket'])
<div class="grey-bg container-fluid">
  @extends('templates/wrapper', [
  'css' => ['body' => 'bg-neutral-800'],
  ])
  @section('container')


  <div class=" py-md pt-5">

    <div class="row">

      <div class="col-xl-4 order-xl-2 mt-6">
        <div class="card card-profile">
          <div class="card-body pt-0">

            <div class="card-header text-center heading">
              #{{ $ticket->uuid }}
            </div>

            <div class="text-left">
              <h4 style="display: flex;align-items: center;"><i class='bx bx-bookmark'></i> <strong style="margin-left: 5px;margin-right: 5px;">Subject: </strong> {{ $ticket->subject }}</h4>
              <h4 style="display: flex;align-items: center;"><i class='bx bx-server'></i> <strong style="margin-left: 5px;margin-right: 5px;">Service: </strong> {{ $ticket->service }}</h4>
              <h4 style="display: flex;align-items: center;"><i class='bx bx-shield-plus' ></i> <strong style="margin-left: 5px;margin-right: 5px;">Status/Priority: </strong> <span class="badge  @if($ticket->status == 'Closed') badge-danger @elseif($ticket->status == 'Open') badge-success @else badge-success @endif mr-1">{{ $ticket->status }}</span> {{ $ticket->priority }}</h4>
              <h4 style="display: flex;align-items: center;"><i class='bx bx-calendar'></i> <strong style="margin-left: 5px;margin-right: 5px;">Created: </strong> {{ $ticket->created_at->diffForHumans() }}</h4>
            </div>

            <div class="row">
              @if($ticket->status == 'Closed')
              <a href="{{ route('tickets.switch', $ticket->uuid) }}" class="btn btn-success mt-2">Re-open Ticket</a>
              @else
              <a href="{{ route('tickets.switch', $ticket->uuid) }}" class="btn btn-warning mt-2">Close Ticket</a>
              @endif
            </div>

          </div>
        </div>
      </div>

      <div class="col-xl-8 order-xl-2 mt-6">

        @if($ticket->status == 'Open')
        <div class="card-header d-inline-block w-full mb-4">
          <div class="row">
            <div class="col-md-12">
              <div class="media align-items-center">
                <img alt="Image" src="https://www.gravatar.com/avatar/{{ md5(strtolower(Auth::user()->email)) }}?s=160" class="avatar shadow">
                <div class="media-body ml-2">
                  <h4 class="mb-0 d-block">{{ Auth::user()->username }} @if(Auth::user()->root_admin) <span class="badge badge-danger ml-1">STAFF MEMBER</span>@else <span class="badge badge-default ml-1">Client</span> @endif </h4>
                  <h6 class="text-muted text-small">New response</h6>
                </div>
              </div>
            </div>

            <div class="card-body">
              <div class="row justify-content-start">
                <form action="{{ route('tickets.manage.response', ['uuid' => $ticket->uuid]) }}" method="POST">
                  @csrf
                  <label class="form-control-label">Message</label>
                  <textarea required name="response"><code></code></textarea>
                  <div class="col-md-12" style="display: flex;justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary mt-4" style="width: 15%">Send</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        @endif

        @php
        use Pterodactyl\Models\User;
        @endphp
        @foreach($responses as $response)
        <div class="card-header d-inline-block w-full mb-4">
          <div class="row">
            <div class="col-md-12">
              <div class="media align-items-center">
                <img alt="Image" src="https://www.gravatar.com/avatar/{{ md5(strtolower(User::findOrFail($response->user_id)->email)) }}?s=160" class="avatar shadow">
                <div class="media-body ml-2">
                  <h4 class="mb-0 d-block">{{ User::findOrFail($response->user_id)->username }} @if(User::findOrFail($response->user_id)->root_admin) <span class="badge badge-danger ml-1">STAFF MEMBER</span> @else <span class="badge badge-default ml-1">Client</span> @endif</h4>
                  <h6 class="text-muted text-small">{{ $response->created_at->diffForHumans() }}</h6>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row justify-content-start">
                <code>{!! $response->response !!}</code>
              </div>
            </div>
            <div class="col-md-1 col-3">
            </div>
          </div>
        </div>
        @endforeach
      </div>


    </div>

  </div>


  <script src="https://cdn.tiny.cloud/1/qagffr3pkuv17a8on1afax661irst1hbr4e6tbv888sz91jc/tinymce/4/tinymce.min.js"></script>
  <script>
    tinymce.init({
      selector: 'textarea'
      , height: 150
      , theme: 'modern'
      , plugins: 'print preview fullpage powerpaste searchreplace autolink directionality advcode visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount tinymcespellchecker a11ychecker imagetools mediaembed  linkchecker contextmenu colorpicker textpattern help'
      , toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat'
      , image_advtab: true,

      content_css: [
        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i'
        , '//www.tinymce.com/css/codepen.min.css'
      ]
    });

  </script>

  <style>
    div#mceu_39 {
      display: none;
    }

  </style>


  @endsection
</div>
@include('templates.Carbon.inc.style')
@include('templates.Carbon.inc.script')
