        <!-- ======= About Section ======= -->
        <section id="about" class="about">
            <div class="container" data-aos="fade-up">
      
              <div class="section-title">
                <h2>{!! Bill::lang()->get('about_us') !!}</h2>
                <p>{!! Bill::lang()->get('about_us_title') !!}</p>
              </div>
      
              <div class="row content">
                <div class="col-lg-6">
                  <p>
                    {!! Bill::lang()->get('about_us_text1') !!}
                  </p>
                  <ul>
                    {!! Bill::lang()->get('about_us_text2') !!}
                  </ul>
                </div>
                <div class="col-lg-6 pt-4 pt-lg-0">
                  <p style="display: flex;flex-direction: column;">
                    @if(isset($settings['billing_about_us'])){{ $settings['billing_about_us'] }} @else You can edit this section in Admin Area -> Billing -> General -> About @endif
                  <a href="/auth/register" class="btn-learn-more" style="text-align: center;"> {!! Bill::lang()->get('get_started') !!}</a>
                </div>
              </div>
      
            </div>
          </section><!-- End About Section -->