    const interval = setInterval(function() {
        
    var elconsole = document.getElementById("Console");
    var elplugins = document.getElementById("Plugins");
    //var elversion = document.getElementById("Version");
    var elfiles = document.getElementById("Files");
    var eldatabases = document.getElementById("Databases");
    var elschedules = document.getElementById("Schedules");
    var elusers = document.getElementById("Users");
    var elbackup = document.getElementById("Backups");
    var elnetowrk = document.getElementById("Network");
    var elstartup = document.getElementById("Startup");
    var elsettings = document.getElementById("Settings");
    var elactivity = document.getElementById("Activity");
    var elmanage = document.getElementById("manage");

    if(typeof(elconsole) != 'undefined' && elconsole != null){
        
        document.getElementById("sbConsole").style.display = "";

    } 
    else{

        document.getElementById("sbConsole").style.display = "none";
    }
    if(typeof(elfiles) != 'undefined' && elfiles != null){
        
        document.getElementById("sbFiles").style.display = "";

    } 
    else{

        document.getElementById("sbFiles").style.display = "none";
    }
    if(typeof(eldatabases) != 'undefined' && eldatabases != null){
        
        document.getElementById("sbDatabases").style.display = "";

    } 
    else{

        document.getElementById("sbDatabases").style.display = "none";
    }
    if(typeof(elschedules) != 'undefined' && elschedules != null){
        
        document.getElementById("sbSchedules").style.display = "";

    } 
    else{

        document.getElementById("sbSchedules").style.display = "none";
    }
    if(typeof(elusers) != 'undefined' && elusers != null){
        
        document.getElementById("sbUsers").style.display = "";

    } 
    else{

        document.getElementById("sbUsers").style.display = "none";
    }
    if(typeof(elbackup) != 'undefined' && elbackup != null){
        
        document.getElementById("sbBackups").style.display = "";

    } 
    else{

        document.getElementById("sbBackups").style.display = "none";
    }
    if(typeof(elnetowrk) != 'undefined' && elnetowrk != null){
        
        document.getElementById("sbNetwork").style.display = "";

    } 
    else{

        document.getElementById("sbNetwork").style.display = "none";
    }
    if(typeof(elstartup) != 'undefined' && elstartup != null){
        
        document.getElementById("sbStartup").style.display = "";

    } 
    else{

        document.getElementById("sbStartup").style.display = "none";
    }
    if(typeof(elsettings) != 'undefined' && elsettings != null){
        
        document.getElementById("sbSettings").style.display = "";

    } 
    else{

        document.getElementById("sbSettings").style.display = "none";
    }
    if(typeof(elactivity) != 'undefined' && elactivity != null){
        
        document.getElementById("sbActivity").style.display = "";

    } 
    else{

        document.getElementById("sbActivity").style.display = "none";
    }
    if(typeof(elplugins) != 'undefined' && elplugins != null){
        
        document.getElementById("sbPlugins").style.display = "";

    } 
    else{

        document.getElementById("sbPlugins").style.display = "none";
    }
    //if(typeof(elversion) != 'undefined' && elversion != null){
        
    //  document.getElementById("sbVersion").style.display = "";

    //} 
    //else{

     //   document.getElementById("sbVersion").style.display = "";
    //}
    if(typeof(elmanage) != 'undefined' && elmanage != null){
          
          document.getElementById("sbManage").style.display = "";

    } 
    else{

        document.getElementById("sbManage").style.display = "none";
    }

  }, 500);





function myFunction() {
    var x = document.getElementById("serverid").textContent;
    document.getElementById("demo").innerHTML = x;  
  }
  
      function openConsole() {
          var button = document.getElementById("Console");
          button.click('Console')
      }
      function openFiles() {
          var button = document.getElementById("Files");
          button.click('Files')
      }
      function openDatabases() {
          var button = document.getElementById("Databases");
          button.click('Databases')
      }
      function openSchedules() {
          var button = document.getElementById("Schedules");
          button.click('Schedules')
      }
      function openUsers() {
          var button = document.getElementById("Users");
          button.click('Users')
      }
      function openBackups() {
          var button = document.getElementById("Backups");
          button.click('Backups')
      }
      function openNetwork() {
          var button = document.getElementById("Network");
          button.click('Network')
      }
      function openStartup() {
          var button = document.getElementById("Startup");
          button.click('Startup')
      }
      function openSettings() {
          var button = document.getElementById("Settings");
          button.click('Settings')
      }
      function openActivity() {
        var button = document.getElementById("Activity");
        button.click('Activity')
    }
      function Search() {
        var button = document.getElementById("search");
        button.click('search')
    }
    function openManage() {
        var button = document.getElementById("manage");
        button.click('manage')
    }
    
    function openPlugins() {
        var button = document.getElementById("Plugins");
        button.click('Plugins');
    }

    //function openVersion() {
      //var button = document.getElementById("Version");
      //button.click('Version');
    //}
  
    function logout() {
        var button = document.getElementById("logout");
        button.click('logout')
    }

    function closeAlert() {
        var button = document.getElementById("alert").style.display = "none";
    }
