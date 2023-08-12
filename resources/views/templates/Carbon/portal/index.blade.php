@include('templates.Carbon.portal.includes.header')
@include('templates.Carbon.portal.includes.sidebar')

<body id="body-pd" class="mt-0" style="padding: ;">
  @include('templates.Carbon.portal.includes.sections.hero')

  <!-- ======= Main ======= -->
  <main id="main">

    <!-- ======= Sections ======= -->
    @include('templates.Carbon.portal.includes.sections.counts')
    @include('templates.Carbon.portal.includes.sections.carousel')
    @include('templates.Carbon.portal.includes.sections.features')
    @include('templates.Carbon.portal.includes.sections.game_list')
    @include('templates.Carbon.portal.includes.sections.cta')
    @include('templates.Carbon.portal.includes.sections.about')
    @include('templates.Carbon.portal.includes.sections.team')
    @include('templates.Carbon.portal.includes.sections.faq')
    <!-- ======= End Sections ======= -->

  </main><!-- End #main -->

  @include('templates.Carbon.portal.includes.sections.mode')
  @include('templates.Carbon.portal.includes.footer')
  @include('templates.Carbon.portal.includes.style')
