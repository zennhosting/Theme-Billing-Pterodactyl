@include('templates.Carbon.inc.header')
@include('templates.Carbon.inc.navbar', ['active_nav' => 'invoices'])
<div class="grey-bg container-fluid">
  @extends('templates/wrapper', [
  'css' => ['body' => 'bg-neutral-800'],
  ])
  @section('container')

  @php
    if (!empty($sub = Bill::subdomain(null)->getInvoiceSubDomain($invoice->id))) {
      $a_name = $sub->a_name; 
      $sub_name = $sub->data->name;
    } else {
      $a_name = ''; $sub_name = '';
    }
  @endphp
    <div class="row pt-3">
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-uppercase font-weight-bold">{!! Bill::lang()->get('server_ip_address') !!}</p>
                  <h5 class="font-weight-bolder" id="domain_text">
                    <span class="text-success text-sm font-weight-bolder">{{ $allocation->ip }}:{{ $allocation->port }}</span>
                  </h5>
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                  <i class='bx bx-fingerprint' style="color: white;"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-uppercase font-weight-bold">{!! Bill::lang()->get('cpu') !!}</p>
                  <h5 class="font-weight-bolder">
                    <span class="text-success text-sm font-weight-bolder">@if($server->cpu == 0)Unlimited @else {{$server->cpu}} % @endif</span>
                  </h5>
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                  <i class='bx bxs-chip' style="color: white;"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-uppercase font-weight-bold">{!! Bill::lang()->get('memory') !!}</p>
                  <h5 class="font-weight-bolder">
                    <span class="text-success text-sm font-weight-bolder">@if($server->memory == 0)Unlimited @else {{$server->memory}} MB @endif</span>
                  </h5>
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                  <i class='bx bxs-memory-card' style="color: white;"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-uppercase font-weight-bold">{!! Bill::lang()->get('storage') !!}</p>
                  <h5 class="font-weight-bolder">
                    <span class="text-success text-sm font-weight-bolder">@if($server->disk == 0)Unlimited @else {{$server->disk}} MB @endif</span>
                  </h5>
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                  <i class='bx bxs-hdd' style="color: white;"></i>                
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="py-md">
          <div class="row">
            
              @include('templates.Carbon.inc.user-widget')

              <div class="col-xl-8 order-xl-1">

                @if($invoice->status == 'Cancelled') 
                  <div class="alert alert-danger flex" role="alert">
                    You have cancelled your server. Your server is currently on a Grace Period until {{ $invoice->due_date }}. After the grace period, your server will be suspended.
                    <a href="{{ route('billing.my-plans.activate', ['id' => $invoice->id]) }}" class="btn btn-sm btn-primary ">Re-activate</a>
                  </div>
                @endif
                
                @if($invoice->status == 'Unpaid') 
                  <div class="alert alert-warning" role="alert">
                    You have a unpaid invoice, as result this server has been suspended. Please pay the invoice by clicking "Renew" to re-active your server.
                  </div>
                @endif

                <div class="card">
                  <div class="card-header">
                    <div class="row align-items-center">
                      <div class="col-12">
                        
                        <h3 class="mb-0">{{ $plan->name }}</h3>
                      </div>
                      <div class="col-4 text-right">
                      </div>
                    </div>
                  </div>
                  <div class="card-body">

                    <div class="row">
                      
                      <div class="nav-wrapper">
                        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i class="ni ni-cloud-upload-96 mr-2"></i><i class='bx bx-layer' ></i> {!! Bill::lang()->get('plan') !!}</a>
                            </li>
                            @if($plan->subdomain)
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><i class="ni ni-bell-55 mr-2"></i><i class='bx bx-wrench'></i> {!! Bill::lang()->get('settings_page') !!}</a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false"><i class='bx bx-barcode' ></i> {!! Bill::lang()->get('invoices') !!}</a>
                            </li>
                        </ul>
                      </div>
                      <div class="card shadow" style="background: transparent; box-shadow: none !important;">
                          <div class="card-body">
                              <div class="tab-content" id="myTabContent">
                                  <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                    <div class="row">
                                      <div class="col-lg-12 col-md-6">
                                        <div class="card card-profile" style="box-shadow: none;">
                                          <div class="card-header bg-info" style="background-image: url('@if(isset($settings['plans_img_url'])){{ $settings['plans_img_url'] }}@else /billing-src/img/plans.png @endif');background-position: center;">
                                            <div class="card-avatar">
                                              <a href=" ">
                                                <img class="img img-raised rounded-circle" src="{{ $plan->icon }}" style="width: 120px;">
                                              </a>
                                            </div>
                                          </div>
                                          <div class="card-body pt-0">
                                            <div class="d-flex justify-content-between">
                                              <a href="{{ route('billing.balance') }}" class="btn btn-sm btn-success mr-4 mt-3">{!! Bill::lang()->get('balance_page') !!}</a>
                                              <a href="/" class="btn btn-sm btn-info float-right mt-3">{!! Bill::lang()->get('servers_page') !!}</a>
                                            </div>

                                            <div class="row">
                                              <div class="col">
                                                <div class="card-profile-stats d-flex justify-content-center">
                                                  <div>
                                                    <span class="heading">{{ $settings['currency_symbol'] }} {{ $plan->price }}</span>
                                                    <span class="description">/ @if ($plan->days === 30) {!! Bill::lang()->get('monthly') !!} @elseif ($plan->days  ===  90) {!! Bill::lang()->get('quarterly') !!} @elseif ($plan->days  ===  0) {!! Bill::lang()->get('unlimited') !!} @else {{ $plan->days }} {!! Bill::lang()->get('days') !!} 
                                                      @endif</span>
                                                  </div>
                                                  <div>
                                                    <span class="heading">{{$server->uuidShort}}</span>
                                                    <span class="description">Server ID</span>
                                                  </div>
                                                  <div>
                                                    <span class="heading">{{ Auth::user()->username }}</span>
                                                    <span class="description">Owner</span>
                                                  </div>
                                                  <div>
                                                    <span class="heading">{{$plan->cpu_model}}</span>
                                                    <span class="description">{!! Bill::lang()->get('cpu') !!} Model</span>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>

                                            <div class="row">
                                              <div class="col">
                                                <div class="card-profile-stats d-flex justify-content-center">
                                                  <div>
                                                    <span class="heading">{{ $invoice->invoice_date }}</span>
                                                    <span class="description">{!! Bill::lang()->get('invoice_date') !!}</span>
                                                  </div>
                                                  <div>
                                                    <span class="heading"><span class="badge badge-pill badge-@if($invoice->status == 'Paid')success @elseif($invoice->status == 'Unpaid' OR $invoice->status == 'Cancelled')danger @endif ">{{ $invoice->status }}</span> </span>
                                                    <span class="description">Status</span>
                                                  </div>
                                                  <div>
                                                    <span class="heading">{{ $invoice->due_date }}</span>
                                                    <span class="description">{!! Bill::lang()->get('due_date') !!}</span>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>

                                            <div class="row">
                                              <div class="col">
                                                <div class="card-profile-stats d-flex justify-content-center">
                                                  <div>
                                                    <span class="heading">{{ $plan->backup_limit }}</span>
                                                    <span class="description">{!! Bill::lang()->get('backup') !!}</span>
                                                  </div>
                                                  <div>
                                                    <span class="heading">{{ $plan->database_limit }}</span>
                                                    <span class="description">{!! Bill::lang()->get('database') !!}</span>
                                                  </div>
                                                  <div>
                                                    <span class="heading">{{ $plan->allocation_limit }}</span>
                                                    <span class="description">{!! Bill::lang()->get('exstra_ports') !!}</span>
                                                  </div>
                                                  
                                                </div>
                                              </div>
                                            </div>

                                            <!-- Renew Button trigger modal -->
                                            <button type="button" class="btn w-100 btn-outline-success mb-3" data-toggle="modal" data-target="#RenewModal">
                                              {!! Bill::lang()->get('renew_plan') !!}
                                            </button>

                                            <!-- Renew Modal -->
                                            <div class="modal fade" id="RenewModal" tabindex="-1" role="dialog" aria-labelledby="RenewModallLabel" aria-hidden="true">
                                              <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="RenewModalLabel">{!! Bill::lang()->get('renew_plan') !!}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class="modal-body">
                                                    {!! Bill::lang()->get('extend_plan_info') !!}
                                                    @if(isset($plans[$invoice->plan_id]))
                                                    {!! Bill::lang()->get('extend') !!} {{ $plans[$invoice->plan_id]->days }}{!! Bill::lang()->get('days_for') !!} @if(isset($settings['currency_symbol'])){{ $settings['currency_symbol'] }}@endif{{ $plans[$invoice->plan_id]->price }} @if(isset($settings['paypal_currency'])){{ $settings['paypal_currency'] }}@endif
                                                    @else
                                                    {!! Bill::lang()->get('deleted') !!}
                                                    @endif
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{!! Bill::lang()->get('cancel') !!}</button>
                                                    <a href="{{ route('billing.my-plans.update', ['id' => $invoice->id]) }}" type="button" class="btn btn-success">{!! Bill::lang()->get('pay') !!}</a>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>

                                            <!-- Upgrade Button trigger modal -->
                                            <button type="button" class="btn w-100 btn-outline-info mb-3" data-toggle="modal" data-target="#UpgradeModal">
                                              Upgrade / Downgrade
                                            </button>

                                            <!-- Renew Modal -->
                                            <div class="modal fade" id="UpgradeModal" tabindex="-1" role="dialog" aria-labelledby="UpgradeModallLabel" aria-hidden="true">
                                              <div class="modal-dialog  modal-lg" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="UpgradeModalLabel">Upgrade / Downgrade</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class="modal-body">

                                                    <div class="alert alert-default" role="alert">
                                                      Upgrading your current plan to a more expensive plan will requrie you to pay the difference between your current plan and the new one.
                                                      Downgrading your current plan to a less expensive plan is free, but you won't receive any compensation.
                                                    </div>

                                                    <div class="row">
                                                    @foreach($upgrades as $key => $upgrade)
                                                    @if($upgrade->id !== $plan->id)
                                                      <div class="col-lg-4 col-md-6">
                                                          <div class="card card-profile" data-image="profile-image">
                                                              <div class="card-header">
                                                                  <div class="card-image">
                                                                      <a href="javascript:;">
                                                                          <img class="img rounded" src="{{ $upgrade->icon }}" style="width: 50%; margin-right: 25%; margin-left: 25%;" />
                                                                      </a>
                                                                  </div>
                                                              </div>

                                                              <div class="card-body pt-0">
                                                                  <h4 class="display-4 mb-0 plans-header">{{ $upgrade->name }}</h4>
                                                                  <div style="display: flex; align-items: center; justify-content: space-between;">
                                                                      <p class="lead">
                                                                          @if(isset($settings['currency_symbol'])){{ $settings['currency_symbol'] }} @endif{{ $upgrade->price()['price'] }} @if(isset($settings['paypal_currency'])){{ $settings['paypal_currency'] }} @endif / @if ($upgrade->days === 30)
                                                                          {!! Bill::lang()->get('monthly') !!} @elseif ($upgrade->days === 90) {!! Bill::lang()->get('quarterly') !!} @elseif ($upgrade->days === 0) {!! Bill::lang()->get('unlimited') !!} @else {{ $upgrade->days }} {!!
                                                                          Bill::lang()->get('days') !!} @endif
                                                                      </p>
                                                                      @if(isset($upgrade->discount) AND $upgrade->discount > 0)
                                                                      <span class="badge badge-pill badge-success discount-badge">{{ $upgrade->discount }}% OFF</span>
                                                                      @endif
                                                                  </div>
                                                                  <div class="table-responsive"></div>
                                                                  <div>
                                                                          <a  onClick="confirmUpgrade('{{route('billing.my-plans.upgrade', ['id' => $invoice->id])}}?plan={{ $upgrade->id }}')" style="width: 100%; margin-top: 15px;" class="btn btn-primary btn-round">@if($upgrade->price > $plan->price) <i class="bx bx-upvote"></i> Upgrade for {{ $settings['currency_symbol'] }}{{ $upgrade->price - $plan->price }} @else <i class="bx bx-downvote"></i> Downgrade for Free @endif</a>
                                                                          <a href="{{ route('billing.plans', ['game' => $game->link]) }}" style="width: 100%; margin-top: 15px;" class="btn btn-default btn-round">Learn More</a>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                    @endif
                                                  @endforeach
                                                    </div>
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{!! Bill::lang()->get('cancel') !!}</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>

                                            <!-- Manage Server Button -->
                                            <a href="/server/{{$server->uuidShort}}" class="btn w-100 btn-outline-warning mb-3">
                                              {!! Bill::lang()->get('manage_page') !!}
                                            </a>

                                            <!-- Delete Button trigger modal -->
                                            <button type="button" class="btn w-100 btn-outline-danger mb-3" data-toggle="modal" data-target="#DeleteModal">
                                              {!! Bill::lang()->get('request_cancellation') !!}
                                            </button>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="DeleteModalLabel" aria-hidden="true">
                                              <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="DeleteModalLabel">{!! Bill::lang()->get('request_cancellation') !!}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class="modal-body">
                                                    {!! Bill::lang()->get('remove_plan_info') !!}
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{!! Bill::lang()->get('close') !!}</button>
                                                    <a href="{{ route('billing.my-plans.cancel', ['id' => $invoice->id]) }}" type="button" class="btn btn-danger">{!! Bill::lang()->get('cancel') !!}</a>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>


                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  @if($plan->subdomain)
                                  <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                                    <p class="description">This feature is in test mode and has only been tested for minecraft servers</p>

                                      <form action="{{ route('billing.my-plans.subdomain') }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                          <label class="form-label" for="subdomain">{!! Bill::lang()->get('plan_subdomain') !!}</label>
                                          <input value="{{ $sub_name }}" name="subdomain" id="subdomain" class="form-input form-control" type="text" required />
                                        </div> 
                                        <div class="form-group">
                                          <label class="form-label" for="domain">{!! Bill::lang()->get('zone') !!}</label>
                                          <select name="domain" class="form-input form-control">
                                            @foreach(Bill::subdomain(null)->getAPIs() as $key => $value)
                                              <option value="{{ $value->id }}">{{ $value->domain }}</option>
                                            @endforeach
                                            
                                          </select>
                                        </div> 
                                        <div class="button-style">
                                          <input type="hidden" value="{{ $invoice->id }}" name="invoice_id" class="form-control">
                                          <button class="btn btn btn-primary submit" style="width: 100%;">{!! Bill::lang()->get('confirm') !!}</button>
                                        </div>

                                      </form>
                                  </div>
                                  @endif
                                  <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                                    
                                    <div class="">
                                      <div class="row justify-content-center">
                                        <div class="col-xl-12 order-xl-1">
                                          <div class="card" style="box-shadow: none;">
                                            <div class="">
                                              <div class="row align-items-center">
                                                <div class="col-4 text-right">
                                                </div>
                                              </div>
                                            </div>
                                            <div class="card-body">
                                              <table class="table">
                                                  <thead>
                                                      <tr>
                                                          <th class="text-center">#</th>
                                                          <th>{!! Bill::lang()->get('date_label') !!}</th>
                                                          <th>{!! Bill::lang()->get('price_label') !!}</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                    @if(!empty($invoice_logs))
                                                      @foreach($invoice_logs as $log)
                                                        <tr>
                                                          <td class="text-center">#{{ $log->id }}</td>
                                                          <td>{{ $log->created_at }}</td>
                                                          <td class="text-danger">{{ $log->data }} @if(isset($settings['paypal_currency'])){{ $settings['paypal_currency'] }}@endif</td>
                                                        </tr>
                                                      @endforeach
                                                    @endif 
                                                  </tbody>
                                              </table>
                                            </div>
                                          </div>
                                        </div>
                                        
                                      </div>
                                    </div>
                                    
                                  </div>
                              </div>
                          </div>
                      </div>

                    </div>
                    
                  </div>
                </div>

                
              </div>
            </div>
  
    </div>
    <script>
      var ip = '{{ $allocation->ip }}:{{ $allocation->port }}';
      var domain = '{{ $a_name }}';
      setInterval(setDomainText, 5000);

      function setDomainText() {
        if (document.getElementById("domain_text").textContent.trim() == ip) {
          if (domain.trim() != '') {
            document.getElementById("domain_text").innerHTML = '<span class="text-success text-sm font-weight-bolder">' + domain + '</span>';
          } else {
            document.getElementById("domain_text").innerHTML = '<span class="text-success text-sm font-weight-bolder">' + ip + '</span>';
          }
        } else {
          document.getElementById("domain_text").innerHTML = '<span class="text-success text-sm font-weight-bolder">' + ip + '</span>';
        }
      }

      function confirmUpgrade(redirect)
      {
        ask = confirm('Are you sure you want to Upgrade? You will be upgraded permanently. Please press "OK" to confirm.');
        if (ask == true) {
            window.location.href=redirect;
        }
      }
      
    </script>
  @endsection
</div>

@include('templates.Carbon.inc.style')
@include('templates.Carbon.inc.script')
