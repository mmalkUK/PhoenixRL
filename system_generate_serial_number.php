<?php 

    date_default_timezone_set('UTC');
    if(!function_exists("__autoload")) {
        function __autoload($class_name) {
            include_once $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class_name . '.php';
        }
    } 

    include $_SERVER['DOCUMENT_ROOT'] . '/elements/php_session_check.php';

    
    $cmd = filter_input(INPUT_GET, 'cmd');
    
    
    $database = new MDatabase(MConfig::$db_address, MConfig::$db_username, MConfig::$db_password, MConfig::$db_database, null, MConfig::$db_type);

    if(isset($cmd)){
        if($cmd == 'logout'){
            if(isset($_SESSION['user'])){
                
                $_SESSION['user']->logout($database);
            }
            unset($_SESSION['user']);
            session_destroy();
            header('Location: index');
            die();
        }
    }    
    
?>
<!DOCTYPE html>
<html lang="en" class="app">
<?php include 'elements/html_head.php'; ?>
<body class="" >
  <section class="vbox">
 <?php include 'elements/html_header.php'; ?>
    <section>
      <section class="hbox stretch">
<?php include 'elements/html_navigation.php'?>
        <section id="content">
          <section class="hbox stretch">
            <section>
              <section class="vbox">
                <section class="scrollable padder">              
                  <section class="row m-b-md">
                    <div class="col-sm-6">
                      <h3 class="m-b-xs text-black">System Info</h3>
                    </div>
                  </section>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="doc-buttons">
                                <button type="button" onclick="printZPL()" class="btn btn-success">Reprint</button>
                            </div>
                        </div>
                    </div>                     
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="panel b-a">
                          Serial Number <?php $serial = UUID::generate_uuid(4); 
                          $serial_explode = explode("-", $serial);
                          echo $serial_explode[4];
                          ?>
                          
                      </div>
                    </div>
                  </div>           
                  
                  
                </section>
              </section>
            </section>
            <!-- side content -->
<?php include 'elements/html_side_content.php'; ?>
            <!-- / side content -->
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
        </section>
      </section>
    </section>
  </section>
<?php include 'elements/html_js_include.php'; ?>
    <!-- qz -->
<script type="text/javascript" src="js/zq/dependencies/rsvp-3.1.0.min.js"></script>
<script type="text/javascript" src="js/zq/dependencies/sha-256.min.js"></script>
<script type="text/javascript" src="js/zq/qz-tray.js"></script>

<script>

/// Authentication setup ///
qz.security.setCertificatePromise(function(resolve, reject) {
    //Preferred method - from server
    $.ajax("js/zq/cert2/server.crt").then(resolve, reject);    
});

//
qz.security.setSignaturePromise(function(toSign) {
   return function(resolve, reject) {
      $.ajax("js/zq/cert2/sign-message.php?request=" + toSign).then(resolve, reject);
      
   };
});    

   
function printZPL() {
    qz.websocket.connect().then(function() { 
      return qz.printers.find("ZDesigner GC420d")               // Pass the printer name into the next Promise
    }).then(function(printer) {
      var config = qz.configs.create(printer);       // Create a default config for the found printer
       var data = [
          '^XA\n',

          '^FO50,100^BY5\n',
          '^BCN,300,Y,N,N\n',
          '^FD<?php echo $serial_explode[4]; ?>^FS\n',
          '^FS\n',
          '^XZ\n'
       ];
      return qz.print(config, data);
    }).catch(function(e) { console.error(e); });
}
</script>    
</body>
</html>