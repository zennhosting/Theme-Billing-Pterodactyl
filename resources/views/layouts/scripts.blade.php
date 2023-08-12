{{-- Just here as a binder for dynamically rendered content. --}}
<script>
function pl_scheduler(){
    fetch('{{config('app.url')}}' + '/pl-scheduler').then(function(response){
        // console.log('scheduler');
    });
}
pl_scheduler();

function getServer(url){
  if(url[1] == 'server'){
    return url[2];
  } else {
    return false
  }
}

function addPlPage(server, hidden= false){
    var file_page = document.querySelector('[href="/server/'+server+'/files"]');
    //var version_page = document.querySelector('[href="/server/'+server+'/version"]');
    //version_page.setAttribute('style', 'display: none;');
    if(file_page != null){
        var pl_elem = file_page.cloneNode(true);
        pl_elem.innerHTML = 'Plugins';
        pl_elem.setAttribute('href', '/server/'+server+'/plugins');
        pl_elem.setAttribute('class', 'plugins-module');
        if(hidden){
          pl_elem.setAttribute('style', 'display: none;');
        }
        file_page.insertAdjacentElement('afterend', pl_elem);
    }
}

function pluginsModule(){
    var timer = 1000;
    var server = getServer(window.location.pathname.split('/'));
    if(server != false){
       var version_page = document.querySelector('[id="sbVersion"]');
       
       if(version_page != null){
        if(version_page.getAttribute('visible') != 'ok'){
          fetch('{{ route('plugins.isminecraft') }}/' + server)
            .then((response) => {
              return response.json();
            })
            .then((data) => {
              if(data.resp){
                //addPlPage(server);
                version_page.setAttribute('visible', 'ok');
                version_page.setAttribute('style', 'display: 1111;');
                version_page.setAttribute('href', '/server/'+server+'/version');
                //console.log('added');
              } else {
                //addPlPage(server, true);
                //console.log('hidden');
                version_page.setAttribute('visible', 'none');
                version_page.setAttribute('style', 'display: none;');
              }
            });
        }
       }
    }
    setTimeout(pluginsModule, timer);
}
pluginsModule();
</script>