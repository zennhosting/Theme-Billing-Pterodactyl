@if (!Auth::check())
   <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
        <div class="container" data-aos="zoom-in">
          <div class="text-center">
            <h3>{!! Bill::lang()->get('register_now') !!}</h3>
            <p>{!! Bill::lang()->get('register_now_desc') !!}</p>
            <a class="cta-btn" href="/auth/register">{!! Bill::lang()->get('create_account') !!}</a>
          </div>
        </div>
      </section><!-- End Cta Section -->
@endif
