<?php 
if(Bill::getMode() == 'on') { ?>
<style>
  :root {
    --background: #11111d;
    --background-2: #222235;
    --background-3: #161624;
    --text-color: #b9b9b9;
    --text-color-2: #eff0f6;
    --sb-background: #161624;
    --primary-color: @if(isset($settings['primary_color'])){{ $settings['primary_color'] }}@else #4723d9 @endif;
  }
</style>
  
  <?php }
  if(Bill::getMode() == 'off') { ?>

<style>
  :root {
    --background: #fdfefe;
    --background-2: #ffffff;
    --background-3: #ffffff;
    --text-color: #444444;
    --text-color-2: #124265;
    --sb-background: #161624;
    --primary-color: @if(isset($settings['primary_color'])){{ $settings['primary_color'] }}@else #4723d9 @endif;
  }
  .l-navbar {
    background: var(--primary-color) !important;
  }
  .nav_link {
    color: white !important;
  }
  #hero:before {
    background: #ffffff60;
  }
</style>

  <?php }
   
?>