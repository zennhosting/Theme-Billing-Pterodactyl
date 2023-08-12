<script>

  document.addEventListener("DOMContentLoaded", function(event) {

  const showNavbar = (toggleId, navId, bodyId, headerId) =>{
  const toggle = document.getElementById(toggleId),
  nav = document.getElementById(navId),
  bodypd = document.getElementById(bodyId),
  headerpd = document.getElementById(headerId)
  
  // Validate that all variables exist
  if(toggle && nav && bodypd && headerpd){
  toggle.addEventListener('click', ()=>{
  // show navbar
  nav.classList.toggle('nav_show')
  // change icon
  toggle.classList.toggle('bx-x')
  // add padding to body
  bodypd.classList.toggle('body-pd')
  // add padding to header
  headerpd.classList.toggle('body-pd')
  })
  }
  }

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


  showNavbar('header-toggle','nav-bar','body-pd','header')
  
  /*===== LINK ACTIVE =====*/
  const linkColor = document.querySelectorAll('.nav_link')
  
  function colorLink(){
  if(linkColor){
  linkColor.forEach(l=> l.classList.remove('sb-active'))
  this.classList.add('sb-active')
  }
  }
  linkColor.forEach(l=> l.addEventListener('click', colorLink))
  
  // Your code to run since DOM is loaded and ready
  var togglebutton = document.getElementById("header-toggle");
  togglebutton.click('header-toggle');
  




  function getValueAtIndex(index){
    var str = window.location.href; 
    return str.split("/")[index];
  }

  function pluginPage(serversList){

    if(document.getElementById("serverid")){
      var serverID = document.getElementById("serverid").innerHTML;
      serverID = serverID.trim();

      if (serversList.hasOwnProperty(serverID)) {
          // var pluginPageStatus = serversList[serverID].plugins
          // console.log(pluginPageStatus);
          document.getElementById("sbPlugins").hidden = false;
      } else {
        // console.log(serversList);
        document.getElementById("sbPlugins").hidden = true;
      }

    }
  }

  setInterval(() => {
    if (getValueAtIndex(3) == 'server') {
      if (getValueAtIndex(4) && getValueAtIndex(5) != 'plugins') {
        var servers = '<?php echo json_encode(Bill::users()->getUserServersData(Auth::user()->id)); ?>';
        var serversList = JSON.parse(servers);
        pluginPage(serversList);
      }
    }
    
  }, 350);
  });
  
</script>

<script src='https://cdn.jsdelivr.net/npm/@widgetbot/crate@3' async defer>
  if ('{{ Bill::settings()->getParam('ds_widget_status') }}' == 'true') {
    new Crate({
      server: '{{ Bill::settings()->getParam('ds_widget_server') }}',
      channel: '{{ Bill::settings()->getParam('ds_widget_channel') }}'
    })
  }
</script>




