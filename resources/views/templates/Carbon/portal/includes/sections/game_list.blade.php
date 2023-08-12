        <!-- ======= Game List Section ======= -->
        <section id="pricing" class="pricing">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>{!! Bill::lang()->get('plans_labal') !!}</h2>
          <p>{!! Bill::lang()->get('game_list_desc_1') !!}</p>
        </div>

        @if ($games->isEmpty()) 
        <div class="alert alert-danger" role="alert">
          <span class="badge badge-danger" style="background:red;">{!! Bill::lang()->get('error') !!}</span> {!! Bill::lang()->get('game_list_desc_2') !!}
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

      </div>
    </section><!-- Game List Section -->