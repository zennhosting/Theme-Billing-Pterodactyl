    <!-- ======= Carousel Section ======= -->
    <section id="carousel" class="carousel">
        <div class="container">
          <div class="section-title">
            <h2>{!! Bill::lang()->get('game_panel') !!}</h2>
            <p>{!! Bill::lang()->get('game_panel_desc') !!}</p>
          </div>

          <div class="bd-example">
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2" aria-current="true"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
              </div>
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="@if(Bill::getMode() == 'off') /themes/carbon/portal/img/carousel/light1.png @else /themes/carbon/portal/img/carousel/dark1.png @endif" class="d-block w-100" alt="">            
            
                  <div class="carousel-caption d-none d-md-block">
                    <h5>{!! Bill::lang()->get('console_page') !!}</h5>
                    <p>{!! Bill::lang()->get('console_desc') !!}</p>
                  </div>
                </div>
                <div class="carousel-item">
                  <img src="@if(Bill::getMode() == 'off') /themes/carbon/portal/img/carousel/light2.png @else /themes/carbon/portal/img/carousel/dark2.png @endif" class="d-block w-100" alt="">            
                  <div class="carousel-caption d-none d-md-block">
                    <h5>{!! Bill::lang()->get('pl_installer') !!}</h5>
                    <p>{!! Bill::lang()->get('pl_installer_desc') !!}</p>
                  </div>
                </div>
                <div class="carousel-item">
                  <img src="@if(Bill::getMode() == 'off') /themes/carbon/portal/img/carousel/light3.png @else /themes/carbon/portal/img/carousel/dark3.png @endif" class="d-block w-100" alt="">            
            
                  <div class="carousel-caption d-none d-md-block">
                    <h5>{!! Bill::lang()->get('schedules') !!}</h5>
                    <p>{!! Bill::lang()->get('schedules_desc') !!}</p>
                  </div>
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
            </div>
        </div>
      </section>
      <!-- End Carousel Section -->