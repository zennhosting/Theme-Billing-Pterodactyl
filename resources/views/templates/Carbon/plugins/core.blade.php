<body id="body-pd">
  @include('templates.Carbon.inc.header')
  @include('templates.Carbon.plugins.plugins-sidebar', ['active_nav' => ''])

  <div class="grey-bg container-fluid">
    @extends('templates/wrapper', [
    'css' => ['body' => 'bg-neutral-800'],
    ])

    @section('container')
    @include('templates/' . $template . '/plugins/navbar')
    @inject('PL', 'Pterodactyl\Models\Plugins\PluginsModule')

    <div class="container" style="padding-top: 10px;">

      @if(isset($plugins['error']))
      <div class="alert alert-danger" role="alert">
        {{ $plugins['error'] }}
      </div>
      @endif

      <div class="row">
        @if(!isset($plugins['error']))
        @foreach ($plugins as $key => $plugin)

        @php
        $pl_version = implode(', ', $plugin['testedVersions']);
        if (isset($plugin['premium'])) {
        if ($plugin['premium'] == true) {
        continue;
        }
        }
        $pl_name = preg_replace('/[^A-Za-z0-9\-]/', '', $plugin['name']);
        $pl_name = mb_strimwidth($plugin['name'], 0, 60);
        $insrtalled = $PL::getInstalled($server);
        @endphp



        <!-- Modal -->
        <div class="modal fade" id="plugin-{{$plugin['id']}}" tabindex="-1" aria-labelledby="plugin-{{$plugin['id']}}Label" aria-hidden="true">
          <div class="modal-dialog" style="max-width: 80%">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="plugin-{{$plugin['id']}}Label">{{$plugin['name']}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">

                <!-- Modal  Content-->

                <div class="nav-wrapper">
                  <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                    <li class="nav-item">
                      <a class="text-color nav-link mb-sm-3 mb-md-0 active" id="tabs-plugins-overview-{{$plugin['id']}}-1-tab" data-toggle="tab" href="#tabs-plugins-overview-{{$plugin['id']}}-1" role="tab" aria-controls="tabs-plugins-overview-{{$plugin['id']}}-1" aria-selected="true"><i class='bx bxs-plug'></i> Overview</a>
                    </li>
                    <li class="nav-item">
                      <a class="text-color nav-link mb-sm-3 mb-md-0" onclick="getPlVersions('{{$plugin['id']}}', '{{$plugin['name']}}')" id="tabs-plugins-overview-{{$plugin['id']}}-2-tab" data-toggle="tab" href="#tabs-plugins-overview-{{$plugin['id']}}-2" role="tab" aria-controls="tabs-plugins-overview-{{$plugin['id']}}-2" aria-selected="false"><i class='bx bx-git-repo-forked'></i> Version History</a>

                    </li>
                    <li class="nav-item">
                      <a class="text-color nav-link mb-sm-3 mb-md-0" role="tab" target="_blank" href="https://www.spigotmc.org/{{ $plugin['links']['discussion'] }}"><i class='bx bxs-chat'></i> Discussion</a>
                    </li>
                  </ul>
                </div>
                <div class="card shadow">
                  <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                      <!-- Modal Plugin Overview-->
                      <div class="tab-pane fade show active" id="tabs-plugins-overview-{{$plugin['id']}}-1" role="tabpanel" aria-labelledby="tabs-plugins-overview-{{$plugin['id']}}-1-tab">




                        <h5 class="card-title"><img src="@if(empty($plugin['icon']['url']))https://static.spigotmc.org/styles/spigot/xenresource/resource_icon.png @else https://www.spigotmc.org/{{$plugin['icon']['url']}} @endif" class="img-thumbnail plugin-icon">
                          {{$plugin['name']}} <br><span>
                            <p class="card-text modal-tagline">{{$plugin['tag']}}</p>
                          </span>
                        </h5>

                        <p class="mb-0 plugin-tags">Author: <a href="https://www.spigotmc.org/members/{{$plugin['author']['id']}}" target="_blank">https://www.spigotmc.org/members/{{$plugin['author']['id']}}</a></p>
                        @if(empty($plugin['contributors'])) @else <p class="mb-0 plugin-tags">Contributors: {{$plugin['contributors']}}</p> @endif
                        <p class="mb-0 plugin-tags">Downloads: {{$plugin['downloads']}}</p>
                        <p class="mb-0 plugin-tags">Minecraft Version(s): {{$pl_version}}</p>


                        <a href="https://www.spigotmc.org/{{$plugin['file']['url']}}" class="btn btn-primary">Download</a>

                      </div>

                      <!-- Modal Plugin Version History-->
                      <div class="tab-pane fade" id="tabs-plugins-overview-{{$plugin['id']}}-2" role="tabpanel" aria-labelledby="tabs-plugins-overview-{{$plugin['id']}}-2-tab">

                        <table class="table">
                          <thead>
                            <tr>
                              <th class="text-center">#</th>
                              <th>Name</th>
                              <th>Version</th>
                              <th>Size</th>
                              <th class="text-right">Downloads</th>
                              <th class="text-right">Actions</th>
                            </tr>
                          </thead>
                          <tbody>


                            <tr>
                              <td class="text-center">{{$plugin['id']}} </td>
                              <td>{{$plugin['name']}} </td>
                              <td>{{$plugin['version']['id'] }}</td>
                              <td>{{$plugin['file']['size'] }} {{$plugin['file']['sizeUnit'] }} </td>
                              <td class="text-right">{{$plugin['downloads']}} </td>
                              <td class="td-actions text-right">
                                <a type="button" rel="tooltip" href="https://www.spigotmc.org/resources/{{ $plugin['id'] }}" target="_blank" class="btn btn-info btn-icon btn-sm btn-simple" data-original-title="" title="">
                                  <i class='bx bx-link-external' style="color: white;"></i>
                                </a>
                                <a type="button" rel="tooltip" class="btn btn-success btn-icon btn-sm btn-simple" data-original-title="" title="" href="https://www.spigotmc.org/members/{{$plugin['author']['id']}}" target="_blank">
                                  <i class='bx bxs-user-circle'></i>
                                </a>
                                <a type="button" href="https://www.spigotmc.org/{{$plugin['file']['url']}}" rel="tooltip" class="btn btn-success btn-icon btn-sm btn-simple" data-original-title="" title="">
                                  <i class='bx bxs-cloud-download'></i>
                                </a>
                                <button type="button" rel="tooltip" class="btn btn-danger btn-icon btn-sm btn-simple" data-original-title="" title="">
                                  <i class='bx bx-x'></i>
                                </button>
                              </td>
                            </tr>

                          </tbody>
                        </table>

                      </div>
                      <div class="tab-pane fade" id="tabs-plugins-overview-{{$plugin['id']}}-3" role="tabpanel" aria-labelledby="tabs-plugins-overview-{{$plugin['id']}}-3-tab">

                      </div>
                    </div>
                  </div>
                </div>




              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="btnm-{{$plugin['id']}}" onclick="upURL('{{$plugin['id']}}', '{{$pl_name}}')" class="btn btn-primary">Install</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Plugins -->
        <div class="col-sm-4">
          <div class="card">
            <div class="card-body" style="min-height: 300px;">
              <div class="icon-title-div">
                <h5 class="card-title">
                  <img src="@if(empty($plugin['icon']['url']))https://static.spigotmc.org/styles/spigot/xenresource/resource_icon.png @else https://www.spigotmc.org/{{$plugin['icon']['url']}} @endif" class="img-thumbnail plugin-icon">
                  {{ str_limit($plugin['name'], 50)}}
                </h5>
              </div>
              <p class="card-text plugin-tags">{{$plugin['tag']}}</p>

            </div>
            <div class="card-footer">
              @if(isset($insrtalled[$plugin['id']]) and $plugin['version']['id'] <= $insrtalled[$plugin['id']]['ver_id']) <button id="btn-{{$plugin['id']}}" onclick="upURL('{{$plugin['id']}}', '{{$pl_name}}')" class="btn btn-primary mb-2" disabled>Installed</button>
                @elseif(isset($insrtalled[$plugin['id']]) and $plugin['version']['id'] > $insrtalled[$plugin['id']]['ver_id'])
                <button id="btn-{{$plugin['id']}}" onclick="upURL('{{$plugin['id']}}', '{{$pl_name}}')" class="btn btn-success mb-2">Update new version</button>
                @else
                <button id="btn-{{$plugin['id']}}" onclick="upURL('{{$plugin['id']}}', '{{$pl_name}}')" class="btn btn-primary mb-2">Install</button>
                @endif
                <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#plugin-{{$plugin['id']}}">
                  View Plugin</button>
            </div>
          </div>
        </div>
        @endforeach
        @endif

      </div>
    </div>


    @include('templates/' . $template . '/plugins/pagination')

    @include('templates.Carbon.inc.style')
    @include('templates.Carbon.inc.script')
    @include('templates/' . $template . '/plugins/script')
    @endsection

  </div>
</body>
</html>
