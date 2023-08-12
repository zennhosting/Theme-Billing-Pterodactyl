  <!-- ======= Footer ======= -->
  <footer id="footer" class="bg-3 mt-5">

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h3><strong>{{ config('app.name') }}</strong></h3>
            @if(isset($settings['footer_address'])){!! $settings['footer_address'] !!}@else <p>A108 Adam Street <br>New York, NY 535022<br>United States <br><br><strong>Phone:</strong> +1 5589 55488 55<br><strong>Email:</strong> info@example.com<br></p> @endif
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>{!! Bill::lang()->get('useful_links') !!}</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#hero">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="/auth/login">{!! Bill::lang()->get('create_account') !!}</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">{!! Bill::lang()->get('register_now') !!}</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="{{ route('billing.cart') }}">{!! Bill::lang()->get('cart_page') !!}</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="{{ route('billing.my-plans') }}">{!! Bill::lang()->get('plan_page') !!}</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="/account">{!! Bill::lang()->get('account_page') !!}</a></li>

            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>{!! Bill::lang()->get('games') !!}</h4>
            <ul>
              @isset($games)@foreach($games as $key => $game)
              <li><i class="bx bx-chevron-right"></i> <a href="{{ route('billing.portal.plans', ['game' => $game->link]) }}">{{ $game->label }}</a></li>
              @endforeach @endisset

            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-newsletter">
            <h4>{!! Bill::lang()->get('about_us') !!}</h4>
            <p>@if(isset($settings['billing_about_us'])){{ $settings['billing_about_us'] }} @else You can edit this section in Admin Area -> Billing -> General -> About @endif</p>
          </div>

        </div>
      </div>
    </div>

    <div class="container d-md-flex py-4 bg-3">

      <div class="me-md-auto text-center text-md-start">
        <div class="copyright">
          &copy; Copyright <strong><span>{{ config('app.name') }}</span></strong>. All Rights Reserved
        </div>
      @if(!Bill::allowed('unbranded'))
        <div class="credits">
          <strong>Powered by <a href="https://wemx.net" target="_blank">WemX</a></strong>
        </div>
      @endif
      </div>
      <div class="social-links text-center text-md-right pt-3 pt-md-0">
        <a href="{{ Bill::settings()->getParam('discord_server') }}" target="_blank" class="twitter"><i class='bx bxl-discord-alt'></i></a>
        <a href="/toggle" class="twitter"><i class='bx bx-adjust' ></i></a>

      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class='bx bx-up-arrow-alt' ></i></i></a>

  <!-- Vendor JS Files -->
  <script src="/themes/carbon/portal/vendor/purecounter/purecounter.js"></script>
  <script src="/themes/carbon/portal/vendor/aos/aos.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/themes/carbon/portal/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="/themes/carbon/portal/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="/themes/carbon/portal/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="/themes/carbon/portal/js/main.js"></script>

</body>

</html>

