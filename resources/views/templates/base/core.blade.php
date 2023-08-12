
@inject('Cache', 'Illuminate\Support\Facades\Cache')
@if(Cache::has('active_template'))
  @include('templates.' . Cache::get('active_template') . '.core')
@else
  @include('templates.Carbon.core')
@endif