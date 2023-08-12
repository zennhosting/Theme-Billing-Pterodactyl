@include('templates.Carbon.inc.header')
@include('templates.Carbon.inc.navbar', ['active_nav' => 'tickets'])
<div class="grey-bg container-fluid">
  @extends('templates/wrapper', [
  'css' => ['body' => 'bg-neutral-800'],
  ])
  @section('container')

  <div class="pt-5">
    <div class="row justify-content-center">
      <div class="container">
        <div class="card card-frame" style="border-radius: 10px;">
          <div class="card-body" style="border-radius: 7px;">
            <form action="{{ route('tickets.new.create') }}" method="POST">
              @csrf
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-control-label">Name</label>
                    <input type="text" class="form-control disabled" id="name" value="{{ Auth::user()->username }}" disabled style="background: #00000040 !important;cursor: not-allowed;">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-control-label">Email</label>
                    <input type="text" class="form-control" id="email" value="{{ Auth::user()->email }}" disabled style="background: #00000040 !important;cursor: not-allowed;">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label">Subject</label>
                    <input type="text" class="form-control" name="subject" placeholder="Subject">
                  </div>
                </div>

                <div class="col-md-4">
                  <label class="form-control-label">Service</label>
                  <select name="service" class="form-control">
                    @if(isset($invoices))
                    @foreach($invoices as $service)
                    <option value="{{ Bill::plans()->findOrFail($service->plan_id)->name }}">{{Bill::plans()->findOrFail($service->plan_id)->name}}</option>
                    @endforeach
                    @endif

                    <option value="other">Other</option>

                  </select>
                </div>

                <div class="col-md-4">
                  <label class="form-control-label">Priority</label>
                  <select name="priority" class="form-control">
                    <option>Low</option>
                    <option>Medium</option>
                    <option>High</option>
                  </select>
                </div>

                <div class="col-md-12">
                  <label class="form-control-label">Message</label>
                  <textarea name="response"></textarea>
                </div>

                <div class="col-md-12" style="display: flex;justify-content: flex-end;">
                  <button type="submit" class="btn btn-primary mt-4" style="width: 15%">Create Ticket</button>
                </div>


              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.tiny.cloud/1/qagffr3pkuv17a8on1afax661irst1hbr4e6tbv888sz91jc/tinymce/4/tinymce.min.js"></script>
  <script>
    tinymce.init({
      selector: 'textarea'
      , height: 300
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
