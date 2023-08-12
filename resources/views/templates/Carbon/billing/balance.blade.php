@include('templates.Carbon.inc.header')
@include('templates.Carbon.inc.navbar', ['active_nav' => 'balance'])

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
                <h3 class="mb-0">{!! Bill::lang()->get('account_balance') !!}</h3>
              </div>
              <div class="col-4 text-right">
              </div>
            </div>
          </div>


          <div class="card-body">
            <div class="nav-wrapper">
              <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                  @isset($settings['paypal_gateway'])@if( $settings['paypal_gateway'] == "true")
                  <li class="nav-item">
                      <a class="nav-link navs-btn mb-sm-3 mb-md-0 active " id="tabs-icons-text-paypal-tab" data-toggle="tab" href="#tabs-icons-text-paypal" role="tab" aria-controls="tabs-icons-text-paypal" aria-selected="true"><i class="ni ni-cloud-upload-96 mr-2"></i>{!! Bill::lang()->get('paypal') !!}</a>
                  </li>
                  @endif @endisset
                  @isset($settings['stripe_gateway'])@if( $settings['stripe_gateway'] == "true")
                  <li class="nav-item">
                      <a class="nav-link navs-btn mb-sm-3 mb-md-0" id="tabs-icons-text-stripe-tab" data-toggle="tab" href="#tabs-icons-text-stripe" role="tab" aria-controls="tabs-icons-text-stripe" aria-selected="false"><i class="ni ni-bell-55 mr-2"></i>{!! Bill::lang()->get('stripe') !!}</a>
                  </li>
                  @endif @endisset

                  @isset($settings['gateway_bitpave'])@if( $settings['gateway_bitpave'] == "true")
                  <li class="nav-item">
                      <a class="nav-link navs-btn mb-sm-3 mb-md-0" id="tabs-icons-text-bitpave-tab" data-toggle="tab" href="#tabs-icons-text-bitpave" role="tab" aria-controls="tabs-icons-text-bitpave" aria-selected="false"><i class="ni ni-bell-55 mr-2"></i>Bitcoin</a>
                  </li>
                  @endif @endisset

                  @isset($settings['giftcards'])@if( $settings['giftcards'] == "true")
                  <li class="nav-item">
                      <a class="nav-link navs-btn mb-sm-3 mb-md-0 " id="tabs-icons-text-giftcards-tab" data-toggle="tab" href="#tabs-icons-text-giftcards" role="tab" aria-controls="tabs-icons-text-giftcards" aria-selected="false"><i class="ni ni-cloud-upload-96 mr-2"></i>{!! Bill::lang()->get('gift_card') !!}</a>
                  </li>
                  @endif @endisset
                  <li class="nav-item">
                    <a class="nav-link navs-btn mb-sm-3 mb-md-0" id="tabs-icons-text-info-tab" data-toggle="tab" href="#tabs-icons-text-info" role="tab" aria-controls="tabs-icons-text-info" aria-selected="false"><i class="ni ni-bell-55 mr-2"></i>{!! Bill::lang()->get('billing_information') !!}</a>
                </li>
              </ul>
            </div>
          </div>
      
          <div class="card-body">
            <div class="tab-content" id="myTabContent">

              @isset($settings['paypal_gateway'])@if( $settings['paypal_gateway'] == "true")
              <div class="tab-pane fade show active" id="tabs-icons-text-paypal" role="tabpanel" aria-labelledby="tabs-icons-text-paypal-tab">
                <form action="{{ route('paypal.process') }}" method="POST">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="form-control-label" for="balance">{!! Bill::lang()->get('amount_info') !!}</label>
                        <input id="balance" name="amount" class="form-control" placeholder="5" type="number">
                      </div>
                    </div>
                  </div>
                  <button type="submit" class="paypal-btn btn"><img style="width: 10%" src="/billing-src/img/paypal.png"></button>
                </form>
              </div>
              @endif @endisset

              @isset($settings['gateway_bitpave'])@if( $settings['gateway_bitpave'] == "true")
              <div class="tab-pane fade show" id="tabs-icons-text-bitpave" role="tabpanel" aria-labelledby="tabs-icons-text-bitpave-tab">
                <form action="{{ route('bitpave.checkout') }}" target="_blank" method="POST">
                  @csrf
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="form-control-label" for="balance">{!! Bill::lang()->get('amount_info') !!}</label>
                        <input class="form-control" id="gift-card-code-input" name="amount" type="number" value="5">
                      </div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary" style="width: 100%"><strong>{!! Bill::lang()->get('confirm') !!}</strong></button>
                </form>
              </div>
              @endif @endisset

              @isset($settings['giftcards'])@if( $settings['giftcards'] == "true")
              <div class="tab-pane fade show" id="tabs-icons-text-giftcards" role="tabpanel" aria-labelledby="tabs-icons-text-giftcards-tab">
                <form action="{{ route('billing.balance.giftcard') }}" method="POST">
                  @csrf
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="form-control-label" for="balance">{!! Bill::lang()->get('gift_card_code') !!}</label>
                        <input class="form-control" id="gift-card-code-input" name="code" placeholder="XXXX-XXXX-XXXX">
                      </div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary" style="width: 100%"><strong>{!! Bill::lang()->get('confirm') !!}</strong></button>
                </form>
              </div>
              @endif @endisset
              
              @isset($settings['stripe_gateway'])@if( $settings['stripe_gateway'] == "true")
              <div class="tab-pane fade" id="tabs-icons-text-stripe" role="tabpanel" aria-labelledby="tabs-icons-text-stripe-tab">

                <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
                <script type="text/javascript">
                    Stripe.setPublishableKey('{{ $settings['publishable_key'] }}');
                    $(function() {
                      var $form = $('#payment-form');
                      $form.submit(function(event) {
                      // Disable the submit button to prevent repeated clicks:
                      $form.find('.submit').prop('disabled', true);
                        
                      // Request a token from Stripe:
                      Stripe.card.createToken($form, stripeResponseHandler);
                        
                      // Prevent the form from being submitted:
                      return false;
                      });
                    });
                    function stripeResponseHandler(status, response) {
                      // Grab the form:
                      var $form = $('#payment-form');
                        
                      if (response.error) { // Problem!
                        // Show the errors on the form:
                        $form.find('.payment-errors').text(response.error.message);
                        $form.find('.submit').prop('disabled', false); // Re-enable submission
                      }else { // Token was created!
                        // Get the token ID:
                        var token = response.id;
                      // Insert the token ID into the form so it gets submitted to the server:
                        $form.append($('<input type="hidden" name="stripeToken">').val(token));
                      // Submit the form:
                        $form.get(0).submit();
                      }
                    };
                </script>

                  <form action="{{ route('billing.balance.stripe') }}" method="post" name="cardpayment" id="payment-form">
                    @csrf
                    <div class="form-group">
                      <label class="form-label" for="name">{!! Bill::lang()->get('amount_info') !!}</label>
                      <input name="amount" id="amount" class="form-input form-control" type="number" required />
                    </div>  
                    <div class="form-group">
                      <label class="form-label" for="name">{!! Bill::lang()->get('card_holder') !!}</label>
                      <input name="holdername" id="name" class="form-input form-control" type="text" value="{{ Auth::user()->name }}" required />
                    </div>               
                    <div class="form-group">
                      <label class="form-label" for="email">{!! Bill::lang()->get('email') !!}</label>
                      <input name="email" id="email" class="form-input form-control" type="email" value="{{ Auth::user()->email }}" required />
                    </div>         
                    <div class="form-group">
                     <label class="form-label" for="card">{!! Bill::lang()->get('caed_number') !!}</label>
                     <input name="cardnumber" id="card" class="form-input form-control" type="text" maxlength="16" data-stripe="number" required />
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <label class="form-label">{!! Bill::lang()->get('monthly') !!}</label>
                            <select name="month" id="month" class="form-input2 form-control" data-stripe="exp_month">
                              <option value="01">01</option>
                              <option value="02">02</option>
                              <option value="03">03</option>
                              <option value="04">04</option>
                              <option value="05">05</option>
                              <option value="06">06</option>
                              <option value="07">07</option>
                              <option value="08">08</option>
                              <option value="09">09</option>
                              <option value="10">10</option>
                              <option value="11">11</option>
                              <option value="12">12</option>
                            </select>
                          </div>
                          <div class="col-lg-4">
                            <label class="form-label">{!! Bill::lang()->get('year') !!}</label>
                            <select name="year" id="year" class="form-input2 form-control" data-stripe="exp_year">
                              <option value="21">2021</option>
                              <option value="22">2022</option>
                              <option value="23">2023</option>
                              <option value="24">2024</option>
                              <option value="25">2025</option>
                              <option value="26">2026</option>
                              <option value="27">2027</option>
                              <option value="28">2028</option>
                              <option value="29">2029</option>
                              <option value="30">2030</option>
                            </select>
                          </div>
                          <div class="col-lg-4">
                            <label class="form-label">{!! Bill::lang()->get('cvv') !!}</label>
                            <input name="cvv" id="cvv" class="form-input2 form-control" type="text" placeholder="CVV" data-stripe="cvc" required />
                          </div>
                    </div>
                    <div class="form-group">
                      <div class="payment-errors"></div>
                    </div>
                    <div class="button-style">
                      <input type="hidden" value="{{ Auth::user()->id }}" name="name" class="form-control">
                      <button class="btn btn btn-primary submit" style="width: 100%;">{!! Bill::lang()->get('pay_now') !!}</button>
                    </div>
                  </form>
              </div>
              @endif @endisset

              <div class="tab-pane fade" id="tabs-icons-text-info" role="tabpanel" aria-labelledby="tabs-icons-text-info-tab">

                <form action="{{ route('billing.user.update') }}" method="POST">
                  @csrf
                  <h6 class="heading-small text-muted mb-4">{!! Bill::lang()->get('billing_information') !!}</h6>
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-username">{!! Bill::lang()->get('username') !!}</label>
                          <input type="text" id="input-username" class="form-control" placeholder="Username" value="{{ Auth::user()->username }}" disabled>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-email">{!! Bill::lang()->get('email') !!}</label>
                          <input type="email" id="input-email" class="form-control" placeholder="{{ Auth::user()->email }}" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-first-name">{!! Bill::lang()->get('first_name') !!}</label>
                          <input type="text" id="input-first-name" class="form-control" placeholder="First name" value="{{ Auth::user()->name_first }}" disabled>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-last-name">{!! Bill::lang()->get('last_name') !!}</label>
                          <input type="text" id="input-last-name" class="form-control" placeholder="Last name" value="{{ Auth::user()->name_last }}" disabled>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-address">{!! Bill::lang()->get('address') !!}</label>
                          <input id="input-address" class="form-control" name="address" placeholder="Home Address" value="@if(isset($billding_user->address)){{ $billding_user->address }} @else Bld Mihail Kogalniceanu, nr. 8 Bl 1, Sc 1, Ap 09 @endif" type="text">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="form-control-label" for="input-city">{!! Bill::lang()->get('city') !!}</label>
                          <input type="text" id="input-city" class="form-control" name="city" placeholder="City" value="@if(isset($billding_user->city)){{ $billding_user->city }} @else New York @endif">
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="form-control-label" for="input-country">{!! Bill::lang()->get('country') !!}</label>
                          <input type="text" id="input-country" class="form-control" name="country" placeholder="Country" value="@if(isset($billding_user->country)){{ $billding_user->country }} @else United States @endif">
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="form-control-label" for="input-country">{!! Bill::lang()->get('postal_code') !!}</label>
                          <input type="text" id="input-postal-code" class="form-control" name="postal_code" placeholder="@if(isset($billding_user->postal_code)){{ $billding_user->postal_code }} @else Postal code @endif">
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Button -->
                  <button type="submit" class="btn btn-primary" style="width: 100%"><strong>{!! Bill::lang()->get('update_billing_nformation') !!}</strong></button>
                </form>

              </div>
            </div>

              
          </div>
        </div>

      </div>
    </div>
</div>

@endsection

@include('templates.Carbon.inc.style')
@include('templates.Carbon.inc.script')
