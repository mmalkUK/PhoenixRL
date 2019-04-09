<?php 

    date_default_timezone_set('UTC');
    if(!function_exists("__autoload")) {
        function __autoload($class_name) {
            include_once $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class_name . '.php';
        }
    } 

    include $_SERVER['DOCUMENT_ROOT'] . '/elements/php_session_check.php';
    
    $cmd = filter_input(INPUT_GET, 'cmd');
    $val_a = filter_input(INPUT_GET, 'val_a');
    $database = new MDatabase(MConfig::$db_address, MConfig::$db_username, MConfig::$db_password, MConfig::$db_database, null, MConfig::$db_type);
   
    $post = filter_input_array(INPUT_POST);
    
    $newId = -1;
    
    if(isset($post)){
        $supplier = $database->selectSingleClass('tblSuppliers', 'MSupplier', array('id' => $post['supplierId']));
        $post['accessId'] = UUID::generate_uuid();
        $post['active'] = 1;
        $post['creation_date'] = date('Y-m-d H:i:s');
        $post['created_by'] = $_SESSION['user']->id;
        $post['containerStatusId'] = 1;
        $post['allowMix'] = $supplier->allowMix;
        
        $newId = $database->insertRow('tblContainers', $post);
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
                    <div class="col-sm-12">
                      <h3 class="m-b-xs text-black">Container - Add</h3>
                    </div>
                  </section>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="doc-buttons">
                                <input type="button" onclick="printZPL()" value="Print"></input>
                                <a href="" class="btn btn-s-md btn-info">Generate eBay Layout</a>
                            </div>
                        </div>
                    </div>                    
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="panel b-a">
                        <div class="panel-body">
                            <form id="form1" role="form" method="POST">
                                <div class="form-group">
                                  <label>Type</label>
                                    <select name="containerTypeId" class="form-control m-b">
                                    <?php 
                                        $types = $database->selectArrayClass('tblContainerTypes', 'MContainerType');
                                        foreach($types as $row){
                                            echo '<option value="' . $row->id . '">' . $row->type . '</option>';
                                        }
                                    ?>
                                    </select>
                                </div>  
                                <div class="form-group">
                                  <label>Type</label>
                                    <select name="supplierId" class="form-control m-b">
                                    <?php 
                                        $suppliers = $database->selectArrayClass('tblSuppliers', 'MSupplier');
                                        foreach($suppliers as $row){
                                            echo '<option value="' . $row->id . '">' . $row->supplier_name . '</option>';
                                        }
                                    ?>
                                    </select>
                                </div>  
                                
                                <button type="submit" class="btn btn-sm btn-default">Create</button>
                            </form>
                        </div>
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
    
    $(document).ready(function() {


    

function printZPL() {

}

});
</script>
<script>
<?php
    if($newId > 0){
?>
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

qz.websocket.connect().then(function() { 
  return qz.printers.find("ZDesigner GC420d")               // Pass the printer name into the next Promise
}).then(function(printer) {
  var config = qz.configs.create(printer);       // Create a default config for the found printer
   var data = [
      '^XA\n',
      
      '^FO50,100^BY5\n',
      '^BCN,300,Y,N,N\n',
      '^FD<?php echo $newId;?>^FS\n',
      '^FS\n',
      '^XZ\n'
   ];
  return qz.print(config, data);
}).catch(function(e) { console.error(e); });


<?php
    }
?>
</script>
</body>
</html>