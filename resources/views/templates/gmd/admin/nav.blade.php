<li class="header">GMD</li>
<li class="{{ ! starts_with(Route::currentRouteName(), 'admin.gmd') ?: 'active' }}">
  <a href="{{ route('admin.gmd') }}">
      <i class="fa fa-puzzle-piece"></i> <span>GMD Settings</span>
  </a>
</li>
@foreach (glob(base_path() . '/resources/views/templates/gmd/admin/navs/*.blade.php') as $file)
    @include('templates.gmd.admin.navs.' . basename(str_replace('.blade.php', '', $file)))
@endforeach