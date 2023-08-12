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
        <a href="{{route('tickets.new')}}" class="btn btn-primary mb-4 text-right">New Ticket</a>
        <table class="table" style="background: var(--sidebar-bg-color)">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th>Author</th>
              <th>Subject</th>
              <th>Status</th>
              <th class="text-right">Last Updated</th>
              <th class="text-right">Actions</th>
            </tr>
          </thead>
          @if($tickets !== NULL)
          <tbody>
            @foreach($tickets as $ticket)
            <tr>
              <td class="text-center"># {{$ticket->uuid}}</td>
              <td>
                <div class="d-flex px-2 py-1">
                  <div><img src="https://www.gravatar.com/avatar/{{ md5(strtolower(Auth::user()->email)) }}?s=160" class="avatar avatar-sm me-3"></div>
                  <div class="d-flex flex-column justify-content-center">
                    <h6 class="mb-0 text-xs">{{ Auth::user()->name_first .' '. Auth::user()->name_last }}</h6>
                    <p class="text-xs text-secondary mb-0">{{ Auth::user()->email }}</p>
                  </div>
                </div>
              </td>
              <td>
                <div class="d-flex flex-column justify-content-center">
                  <h6 class="mb-0 text-xs">{{$ticket->subject}}</h6>
                  <p class="text-xs text-secondary mb-0">@if(Bill::plans()->find($ticket->service) !== Null){{Bill::plans()->find($ticket->service)->first()->name}}@else Service: {{ $ticket->service }} @endif</p>
                </div>
              </td>
              <td>
              <span class="badge @if($ticket->status == 'Closed') badge-danger @elseif($ticket->status == 'Open') badge-success @else badge-success @endif mr-1">{{ $ticket->status }}</span>
                <p class="mb-0 text-xs mt-1">Priority: {{ $ticket->priority }}</p>
              </td>
              <td class="text-right">
                <div class="d-flex flex-column justify-content-center">
                  <h6 class="mb-0 text-xs">Last Updated: {{ $ticket->updated_at->diffForHumans() }}</h6>
                  <p class="text-xs text-secondary mb-0">Created: {{ $ticket->created_at->diffForHumans() }}</p>
                </div>
              </td>
              <td class="td-actions text-right">
                <a href="{{ route('tickets.manage', ['uuid' => $ticket->uuid]) }}" class="btn btn-warning btn-icon btn-sm " data-original-title="" title="">
                  Manage
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
          @endif
        </table>
      </div>
    </div>
  </div>

  @endsection
</div>
@include('templates.Carbon.inc.style')
@include('templates.Carbon.inc.script')
