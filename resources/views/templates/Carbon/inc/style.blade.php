<style>
  @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap");
  
  @if(Bill::getMode() == 'on')
  
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
  @else
  :root {
      --header-height: 3rem;
      --nav-width: 75px;
      --first-color: @if(isset($settings['primary_color'])){{ $settings['primary_color'] }}@else #4723d9 @endif;
      --first-color-light: #172b4d;
  
      --main-background: #f0f2fa;
      --second-background: #FFFF;
      --text-color: #172b4d;
      --active-text-color:#172b4d;
      --white-hover: #f4f5f7;
      --sidebar-bg-color: #FFFF;
      --sidebar-icon-color: white;
  
      --white-color: #ffffff;
      --body-font: 'Nunito', sans-serif;
      --normal-font-size: 1rem;
      --z-fixed: 100;
  }
  @endif
 
  .ebZQSG, .iTxXDX, .JZicT, .jleFWY {
    display: none !important;
  }

  .hlbvqz {
    margin-top: 80px !important;
    max-width: 100% !important;
  }

  .gZjctj {
    width: 100% !important
  }

  .dfrjYE {
    width: 100% !important;
  }
  
  .powerbuttons-div {
    background: transparent;
    box-shadow: none;
  }

  .xterm .xterm-viewport {
    width: 100% !important;
  }
  
  
  
  .chartjs-render-monitor {
    height: 265px !important;
    width: 100% !important;
  }

  
  </style>