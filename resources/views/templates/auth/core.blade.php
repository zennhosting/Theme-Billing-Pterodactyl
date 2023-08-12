@include('templates.Carbon.inc.LoginAnimation')

    <!-- HEADER -->
    <header>
      <!-- MENU -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="/themes/carbon/css/login/interchanging.css"/>
    <meta property="og:title" content="@if(isset($settings['meta_title'])){{ $settings['meta_title'] }}@else {{ config('app.name') }} @endif">
    <meta property="og:type" content="website">
    <meta property="og:url" content="/">
    <meta property="og:image" content="@if(isset($settings['meta_image'])){{ $settings['meta_image'] }}@else https://cdn.resourcemc.net/zAsa7/rIBOyeRU58.png/raw @endif">
    <meta property="og:description" content="@if(isset($settings['meta_desc'])){{ $settings['meta_desc'] }}@else Manage your server with an easy-to-use Panel @endif">
    <meta name="theme-color" content="@if(isset($settings['meta_color'])){{ $settings['meta_color'] }}@else #0e4688 @endif">
    <div id="{{ config('billing.author', 'n/a') }} {{ config('billing.name', 'unset') }} {{ config('billing.version', 'unset') }}" class="menu">

      <div class="logo" style="display: flex; align-items: center;">
        <img class="logo-padding" onclick="window.location.href='/'" src="@if(isset($settings['logo'])){{ $settings['logo'] }}@else /assets/svgs/pterodactyl.svg @endif" style="width: 64px; padding: 5px; cursor: pointer;">         
        <div class="logo"><a href="/">{{ config('app.name', 'Pterodactyl') }}</a></div>
      </div>
      
        <div class="btn" onclick="window.location.href='/portal'"><a target="_blank" style="color:white;">{!! Bill::lang()->get('portal') !!}</a></div>
      </div>
    </header>
    <!-- MAIN CONTENT -->

@extends('templates/wrapper', [
    'css' => ['body' => 'bg-neutral-900']
])

@section('container')
    <div id="app"></div>
@endsection
<script>

  /*===== Dynamically set icon =====*/
  document.head = document.head || document.getElementsByTagName('head')[0];

  function changeFavicon(src) {
  var link = document.createElement('link'),
    oldLink = document.getElementById('dynamic-favicon');
  link.id = 'dynamic-favicon';
  link.rel = 'shortcut icon';
  link.href = src;
  if (oldLink) {
  document.head.removeChild(oldLink);
  }
  document.head.appendChild(link);
  }

  changeFavicon('@if(isset($settings['favicon'])){{ $settings['favicon'] }}@else /favicons/favicon-32x32.png @endif');
    /*===== Dynamically set icon End =====*/
</script>

    <style>


:root {
      --header-height: 3rem;
      --nav-width: 75px;
      --first-color: @if(isset($settings['primary_color'])){{ $settings['primary_color'] }}@else #4723d9 @endif;
      --first-color-light: #ffffff;
      --main-background: #11111d;
      --second-background: #222235;
      --text-color: #ffffff;
      --active-text-color:  #ffffff;
      --white-hover: #f4f5f7;
      --sidebar-bg-color: #161624;
      --sidebar-icon-color: #ffffff;
      --white-color: #ffffff;
      --body-font: 'Nunito', sans-serif;
      --normal-font-size: 1rem;
      --z-fixed: 100;
  }


/* CSS RESET */
* {
   margin: 0;
   padding: 0;
   box-sizing: border-box;
   font-family: "Lato", sans-serif;
}
 a, .fFWwUW, .fFcOT, .emCXNB, .hmhrLa:not([type="checkbox"]):not([type="radio"]) + .input-help, .kpuLsi{
   text-decoration: none;
   color: var(--text-color) ;
}
.hmhrLa:not([type="checkbox"]):not([type="radio"]), .emoCVo {
  color: var(--active-text-color);
}
 header {
   position: relative;
}
 header header::after {
   content: "";
   width: 100%;
   height: 1px;
   position: absolute;
   bottom: 0;
   background-color: white;
   z-index: -1;
}
 header .menu {
   width: 70%;
   margin: 0 auto;
   height: 90px;
   display: flex;
   align-items: center;
   justify-content: space-between;
   position: relative;
   min-height: 70px;
}
 header .logo a {
   color: var(--text-color);
   font-size: 2rem;
   font-weight: 700;
}
 header nav a {
   color: ;
   font-size: 1rem;
   font-weight: 300;
   position: relative;
}
 header nav a:not(:last-child) {
   margin-right: 20px;
}
 header nav a::after {
   content: "";
   width: 0%;
   height: 2px;
   background-color: #0045ff;
   position: absolute;
   bottom: -3px;
   left: 0;
   transition: all 0.3s;
}
 header nav a:hover::after {
   width: 100%;
}
 .btn {
   padding: 15px 30px;
   background-color: var(--first-color);
   border-radius: 4px;
   color: #fff;
   font-weight: 700;
   text-transform: uppercase;
   font-size: 0.7rem;
   letter-spacing: 1px;
   cursor: pointer;
   box-shadow: var(--first-color) 0px 0 22px;
   transition: all 0.4s;
}
 .btn:hover {
   box-shadow: 0px 11px 26px 0px rgba(19, 36, 51, 0);
}
 main {
   display: grid;
   grid-template-columns: repeat(2, 1fr);
   height: calc(100vh - 90px);
   width: 70%;
   margin: 0 auto;
}
 main p {
   color: white;
   margin: 50px 0;
   line-height: 2;
}
 main .content {
   justify-self: flex-start;
   align-self: center;
}
 main .content h1 {
   font-size: 4rem;
   color: white;
}
 main .field-name {
   height: 3.5rem;
   margin-top: 2rem;
   display: flex;
   justify-content: space-between;
   align-items: center;
   border: 1px solid #dfe1e5;
   border-radius: 4px;
}
 main .field-name input {
   background: none;
   border: none;
   flex: 1;
   height: 100%;
   outline: none;
}
 main .field-name .btn {
   margin-right: 5px;
}
 main .field-name input[type="text"] {
   padding-left: 1.3rem;
   color: white;
}
 main .illustration {
   justify-self: flex-end;
   align-self: center;
}
 @media only screen and (max-width: 1250px) {
   main, header .menu {
     width: 90%;
  }
}
 @media only screen and (max-width: 980px) {
   main {
     grid-template-columns: none;
  }
   main .content {
     justify-self: center;
     align-self: center;
     text-align: center;
  }
   main .illustration {
     justify-self: center;
     align-self: flex-start;
     margin-top: 80px;
  }
   main .illustration img {
     width: 100%;
  }
}
 @media only screen and (max-width: 690px) {
   header .btn {
     display: none;
  }
   header .menu {
     height: 110px;
     flex-direction: column;
     justify-content: space-evenly;
  }
   main {
     margin-top: 50px;
  }
   main .content h1 {
     font-size: 3rem;
  }
   main .illustration {
     justify-self: center;
     align-self: flex-start;
     width: 70%;
     margin-top: 50px;
  }
}
 @media only screen and (max-width: 370px) {
   main .content h1 {
     font-size: 2.3rem;
  }
   main .field-name {
     display: inline;
     border: none;
  }
   main input[type="text"] {
     padding-left: 1.3rem;
     color: white;
     border: 1px solid #dfe1e5;
     border-radius: 4px;
     width: 100%;
     height: 3.5rem;
  }
   main .btn {
     margin-right: 0;
     margin-top: 20px;
  }
}

@if(!config('billing.socialite.discord'))
.discord {
  display: none !important;
}
@endif

@if(!config('billing.socialite.github'))
.github {
  display: none !important;
}
@endif

@if(!config('billing.socialite.google'))
.google {
  display: none !important;
}
@endif

@if(!Bill::allowed('socialite')) 
  .Socials {
    display: none !important;
  }
@endif

</style>


