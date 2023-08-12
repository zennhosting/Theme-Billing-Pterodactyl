
  @if(Auth::user() !== NULL) 

  @include('templates.Carbon.inc.header')
  @include('templates.Carbon.inc.navbar', ['active_nav' => $page->url])
  <div class="grey-bg container-fluid">
    @extends('templates/wrapper', [
    'css' => ['body' => 'bg-neutral-800'],
    ])

  @section('container')
  
  <div class="mt-3 p-3">
  {!! html_entity_decode($page->data) !!}
  </div>
  
    
  
  @endsection
  </div>
  @include('templates.Carbon.inc.style')
  @include('templates.Carbon.inc.script')

  @else 
  @include('templates.Carbon.portal.includes.header')
  @include('templates.Carbon.portal.includes.sidebar')
      
  <body id="body-pd" class="mt-0" style="padding: 0;"> 
  
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top d-none">
      <div class="container d-flex align-items-center justify-content-between">
  
        <h1 class="logo"><a href="index.html">{{ config('app.name') }}</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html" class="logo"><img src="/themes/carbon/portal/img/logo.png" alt="" class="img-fluid"></a>-->
  
      </div>
    </header><!-- End Header -->
  
    <main id="main">

      <!-- ======= Sections ======= -->
      @include('templates.Carbon.portal.includes.sections.hero')
      <div class="container" style="margin-top: 50px;">
        {!! html_entity_decode($page->data) !!}
    </div>      
      <!-- ======= End Sections ======= -->
  
    @include('templates.Carbon.portal.includes.sections.mode')
    @include('templates.Carbon.portal.includes.footer')
    @include('templates.Carbon.portal.includes.style')
  @endif