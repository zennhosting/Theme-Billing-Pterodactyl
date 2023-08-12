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
                <h3 class="box-title">SubDomain List</h3>
                <div class="box-tools">
                  <a href="{{ route('admin.billing.domain.api') }}" class="btn btn-sm btn-warning" style="width:100%;">API Settings</a>
                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th class="">Type</th>
                            <th class="">SubDomain</th>
                            <th class="">IP</th>
                            <th class="">Port</th>
                            <th class="">User</th>
                            <th class="text-right">Actions</th>
                        </tr>
                              @foreach($subdomain as $key => $sub)
                                @if(isset($sub->id))
                                <tr>
                                  <td><code>{{ $sub->id }}</code></td>
                                  <td><code>{{ $sub->type }}</code></td>
                                  <td><code>{{ $sub->a_name }}</code></td>
                                  @if(!empty($sub->data))
                                    <td><code>{{ $sub->data['server_ip'] }}</code></td>
                                    <td><code>{{ $sub->data['port'] }}</code></td>
                                  @else
                                    <td><code>none</code></td>
                                    <td><code>none</code></td>
                                  @endif
                                  <td><code>@if(!empty($user = Bill::invoiceIdToUser($sub->invoice_id))){{ $user->name }}@endif</code></td>
                                  <td class="text-right">
                                    <a onclick="deleteModal('{{ $sub->id }}')" data-toggle="modal" data-target="#deleteDomainModal" class="btn btn-danger btn-sm">Delete</a>
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



<div class="modal fade" id="deleteDomainModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <form action="{{ route('admin.billing.domain.post') }}" method="POST">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Delete SubDomain </h4>
              </div>
              <div class="modal-body">
             
                    <strong class="text-center">Are you sure?</strong> 
            
              </div>
              <div class="modal-footer">
                  {!! csrf_field() !!}
                  <input type="hidden" id="delete_domain_id" name="delete_domain_id" value="">
                  <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-success btn-sm">Submit</button>
              </div>
          </form>
      </div>
  </div>
</div>

<script>
  function deleteModal(id){
    document.getElementById('delete_domain_id').value = id;
  }
</script>

@endsection


