  @include('templates.Carbon.inc.header')
  @include('templates.Carbon.inc.navbar', ['active_nav' => 'billing'])
  <div class="grey-bg container-fluid">
    @extends('templates/wrapper', [
    'css' => ['body' => 'bg-neutral-800'],
    ])
  @section('container')


  <section class="section team-2">


    <div class="container pt-5">
      <div class="row">

      <div class="col-md-8 mx-auto text-center mb-5">
        <h3 class="display-3">{{ $game->label }} {!! Bill::lang()->get('plans_labal') !!}</h3>
      </div>
      </div>

      @if ($plans->isEmpty()) 
      <div class="alert alert-danger" role="alert"> <span class="badge badge-danger">{!! Bill::lang()->get('error') !!}</span>
        {!! Bill::lang()->get('err_plans_in_game') !!} @if(Auth::user()->root_admin)<a href="{{ route('admin.billing.plans') }}" class="btn btn-primary btn-sm ml-2">Create Plan</a>@endif
      </div>
      @endif

      <div class="row justify-content-center">
        @foreach($plans as $key => $plan)
      <div class="col-lg-4 col-md-6">
        
        <div class="card card-profile" data-image="profile-image">
        <div class="card-header">
          <div class="card-image">
          <a href="javascript:;">
            <img class="img rounded" src="{{ $plan->icon }}" style="width: 50%;margin-right: 25%;margin-left: 25%;">
          </a>
          </div>
          
        </div>

        <div class="card-body pt-0">
          <h4 class="display-4 mb-0 plans-header">{{ $plan->name }}</h4>
          <div style="display: flex;align-items: center;justify-content: space-between;"> 
            <p class="lead">
              @if(isset($settings['currency_symbol'])){{ $settings['currency_symbol'] }} @endif{{ $plan->price()['price'] }} @if(isset($settings['paypal_currency'])){{ $settings['paypal_currency'] }} @endif / {{ Bill::helpers()->daysToHuman($plan->days) }} 
            </p>
            @if(isset($plan->discount) AND $plan->discount > 0)
            <span class="badge badge-pill badge-success discount-badge">{{ $plan->discount }}% OFF</span>
            @endif
          </div>
          <div class="table-responsive">
          <ul class="list-unstyled" style="margin-bottom: 0;">
            <li class="py-1">
            <div class="d-flex align-items-center">
              <div>
              <div class="badge badge-circle badge-info mr-3"><i class='bx bxs-chip' ></i></div>
              </div>
              <div>
              <h4 class="mb-1">{!! Bill::lang()->get('cpu') !!} {{ $plan->cpu_model }}</h4>
              </div>
            </div>
            </li>
            <li class="py-1">
            <div class="d-flex align-items-center">
              <div>
              <div class="badge badge-circle badge-success mr-3"><i class='bx bxs-microchip' ></i> </div>
              </div>
              <div>
              <h4 class="mb-1">{!! Bill::lang()->get('ram') !!} @if ($plan->memory === 0) {!! Bill::lang()->get('unlimited') !!} @else {{ $plan->memory }} MB @endif</h4>
              </div>
            </div>
            </li>
            <li class="py-1">
            <div class="d-flex align-items-center">
              <div>
              <div class="badge badge-circle mr-3" style="background: #FFFF; color: #563cc3;"><i class='bx bxs-hdd'></i> </div>
              </div>
              <div>
              <h4 class="mb-1">{!! Bill::lang()->get('storage') !!} @if ($plan->disk_space === 0) {!! Bill::lang()->get('unlimited') !!} @else {!! $plan->disk_space !!} MB @endif</h4>
              </div>
            </div>
            </li>
          </ul>
          <ul class="list-unstyled">
            <li class="py-1">
            <div class="d-flex align-items-center">
              <div>
              <div class="badge badge-circle badge-info mr-3"><i class='bx bxs-copy'></i></div>
              </div>
              <div>
              <h4 class="mb-1">{{ $plan->backup_limit }} {!! Bill::lang()->get('backup') !!} </h4>
              </div>
            </div>
            </li>
            <li class="py-1">
            <div class="d-flex align-items-center">
              <div>
              <div class="badge badge-circle badge-success mr-3"><i class='bx bxs-data' ></i></div>
              </div>
              <div>
              <h4 class="mb-1">{{ $plan->database_limit }} {!! Bill::lang()->get('database') !!} </h4>
              </div>
            </div>
            </li>
            <li class="py-1">
            <div class="d-flex align-items-center">
              <div>
              <div class="badge badge-circle mr-3" style="background: #FFFF; color: #563cc3;"><i class='bx bx-wifi'></i></div>
              </div>
              <div>
              <h4 class="mb-1">{{ $plan->allocation_limit }} {!! Bill::lang()->get('exstra_ports') !!}</h4>
              </div>
            </div>
            </li>
            @if($plan->plugins == 1)
            <li class="py-1">
              <div class="d-flex align-items-center">
                <div>
                <div class="badge badge-circle badge-info mr-3"><i class='bx bxs-plug'></i></div>
                </div>
                <div>
                <h4 class="mb-1">{!! Bill::lang()->get('plugin_integration') !!}</h4>
                </div>
              </div>
            </li>
            @endif
            @if($plan->subdomain == 1)
            <li class="py-1">
              <div class="d-flex align-items-center">
                <div>
                <div class="badge badge-circle badge-success mr-3"><i class='bx bx-atom'></i></div>
                </div>
                <div>
                <h4 class="mb-1">{!! Bill::lang()->get('subdomain_integration') !!}</h4>
                </div>
              </div>
            </li>
            @endif
          </ul>
          </div>
            <div>
              <h2 style="padding-top: 15px;">{!! Bill::lang()->get('description') !!}</h2>
              <a>{!! $plan->description !!}</a>
            <form action="{{ route('billing.add.cart') }}" method="POST">
              @csrf
              <input type="hidden" name="plan_id" value="{{ $plan->id }}">
              <button type="submit" style="width: 100%; margin-top: 15px;" class="btn btn-primary btn-round"><i class='bx bx-basket' ></i>{!! Bill::lang()->get('add_to_cart') !!}</button>
            </form>  
            </div>
        </div>

        </div>

       


      </div>
      @endforeach


    </section>




  @endsection
  </div>
  @include('templates.Carbon.inc.style')
  @include('templates.Carbon.inc.script')