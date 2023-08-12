<script>
  function upURL(pl_id, pl_name) {
    fetch('{{$app_url}}' + '/server/' + '{{$server}}' + '/plugins/upload/' + pl_id + '/' + pl_name).then(function(response) {
      var btn = document.getElementById('btn-' + pl_id);
      var btnm = document.getElementById('btnm-' + pl_id);
      btn.innerHTML = 'Installed';
      btnm.innerHTML = 'Installed';
      btn.disabled = true;
      btnm.disabled = true;
    });
  }

  function sendFile() {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', '{{$app_url}}' + '/server/' + '{{$server}}' + '/pluginsurl/get');
    xhr.send();
    xhr.onload = function() {
      let response = xhr.response;

      var formElement = document.querySelector("form");
      var request = new XMLHttpRequest();
      request.open("POST", response);
      request.send(new FormData(formElement));
    };

    setTimeout(function() {
      let d = document.getElementById('modal-close');
      d.click();
    }, 1200);

  }

  function getPlVersions(pl_id, pl_name) {

    fetch('https://api.spiget.org/v2/resources/' + pl_id + '/versions')
      .then(function(response) {;
        response.forEach((version) => {
          console.log(version);
        });
      })
      .then(function(Response) {
        // do something with jsonResponse
      });
  }

</script>

<style>
  .drop-area {
    height: 200px;
    width: 100%;
    border: dashed;
    padding: 82px;
    padding-left: 25%;
  }
  .text-color {
    color: var(--text-color) !important;
  }
  .active {
    color:  !important;
  }
  .icon-title-div {
    display: flex;
    justify-content: space-between;
  }
</style>