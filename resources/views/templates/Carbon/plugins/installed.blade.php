<body id="body-pd">
  @include('templates.Carbon.inc.header')
  @include('templates.Carbon.plugins.plugins-sidebar', ['active_nav' => ''])

  <div class="grey-bg container-fluid">
    @extends('templates/wrapper', [
    'css' => ['body' => 'bg-neutral-800'],
    ])

    @section('container')
    <div class="container" style="padding-top: 10px;">

      <div class="nav-wrapper">
        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">

          <li class="nav-item">
            <a href="{{ route('plugin', ['server' => $server]) }}" class="nav-link mb-sm-3 mb-md-0"><i class="ni ni-calendar-grid-58 mr-2"></i>Back to Plugins</a>
          </li>

          <li class="nav-item">
            <a href="{{ route('plugins.installed', ['server' => $server]) }}" class="nav-link mb-sm-3 mb-md-0 @if($page == 'instsalled')) active @endif"><i class="ni ni-calendar-grid-58 mr-2"></i>Plugins Manager</a>
          </li>

        </ul>
      </div>

      @if(isset($plugins['error']))
      <div class="alert alert-danger" role="alert">
        {{ $plugins['error'] }}
      </div>
      @endif

      <div class="row">
        @if(!isset($plugins['error']))
        <table class="table align-middle mb-0">
          <thead class="text-white">
            <tr>
              <th>Name</th>
              <th>Status</th>
              <th>Autoupdate</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($plugins as $key => $plugin)

            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <img src="@if(empty($plugin['spigot']['icon']['url']))https://static.spigotmc.org/img/spigot-og.png @else https://www.spigotmc.org/{{ $plugin['spigot']['icon']['url'] }} @endif" alt="" style="width: 45px; height: 45px" class="rounded-circle" />
                  <div class="ms-3">
                    <p class="fw-bold mb-1 text-white">{{ $plugin['inst']['name'] }}</p>
                    <p class="text-muted mb-0">{{ str_limit($plugin['spigot']['tag'], 50) }}</p>
                  </div>
                </div>
              </td>
              <td>
                @if($plugin['spigot']['version']['id'] > $plugin['inst']['ver_id'])
                <button data-toggle="tooltip" data-placement="top" title="A new version of the plugin is available, click Reinstal to upgrade" id="status-{{$plugin['spigot']['id']}}" class="btn btn-sm btn-success mb-2">New version available</button>
                @else
                <button data-toggle="tooltip" data-placement="top" title="The latest version of the plugin is installed" id="status-{{$plugin['spigot']['id']}}" class="btn btn-sm btn-primary mb-2">Latest version installed</button>
                @endif
              </td>
              <td>
                @if($plugin['inst']['autoupdate'])
                <button data-toggle="tooltip" data-placement="top" title="Click to switch" id="autoupdate-{{$plugin['inst']['id']}}" onclick="autoupdateSwitch('{{$plugin['inst']['id']}}')" class="btn btn-sm btn-success mb-2">Enabled</button>
                @else
                <button data-toggle="tooltip" data-placement="top" title="Click to switch" id="autoupdate-{{$plugin['inst']['id']}}" onclick="autoupdateSwitch('{{$plugin['inst']['id']}}')" class="btn btn-sm btn-secondary mb-2">Disabled</button>
                @endif

              </td>
              <td>
                <button id="reinstall-{{$plugin['spigot']['id']}}" onclick="upURL('{{$plugin['spigot']['id']}}', '{{$plugin['inst']['name']}}')" class="btn btn-sm btn-warning mb-2">Reinstall</button>
                <button data-toggle="tooltip" data-placement="top" title="This will remove the plugin only from the plugin controller. Not all plugin files will be deleted" id="unistall-{{$plugin['inst']['id']}}" onclick="plRemove('{{$plugin['inst']['id']}}')" class="btn btn-sm btn-danger mb-2">Unistall</button>
              </td>
            </tr>

            @endforeach
          </tbody>
        </table>
        @endif

      </div>
    </div>
    @include('templates.Carbon.inc.style')
    @include('templates.Carbon.inc.script')
    @endsection

  </div>
</body>


<script>
  function upURL(pl_id, pl_name) {
    fetch('{{$app_url}}' + '/server/' + '{{$server}}' + '/plugins/upload/' + pl_id + '/' + pl_name).then(function(response) {
      var btn = document.getElementById('reinstall-' + pl_id);
      btn.innerHTML = 'Installed';
      btn.disabled = true;
    });
  }

  function autoupdateSwitch(pl_id) {
    fetch('{{$app_url}}' + '/server/' + '{{$server}}' + '/pl-autoupdate/' + pl_id).then(function(response) {
      var btn = document.getElementById('autoupdate-' + pl_id);
      if (btn.textContent == 'Enabled') {
        btn.innerHTML = 'Disabled';
        btn.classList.remove('btn-success');
        btn.classList.add('btn-secondary');
      } else {
        btn.innerHTML = 'Enabled';
        btn.classList.add('btn-success');
        btn.classList.remove('btn-secondary');
      }
    });
  }

  function plRemove(pl_id) {
    fetch('{{$app_url}}' + '/server/' + '{{$server}}' + '/pl-remove/' + pl_id).then(function(response) {
      var btn = document.getElementById('unistall-' + pl_id);
      btn.innerHTML = 'Removed';
    });
  }

</script>
</html>
