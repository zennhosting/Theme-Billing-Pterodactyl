@include('templates.Carbon.inc.header')
@include('templates.Carbon.inc.navbar', ['active_nav' => 'cart'])
<div class="grey-bg container-fluid">
  @extends('templates/wrapper', [
  'css' => ['body' => 'bg-neutral-800'],
  ])
  @section('container')

  @php
  $order_price = 0;
  $getAffiliate = Auth::user()->id.'_affiliate';
  @endphp
  <div class=" py-md pt-5">

    <div class="row">

      <div class="col-xl-4 order-xl-2">
        <div class="card card-profile">

          <div class="row justify-content-center">
            <div class="col-lg-3 order-lg-2">
              <div class="card-profile-image">
                <a href="#">

                </a>
              </div>
            </div>
          </div>

          <div class="card-body pt-0">
            <div class="row">
              <div class="col">
                <div class="card-profile-stats d-flex justify-content-center">
                  <div>
                    <h1>Order Summary</h1>
                    <hr>
                    <!-- <span class="heading">$ 5.9 USD</span>
                    <span class="description">Balance</span> -->
                  </div>
                </div>
              </div>
            </div>
            <div class="text-left">
              @if(!empty($carts))
              @foreach($carts as $cart_id => $cart)
              <p class="flex" style="justify-content: space-between;">
                <span class="heading"> {{ $cart->name }}</span>
                <span class="description">@if(isset($settings['currency_symbol'])){{ $settings['currency_symbol'] }} @endif {{ $cart->price }} @if(isset($settings['paypal_currency'])){{ $settings['paypal_currency'] }}@endif / {{ Bill::helpers()->daysToHuman($cart->days) }} </span>
              </p>
              @endforeach
              @else
              <h2>Cart is empty</h2>
              @endif
              <hr>
              <h4>Payment Method</h4>
              <div class="custom-control custom-radio mb-3">
                <input name="custom-radio-1" class="custom-control-input" id="customRadio4" checked="" type="radio">
                <label class="custom-control-label" for="customRadio4">Account Balance: @if(isset($settings['currency_symbol'])){{ $settings['currency_symbol'] }} @endif{{ $billding_user->balance }} @if(isset($settings['paypal_currency'])){{ $settings['paypal_currency'] }}@endif</label>
              </div>
              <a data-toggle="modal" data-target="#orderAll" class="btn btn-primary mt-2" style="width: 100%;">{!! Bill::lang()->get('place_order') !!}</a>
              <div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-8 order-xl-1">

        @if(Cache::has($getAffiliate))
        <div class="alert alert-info alert-with-icon">
          <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
            <i class="tim-icons icon-simple-remove"></i>
          </button>
          <span data-notify="icon" class="tim-icons icon-trophy"></span>
          <span><b> Discount Applied! - </b> You have received an automatic discount since you were invited by an affiliate.</span>
        </div>
        @endif

        <div class="card">
          <div class="card-header">
            <div class="row align-items-center">
              <div class="col-12">
                <h3 class="mb-0">{!! Bill::lang()->get('checkout') !!}</h3>
              </div>
              <div class="col-4 text-right">
              </div>
            </div>
          </div>
          <div class="card-body">

            @if(!empty($carts))
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>{!! Bill::lang()->get('plan_name') !!}</th>
                    <th>{!! Bill::lang()->get('game') !!}</th>
                    <th>{!! Bill::lang()->get('invoice_price') !!}</th>
                    <th class="text-right">{!! Bill::lang()->get('billed') !!}</th>
                    <th class="text-right">{!! Bill::lang()->get('actions') !!}</th>
                  </tr>
                </thead>
                <tbody>

                  @foreach($carts as $cart_id => $cart)
                  <tr>
                    <td class="text-center"><img class="img rounded" src="{{ $cart->icon }}" style="width: 25px;margin-right: 25%;margin-left: 25%;"></td>
                    <td>{{ $cart->name }}</td>
                    <td>{{ $cart->getGameName() }}</td>
                    <td>@if(isset($settings['currency_symbol'])){{ $settings['currency_symbol'] }}@endif{{ $cart->price()['price'] }} @if(isset($settings['paypal_currency'])){{ $settings['paypal_currency'] }}@endif</td>
                    <td class="text-right">{{ Bill::helpers()->daysToHuman($cart->days) }}</td>
                    <td class="td-actions text-right">
                      <form action="{{ route('billing.remove.cart') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan_id" value="{{ $cart_id }}">
                        <button type="submit" rel="tooltip" class="btn btn-danger btn-icon btn-sm btn-simple" title="Remove">
                          <i class='bx bx-x'></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                  @php
                  if (isset($cart->price()['price'])) {
                  $order_price = $order_price + $cart->price()['price'];
                  }

                  @endphp
                  @endforeach




                </tbody>
              </table>
            </div>
            <!-- <a data-toggle="modal" data-target="#orderAll" class="btn btn-primary mt-2" style="width: 100%;">{!! Bill::lang()->get('place_order') !!}</a> -->
          </div>
          @else
          <div class="flex" style="display: flex;flex-direction: column;align-items: center;">
            <i class='bx bx-package' style="font-size: 45px;"></i>
            <h3>{!! Bill::lang()->get('empty_cart') !!} </h3>
            <a href="{{ route('billing.link') }}" type="button" class="btn btn-primary" style="width: 30%">{!! Bill::lang()->get('view_plan') !!}</a>
          </div>

          @endif
        </div>
      </div>
    </div>

  </div>

  <div style="width: 100%; margin-block-start: 100px;" class="modal" id="orderAll" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header card-header">
          <h5 class="modal-title">{!! Bill::lang()->get('are_you_sure') !!}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @php
        $normal_price = $order_price;

        if(Cache::has($getAffiliate)) {
        $affiliate = Cache::get($getAffiliate);

        $minus = $order_price / 100 * $affiliate['discount'];
        $creator_commision = $order_price / 100 * $affiliate['creator_commision'];

        $order_price = $order_price - $minus;
        }
        @endphp
        <div class="modal-body card-body">
          <strong>{!! Bill::lang()->get('confirm_place_order_info') !!}</strong>
          <p>{!! Bill::lang()->get('total_order') !!} {{ $normal_price }} @if(isset($settings['paypal_currency'])){{ $settings['paypal_currency'] }}@endif</p>

          <div class="form-group">
            <label class="form-control-label" for="input-affiliate">Affiliate Code</label>
            <input type="text" id="input-affiliate-code" class="form-control" placeholder="affiliate" @if(Cache::has($getAffiliate)) value="{{ $affiliate['code'] }}" @endif>
          </div>
          <a onclick="Apply()" class="btn btn-primary btn-icon btn-sm mb-2">@if(Cache::has($getAffiliate)) Apply New Code @else Apply @endif</a>
          <a href="/affiliate/remove/apply" class="btn btn-danger btn-icon btn-sm mb-2">Remove</a><br>

          @if(Cache::has($getAffiliate))
          Creator Commision: {{ $creator_commision }} @if(isset($settings['paypal_currency'])){{ $settings['paypal_currency'] }}@endif <br>
          {!! Bill::lang()->get('total_order') !!} {{ $normal_price }} @if(isset($settings['paypal_currency'])){{ $settings['paypal_currency'] }}@endif <br>
          New {!! Bill::lang()->get('total_order') !!} {{ $order_price }} @if(isset($settings['paypal_currency'])){{ $settings['paypal_currency'] }}@endif
          <a href="#" class="badge badge-pill badge-default">{{$affiliate['discount']}} % Discount</a>

          @endif
        </div>
        <div class="modal-footer card-body">
          <button type="button" class="btn btn-secondary btn-icon btn-sm btn-secondary" data-dismiss="modal">{!! Bill::lang()->get('cancel') !!}</button>
          <a onclick="this.parentNode.style.display = 'none';" href="{{ route('billing.cart.order.all') }}" class="btn btn-success btn-icon btn-sm">{!! Bill::lang()->get('confirm') !!}</a>
        </div>
      </div>
    </div>
  </div>


  @endsection

  <script>
    function Apply() {
      var code = document.getElementById('input-affiliate-code').value;
      window.location.href = "/affiliate/" + code + "/apply";
    }

  </script>
</div>
@include('templates.Carbon.inc.style')
@include('templates.Carbon.inc.script')
