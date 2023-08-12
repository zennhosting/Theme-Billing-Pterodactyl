@extends('layouts.admin')
@include('templates.Carbon.billing.admin.nav', ['activeTab' => 'domain'])

@section('title')
Domain
@endsection

@section('content-header')
    <h1>Domain</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.billing') }}">Billing Module</a></li>
        <li class="active">Domain</li>
    </ol>
@endsection

@section('content')
@yield('billing::nav')


<div class="row">
  <div class="col-xs-12">
      <div class="box box-primary">
          <div class="box-header with-border">
              <h3 class="box-title">API List</h3>
              <div class="box-tools">
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newAPIModal">Create New API</button>
              </div>
          </div>
          <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                  <tbody>
                      <tr>
                          <th>ID</th>
                          <th class="">Type</th>
                          <th class="">Domain</th>
                          <th class="">Email</th>
                          <th class="">Zone ID</th>
                          <th class="text-right">Actions</th>
                      </tr>
                            @foreach($apis as $key => $api)
                              @if(isset($api->id))
                              <tr>
                                <td><code>{{ $api->id }}</code></td>
                                <td><code>{{ $api->type }}</code></td>
                                <td><code>{{ $api->domain }}</code></td>
                                <td><code>{{ $api->data['email'] }}</code></td>
                                <td><code>{{ $api->data['zone_id'] }}</code></td>
                                <td class="text-right">
                                  <a onclick="deleteModal('{{ $api->id }}')" data-toggle="modal" data-target="#deleteAPIModal" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                              </tr>
                              @endif
                            @endforeach

                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>


<div class="modal fade" id="newAPIModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <form action="{{ route('admin.billing.domain.post') }}" method="POST">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Create API</h4>
              </div>
              <div class="modal-body">
                  <div class="row">

                      <div class="col-md-6">
                          <label for="email" class="form-label">Acount email</label>
                          <input type="text" name="email" id="email" class="form-control" />
                      </div>

                      <div class="col-md-6">
                          <label for="domain" class="form-label">Domain</label>
                          <input type="text" name="domain" id="domain" class="form-control" />
                      </div>

                      <div class="col-md-6">
                          <label for="zone_id" class="form-label">Zone ID</label>
                          <input type="text" name="zone_id" id="zone_id" class="form-control" />
                      </div>

                      <div class="col-md-6">
                        <label for="key" class="form-label">Global API Key</label>
                        <input type="text" name="key" id="key" class="form-control" />
                      </div>

                  </div>
              </div>
              <div class="modal-footer">
                  {!! csrf_field() !!}
                  <input type="hidden" id="create_api" name="create_api" value="">
                  <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-success btn-sm">Submit</button>
              </div>
          </form>
      </div>
  </div>
</div>


<div class="modal fade" id="deleteAPIModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <form action="{{ route('admin.billing.domain.post') }}" method="POST">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Delete API </h4>
              </div>
              <div class="modal-body">
            
                    <strong class="text-center">Are you sure?</strong> 
            
              </div>
              <div class="modal-footer">
                  {!! csrf_field() !!}
                  <input type="hidden" id="delete_api_id" name="delete_api_id" value="">
                  <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-success btn-sm">Submit</button>
              </div>
          </form>
      </div>
  </div>
</div>

<script>
function deleteModal(id){
  document.getElementById('delete_api_id').value = id;
}
</script>



@endsection
