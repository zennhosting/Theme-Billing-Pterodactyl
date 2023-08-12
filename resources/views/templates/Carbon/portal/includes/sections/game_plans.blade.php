        <!-- ======= Game Plans Section ======= -->
        <section id="pricing" class="pricing">
            <div class="container" data-aos="fade-up">
      
              <div class="section-title">
                <h2>{{ $game->label }} {!! Bill::lang()->get('plans_labal') !!}</h2>
                <p>{!! Bill::lang()->get('game_plans_section_text') !!}</p>
              </div>
      
              @if ($plans->isEmpty()) 
              <div class="alert alert-danger" role="alert">
                <span class="badge badge-danger" style="background:red;">{!! Bill::lang()->get('error') !!}</span> {!! Bill::lang()->get('err_plans_in_game') !!}
              </div>
              @endif
      
              <div class="row">
                @foreach($plans as $key => $plan)
                <div class="col-lg-4 col-md-6 mt-3" data-aos="zoom-im" data-aos-delay="100">
                  <div class="box">
                    <h3>{{ $plan->name }}</h3>
                    @if(isset($plan->discount) AND $plan->discount > 0)
                    <span class="badge badge-pill badge-success discount-badge">{{ $plan->discount }}% OFF</span>
                    @endif
                    <h4><sup> @if(isset($settings['currency_symbol'])){{ $settings['currency_symbol'] }} @endif</sup>{{ $plan->price }}<span> / @if ($plan->days === 30) {!! Bill::lang()->get('monthly') !!} @elseif ($plan->days  ===  90) {!! Bill::lang()->get('quarterly') !!} @elseif ($plan->days  ===  0) {!! Bill::lang()->get('unlimited') !!} @else {{ $plan->days }} {!! Bill::lang()->get('days') !!} @endif</span></h4>
                    <ul>
                      <li>{!! Bill::lang()->get('cpu') !!} {{ $plan->cpu_model }}</li>
                      <li>{!! Bill::lang()->get('ram') !!} @if ($plan->memory === 0) {!! Bill::lang()->get('unlimited') !!} @else {{ $plan->memory }} MB @endif</li>
                      <li>{!! Bill::lang()->get('storage') !!} @if ($plan->disk_space === 0) {!! Bill::lang()->get('unlimited') !!} @else {!! $plan->disk_space !!} MB @endif</li>
                      <li>{{ $plan->backup_limit }} {!! Bill::lang()->get('backup') !!}</li>
                      <li>{{ $plan->database_limit }} {!! Bill::lang()->get('database') !!}</li>
                      <li>{{ $plan->allocation_limit }} {!! Bill::lang()->get('exstra_ports') !!}</li>
                      @if($plan->plugins == 1)<li>{!! Bill::lang()->get('plugin_integration') !!}</li>@endif
      
                    </ul>
                    <h3 class="mt-2"><strong>{!! Bill::lang()->get('description') !!}</strong></h3>
                    <p class="mt-1">{!! $plan->description !!}</p>
                    
                    @isset(Auth::user()->email)

                    <form action="{{ route('billing.add.cart') }}" method="POST">
                      @csrf
                      <div class="btn-wrap">
                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                        <button type="submit" class="btn-buy" style="background: transparent;"><i class='bx bx-basket' ></i>{!! Bill::lang()->get('add_to_cart') !!}</button>
                      </div>
                    </form>
                    
                    @else
                    <a href="/auth/login" class="btn-buy"><i class='bx bx-basket' ></i>{!! Bill::lang()->get('add_to_cart') !!}</a>

                    @endisset

                  </div>
                </div>
                @endforeach
              </div>
      
              @if ($games->isEmpty()) 
              <div class="alert alert-danger mt-2" role="alert">
                <span class="badge badge-danger" style="background:red;">{!! Bill::lang()->get('error') !!}</span>{!! Bill::lang()->get('game_plans_section_text_empty') !!}
              </div>
              @endif

            <div class="row mt-4">
              @foreach($games as $key => $game)
      
              <div class="col-lg-4 col-md-6" data-aos="zoom-im" data-aos-delay="100">
                <div class="box game-box">
                <img class="mb-2" src="{{ $game->icon }}" style="width: 128px;">
                  <div class="btn-wrap">
                    <a href="{{ route('billing.portal.plans', ['game' => $game->link]) }}" class="btn-buy">{{ $game->label }} {!! Bill::lang()->get('plans_labal') !!}</a>
                  </div>
                </div>
              </div>
      
            @endforeach
           </div>
          </section><!-- End Game Plans Section -->