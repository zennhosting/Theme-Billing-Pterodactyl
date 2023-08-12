<!-- Header-->
<header class="bg-dark py-5" style="background-image: url('https://images6.alphacoders.com/108/1082090.jpg'); background-size: cover; height: 500px;filter: hue-rotate(45deg); display: none">
  <div class="container px-4 px-lg-5 my-5">
    <div class="text-center text-white" style="padding-top: 50px;">
      <h1 class="display-4 fw-bolder">{{ config('app.name', 'Pterodactyl') }}</h1>
      <p class="lead fw-normal text-white-50 mb-0">Install plugins for your Minecraft Server</p>
    </div>
  </div>
</header>

<!-- Navbar Categories-->
@if(!Route::is('plugins.installed', ['server' => $server]) and !Route::is('plugins.server_core', ['server' => $server]))
<div class="container">

  <div class="nav-wrapper">
    <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
      <li class="nav-item">
        <a class="nav-link mb-sm-3 mb-md-0 @if($plugins['0']['category']['id'] > 13 and $plugins['0']['category']['id'] < 19 or $plugins['0']['category']['id'] > 21 or $page != 'categories') active @endif" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i class="ni ni-cloud-upload-96 mr-2"></i>Spigot</a>
      </li>
      <li class="nav-item">
        <a class="nav-link mb-sm-3 mb-md-0 @if($plugins['0']['category']['id'] > 4 and $plugins['0']['category']['id'] < 9) active @endif" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><i class="ni ni-bell-55 mr-2"></i>Bungee Spigot</a>
      </li>
      <li class="nav-item">
        <a class="nav-link mb-sm-3 mb-md-0 @if($plugins['0']['category']['id'] > 9 and $plugins['0']['category']['id'] < 14) active @endif" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false"><i class="ni ni-calendar-grid-58 mr-2"></i>Bungee Proxy</a>
      </li>
      <li class="nav-item">
        <a href="{{ route('plugins.installed', ['server' => $server]) }}" class="nav-link mb-sm-3 mb-md-0 @if($page == 'instsalled')) active @endif"><i class="ni ni-calendar-grid-58 mr-2"></i>Plugins Manager</a>
      </li>
    </ul>
  </div>

  <div class="card shadow" style="margin-bottom: 15px;">
    <div class="card-body">
      <div class="tab-content" id="myTabContent" style="display: flex; justify-content: space-around;">

        <div class="tab-pane fade @if($plugins['0']['category']['id'] > 13 and $plugins['0']['category']['id'] < 19 or $plugins['0']['category']['id'] > 21 or $page != 'categories') show active @endif" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">

          {{-- Spigot sub categories --}}
          @foreach ($categories as $sub_category)
          @if($sub_category['id'] > 13 and $sub_category['id'] < 19) <a href="/server/{{$server}}/plugins/category/{{$sub_category['id']}}/1" type="button" class="btn btn-primary btn-sm @if($sub_category['id'] == $plugins['0']['category']['id']) @else button-inactive @endif">{{$sub_category['name']}}</a>


            @elseif($sub_category['id'] > 21 and $sub_category['id'] < 27) <a href="/server/{{$server}}/plugins/category/{{$sub_category['id']}}/1" type="button" class="btn btn-primary btn-sm @if($sub_category['id'] == $plugins['0']['category']['id']) @else button-inactive @endif">{{$sub_category['name']}}</a>
              @endif
              @endforeach
              {{-- END Spigot sub categories --}}
        </div>

        <div class="tab-pane fade @if($plugins['0']['category']['id'] > 4 and $plugins['0']['category']['id'] < 9) show active @endif" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">

          {{-- Bungee - Spigot sub categories --}}
          @foreach ($categories as $sub_category)

          @if($sub_category['id'] > 4 and $sub_category['id'] < 9) <a href="/server/{{$server}}/plugins/category/{{$sub_category['id']}}/1" type="button" class="btn btn-primary btn-sm @if($sub_category['id'] == $plugins['0']['category']['id']) @else button-inactive @endif">{{$sub_category['name']}}</a>
            @endif
            @endforeach
            {{-- END Bungee - Spigot sub categories --}}
        </div>

        <div class="tab-pane fade @if($plugins['0']['category']['id'] > 9 and $plugins['0']['category']['id'] < 14) show active @endif" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">

          {{-- Bungee - Proxy sub categories --}}
          @foreach ($categories as $sub_category)


          @if($sub_category['id'] > 9 and $sub_category['id'] < 14) <a href="/server/{{$server}}/plugins/category/{{$sub_category['id']}}/1" type="button" class="btn btn-primary btn-sm @if($sub_category['id'] == $plugins['0']['category']['id']) @else button-inactive @endif">{{$sub_category['name']}}</a>
            @endif
            @endforeach
            {{-- END Bungee - Proxy sub categories --}}

        </div>
      </div>
    </div>

  </div>


  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <!-- manual upload modal-->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadPlugin" style="height: 48px;">
        Manual Upload
        </button>
      </div>
      <div class="col-md-6">
        <!-- page selector-->
        @include('templates/' . $template . '/plugins/paginationup')
      </div>
      <div class="col-md-3">
        <!-- Search Block-->
        <div class="navbar-search navbar-search-light form-inline" id="navbar-search-main">
        <div class="form-group mb-0">
          <div class="input-group input-group-alternative input-group-merge">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
            <input onkeydown="if (event.keyCode==13) {searh('{{$server}}', '{{$p}}') };" class=" form-control" id="SearchPL" placeholder="Search" type="text">
          </div>
        </div>
        <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        </div>

      </div>
    </div>


      <!-- Modal -->
      <div class="modal fade" id="uploadPlugin" tabindex="-1" role="dialog" aria-labelledby="uploadPluginLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="uploadPluginLabel">Manually Upload Plugins</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <h5 style="text-align: center;"><i class='bx bx-download'></i> Drag and Drop </h5>
              <div>
                <form id="file-form" method="post" enctype="multipart/form-data">
                  <input class="drop-area" type="file" id="files" name="files" multiple>

              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" id="modal-close" data-dismiss="modal">Close</button>
              <button type="button" onclick="sendFile()" class="btn btn-primary">Upload Plugin</button>
              </form>
            </div>
          </div>
        </div>
      </div>
  </div>
    <!-- Search Module-->
  <script>
    function searh(server) {
      find = document.getElementById('SearchPL').value;
      var url = '/server/' + server + '/plugins/search/' + find + '/' + 1;
      window.location.href = url;
    }

  </script>
  @endif
