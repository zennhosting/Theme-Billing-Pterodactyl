<!-- ======= Frequently Asked Questions Section ======= -->
@if(($faqs = Bill::settings()->getFaqs()) != null)
  <section id="faq" class="faq section-bg">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>{!! Bill::lang()->get('faq_section_title') !!}</h2>
        <p>{!! Bill::lang()->get('faq_section_title_desc') !!}</p>
      </div>

      <div class="faq-list">
        <ul>
          @foreach($faqs as $key => $value)
            <li data-aos="fade-up">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse" data-bs-target="#faq-list-{{ $key }}">{!! $value['title'] !!}<i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-{{ $key }}" class="collapse faq-w" data-bs-parent=".faq-list">
                <p>
                  {!! $value['content'] !!}
                </p>
              </div>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </section>
@endif
  <!-- End Frequently Asked Questions Section -->