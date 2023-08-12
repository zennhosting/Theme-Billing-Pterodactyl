<body id="body-pd">
  @include('templates.Carbon.inc.header')
  @include('templates.Carbon.plugins.plugins-sidebar', ['active_nav' => ''])

  <div class="grey-bg container-fluid">
    @extends('templates/wrapper', [
    'css' => ['body' => 'bg-neutral-800'],
    ])

    @section('container')
    <div class="container" style="padding-top: 10px;">

      <div class="row">
        @if(!empty($core))
        <table class="table align-middle mb-0">
          <thead class="text-white">
            <tr>
              <th>Version</th>
              <th>Version name</th>
              <th>Version num</th>
              <th>Autoupdate</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <h4 class="fw-bold mb-1 text-white">{{ ucfirst($core->core) }}</h4>
                </div>
              </td>
              <td>
                <div class="d-flex align-items-center">
                  <h4 class="fw-bold mb-1 text-white">{{ $core->name }}</h4>
                </div>
              </td>
              <td>
                <div class="d-flex align-items-center">
                  <h4 class="fw-bold mb-1 text-white">{{ $core->version }}</h4>
                </div>
              </td>

              <td>
                @if($core->autoupdate)
                <button data-toggle="tooltip" data-placement="top" title="Click to switch" id="autoupdate-{{$core->id}}" onclick="autoupdateSwitch('{{$core->id}}')" class="btn btn-sm btn-success mb-2">Enabled</button>
                @else
                <button data-toggle="tooltip" data-placement="top" title="Click to switch" id="autoupdate-{{$core->id}}" onclick="autoupdateSwitch('{{$core->id}}')" class="btn btn-sm btn-secondary mb-2">Disabled</button>
                @endif
              </td>
              <td class="text-end">
                <a href="{{ route('plugins.remove_core', ['server' => $server]) }}" data-toggle="tooltip" data-placement="top" title="This will remove the plugin only from the plugin controller. Not all plugin files will be deleted" class="btn btn-sm btn-danger mb-2">Unistall</a>
              </td>
            </tr>
          </tbody>
        </table>
        @endif

        <div class="container" style="padding-top: 10px;">
          <form class="row" method="post" action="{{ route('plugins.set_core', ['server' => $server]) }}">
            @csrf

            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="project">Core</label>
                <select onchange="pSelect(this.value, true)" name="project" id="project" class="form-control">
                  @foreach($paper as $key => $value)
                  <option value="{{ $key }}" @if(isset($core->core) and strtolower($core->core) == $key) selected @endif>{{ ucfirst($key)}}</option>
                  @endforeach
                </select>
              </div>


              <div class="form-group col-md-3">
                <label for="name">Core Name</label>
                <input value="@if(isset($core->name)){{ $core->name }} @else server.jar @endif" type="text" name="name" id="name" placeholder="server.jar" class="form-control" required>
              </div>



              <div class="form-group col-md-3">
                <label for="version">Versions</label>
                <select name="version" id="version" class="form-control">
                  @foreach($paper as $key => $value)
                  <optgroup label="{{ ucfirst($key)}}" id="versions-{{ $key }}" style="display:none;">
                    @foreach($value as $id => $ver)
                    <option @if(isset($core->version) and $core->version == $ver) selected @endif value="{{ $ver }}">{{ $ver }}</option>
                    @endforeach
                  </optgroup>
                  @endforeach
                </select>
              </div>

              <script>
                var sel = document.getElementById('project');
                pSelect(sel.value);

                function pSelect(sel, click = false) {
                  var versions = document.getElementById("version");
                  if (click) {
                    versions.value = '';
                  }
                  var c = versions.children;
                  for (i = 0; i < c.length; i++) {
                    c[i].style.display = "none";
                  }
                  opt = document.getElementById('versions-' + sel);
                  opt.style.display = "";
                }

              </script>

              <div class="form-group col-md-3">
                <label for="autoupdate">Autoupdate</label>
                <select name="autoupdate" id="autoupdate" class="form-control">
                  <option @if(isset($core->autoupdate) and $core->autoupdate == 1) selected @endif value="1">Enable</option>
                  <option @if(isset($core->autoupdate) and $core->autoupdate == 0) selected @endif value="0">Disable</option>
                </select>
              </div>



              <div class="form-group col-md-12 text-center">
                <button type="submit" class="btn btn-success">Install</button>
              </div>
            </div>


          </form>
        </div>
      </div>



    </div>
    @endsection
    @include('templates.Carbon.inc.style')
    @include('templates.Carbon.inc.script')
</body>
</html>
