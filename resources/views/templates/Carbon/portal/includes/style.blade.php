<style>
  body {
    background: var(--background) !important;
  }
  .bg-1 {
    background-color: var(--background-1) !important;
  }
  .bg-2 {
    background-color: var(--background-2) !important;
  }
  .bg-3 {
    background-color: var(--background-3) !important;
  }
}
  
</style>

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