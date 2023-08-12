  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
      <div class="row justify-content-center">
        <div class="col-xl-7 col-lg-9 text-center">
          <h1>@isset(Auth::user()->email) {!! Bill::lang()->get('welcome_back') !!} {{Auth::user()->name_first}} @else {!! Bill::lang()->get('panel_dreams') !!} @endisset</h1>
          <h2>{!! Bill::lang()->get('panel_dreams_text') !!}</h2>
        </div>
      </div>
      <div class="text-center">
        <a href="/auth/login" class="btn-get-started scrollto">@isset(Auth::user()->email) {!! Bill::lang()->get('manage_servers') !!} @else {!! Bill::lang()->get('dashboard') !!} @endisset</a>
      </div>

      <div class="row icon-boxes">
        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="200">
          <div class="icon-box">
            <div class="icon"><i class='bx bx-layer' ></i></div>
            <h4 class="title"><a href="">{!! Bill::lang()->get('easy_manage') !!}</a></h4>
            <p class="description">{!! Bill::lang()->get('easy_manage_text') !!}</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="300">
          <div class="icon-box">
            <div class="icon"><i class='bx bx-plug' ></i></div>
            <h4 class="title"><a href="">{!! Bill::lang()->get('plugins_manager') !!}</a></h4>
            <p class="description">{!! Bill::lang()->get('plugins_manager_desc') !!}</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="400">
          <div class="icon-box">
            <div class="icon"><i class='bx bx-adjust' ></i></div>
            <h4 class="title"><a href="">{!! Bill::lang()->get('portal_sw_mode') !!}</a></h4>
            <p class="description">{!! Bill::lang()->get('portal_sw_mode_desc') !!}</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="500">
          <div class="icon-box">
            <div class="icon"><i class='bx bxs-user-plus'></i></div>
            <h4 class="title"><a href="">{!! Bill::lang()->get('user_anagement') !!}</a></h4>
            <p class="description">{!! Bill::lang()->get('user_anagement_desc') !!}</p>
          </div>
        </div>

      </div>
    </div>
  </section><!-- End Hero -->