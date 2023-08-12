<!-- ======= Team Section ======= -->
@if(($teams = Bill::settings()->getTeams()) != null)
  <section id="team" class="team section-bg">
    <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>{!! Bill::lang()->get('team') !!}</h2>
          <p>{!! Bill::lang()->get('team_content') !!}</p>
        </div>

        <div class="row d-flex justify-content-center">

          @foreach($teams as $key => $value)
          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
            <div class="member">
              <div class="member-img">
                <img src="{!! $value['icon'] !!}" class="img-fluid" alt="">
                <div class="social">
                  @if(!empty($value['twitter']))
                    <a href="{!! $value['twitter'] !!}" target="_blank"><i class='bx bxl-twitter' ></i></a>
                  @endif
                  @if(!empty($value['twitch']))
                    <a href="{!! $value['twitch'] !!}" target="_blank"><i class='bx bxl-twitch' ></i></a>
                  @endif
                  @if(!empty($value['instagram']))
                    <a href="{!! $value['instagram'] !!}" target="_blank"><i class='bx bxl-instagram' ></i></i></a>
                  @endif
                  @if(!empty($value['discord']))
                    <a href="{!! $value['discord'] !!}" target="_blank"><i class='bx bxl-discord-alt' ></i></a>
                  @endif
                </div>
              </div>
              <div class="member-info">
                <h4>{!! $value['name'] !!}</h4>
                <span>{!! $value['role'] !!}</span>
              </div>
            </div>
          </div>
          @endforeach


        </div>

    </div>
  </section>
  <!-- End Team Section -->
@endif