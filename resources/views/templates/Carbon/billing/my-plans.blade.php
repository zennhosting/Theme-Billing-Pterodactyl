    @include('templates.Carbon.inc.header')
    @include('templates.Carbon.inc.navbar', ['active_nav' => 'invoices'])
    <div class="grey-bg container-fluid">
      @extends('templates/wrapper', [
      'css' => ['body' => 'bg-neutral-800'],
      ])
    @section('container')
  

    <div class=" py-md pt-5">
  
          <div class="row">
            
            @include('templates.Carbon.inc.user-widget')

              <div class="col-xl-8 order-xl-1">
                <div class="card">
                  <div class="card-header">
                    <div class="row align-items-center">
                      <div class="col-12">
                        <h3 class="mb-0">{!! Bill::lang()->get('plan_page') !!}</h3>
                      </div>
                      <div class="col-4 text-right">
                      </div>
                    </div>
                  </div>
                  <div class="card-body">

                    <div class="row">

                      @if(!empty($invoices))
                      @foreach($invoices as  $invoice)
                        @if(isset($plans[$invoice->plan_id]))
                          
                        
                      
                          <div class="col-sm">
                            <div class="card" style="width: 18rem; background: transparent;">
                              <img class="card-img-top" src="@if(isset($settings['plans_img_url'])){{ $settings['plans_img_url'] }}@else /billing-src/img/plans.png @endif" alt="Plan Icon">
                              <div class="card-body">
                                <h3 class="card-title" style="display: flex;flex-direction: row;align-items: center;justify-content: space-between;">{{ $plans[$invoice->plan_id]->name }}<span class="badge badge-pill badge-@if($invoice->status == 'Paid')success @elseif($invoice->status == 'Unpaid' OR $invoice->status == 'Cancelled')danger @endif ">{{ $invoice->status }}</span></h3>                            
                                <p class="card-text">
                                  #{{ $invoice->id }}<br>
                                  {!! Bill::lang()->get('invoice_date') !!} {{ $invoice->invoice_date }}<br>
                                  {!! Bill::lang()->get('due_date') !!} {{ $invoice->due_date }}<br>
                                  {!! Bill::lang()->get('invoice_price') !!} @if(isset($plans[$invoice->plan_id])){{ $settings['currency_symbol'] }} {{ $plans[$invoice->plan_id]->price }} {{ $settings['paypal_currency'] }}@endif <br>


                                </p>
                                <a href="{{ route('billing.my-plans.plan', ['id' => $invoice->id]) }}" class="btn btn-warning mb-2" style="width: 100%; color: white !important;"><i class='bx bx-cog'></i> {!! Bill::lang()->get('settings_page') !!}</a>

                              </div>
                            </div>
                          </div>
                        @endif
                      @endforeach
                      @endif

                    </div>

                    @if(count($invoices) == 0)
                    <div class="row" style="display: flex;justify-content: center;">
                      <div class="alert alert-warning" role="alert">
                        You don't have any Plans purchased.
                      </div>
                      <a href="{{ route('billing.link') }}" type="button" class="btn btn-primary" style="width: 100%">{!! Bill::lang()->get('view_plan') !!}</a>
                    </div>
                    @endif
                    
                  </div>
                </div>
              </div>
            </div>
  
    </div>
  
  
  
  
    @endsection
    </div>
    @include('templates.Carbon.inc.style')
    @include('templates.Carbon.inc.script')