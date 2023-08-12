    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts section-bg">
      <div class="container">

        <div class="row justify-content-end">

          <div class="col-lg-3 col-md-5 col-6 d-md-flex align-items-md-stretch">
            <div class="count-box">
              <span data-purecounter-start="0" data-purecounter-end="{{ Bill::users()->getCount() }}" data-purecounter-duration="3" class="purecounter"></span>
              <p>{!! Bill::lang()->get('happy_clients') !!}</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-5 col-6 d-md-flex align-items-md-stretch">
            <div class="count-box">
              <span data-purecounter-start="0" data-purecounter-end="{{ Bill::plans()->getCount() }}" data-purecounter-duration="3" class="purecounter"></span>
              <p>{!! Bill::lang()->get('active_pans') !!}</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-5 col-6 d-md-flex align-items-md-stretch">
            <div class="count-box">
              <span data-purecounter-start="0" data-purecounter-end="{{ Bill::servers()->getCount() }}" data-purecounter-duration="3" class="purecounter"></span>
              <p>{!! Bill::lang()->get('active_servers') !!}</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-5 col-6 d-md-flex align-items-md-stretch">
            <div class="count-box">
              <span data-purecounter-start="0" data-purecounter-end="99" data-purecounter-duration="3" class="purecounter"></span>
              <p>{!! Bill::lang()->get('uptime') !!}</p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Counts Section -->