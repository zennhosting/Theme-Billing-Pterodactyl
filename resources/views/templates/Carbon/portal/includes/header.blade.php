<!DOCTYPE html>
<html lang="en">

<head class="header d-none" id="header">
  <title>{{ config('app.name') }}</title>
  <meta property="og:title"
    content="@if(isset($settings['meta_title'])){{ $settings['meta_title'] }}@else {{ config('app.name') }} @endif">
  <meta property="og:type" content="website">
  <meta property="og:url" content="/">
  <meta property="og:image"
    content="@if(isset($settings['meta_image'])){{ $settings['meta_image'] }}@else https://cdn.resourcemc.net/zAsa7/rIBOyeRU58.png/raw @endif">
  <meta property="og:description"
    content="@if(isset($settings['meta_desc'])){{ $settings['meta_desc'] }}@else Manage your server with an easy-to-use Panel @endif">
  <meta name="theme-color"
    content="@if(isset($settings['meta_color'])){{ $settings['meta_color'] }}@else #0e4688 @endif">

  <!-- Favicons -->
  <link href="@if(isset($settings['favicon'])){{ $settings['favicon'] }}@else /favicons/favicon-32x32.png @endif"
    rel="icon" type="image/x-icon">
  <link href="@if(isset($settings['favicon'])){{ $settings['favicon'] }}@else /favicons/favicon-32x32.png @endif"
    rel="apple-touch-icon">


  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="/themes/carbon/portal/vendor/aos/aos.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet">


  <!-- Template Main CSS File -->
  <link href="/themes/carbon/portal/css/style.css" rel="stylesheet">
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
</head>

<body>
  <div id="preloader"></div>
  <div class="navigation" style="padding: 30px">
    <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
    <nav id="navbar" class="navbar">
      <ul>
        <li><a href="{{ route('billing.toggle.mode') }}"><strong>{{ Bill::lang()->get('portal_sw_mode') }}</strong></a>
        </li>
        {{-- <li class="dropdown"><a href="#"><span><strong>{{ Bill::lang()->get('portal_sw_mode') }}</strong></span> <i
              class='bx bxs-chevron-down'></i></a>
          <ul>
            <li><a href="{{route('billing.portal')}}?mode=dark">{{ Bill::lang()->get('dark_mode') }}</a></li>
            <li><a href="{{route('billing.portal')}}?mode=light">{{ Bill::lang()->get('light_mode') }}</a></li>
          </ul>
        </li> --}}
        <li class="dropdown"><a href="#"><span><strong>{{ Bill::lang()->get(Bill::lang()->getActiveLang())
                }}</strong></span> <i class='bx bxs-chevron-down'></i></a>
          <ul>
            @foreach(Bill::lang()->getAll() as $key => $value)
            <li><a href="{{ route('billing.toggle.lang', ['lang' => $key]) }}">{{ Bill::lang()->get($key) }}</a></li>
            @endforeach
          </ul>
        </li>
        @isset(Auth::user()->email)
        <li><a class="getstarted scrollto" style="margin-left: 30px;" href="/account">{{ Auth::user()->name_first }} {{
            Auth::user()->name_last }}</a></li>
        @else
        <div style="display: flex;">
          <li><a class="getstarted scrollto" style="margin-left: 30px;" href="/auth/login">{{ Bill::lang()->get('login')
              }}</a></li>
          <li><a class="getstarted scrollto" href="/auth/register">{{ Bill::lang()->get('register') }}</a></li>
        </div>
        @endisset
      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav>
  </div>