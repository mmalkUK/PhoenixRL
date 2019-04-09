<?php 

    date_default_timezone_set('UTC');
    if(!function_exists("__autoload")) {
        function __autoload($class_name) {
            include_once $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class_name . '.php';
        }
    } 

    include $_SERVER['DOCUMENT_ROOT'] . '/elements/php_session_check.php';
    
    $cmd = filter_input(INPUT_GET, 'cmd');
    $val = filter_input_array(INPUT_GET);
    
    if(MConfig::$debug_mode){
        echo 'cmd: ' . $cmd . '<br>';
        echo 'val: ';
        print_r($val);
        echo '<br>';
    }
    
    $database = new MDatabase(MConfig::$db_address, MConfig::$db_username, MConfig::$db_password, MConfig::$db_database, null, MConfig::$db_type);  
    $query = 'SELECT tblContainerElements.skuId AS ID, tblItems.sku AS SKU, tblItems.title AS Title, sum(tblContainerElements.qty) AS QTY FROM tblContainerElements'
            . ' INNER JOIN tblItems on tblContainerElements.skuId = tblItems.id WHERE tblContainerElements.active = 1 AND tblContainerElements.containerId = ' . $val['val_a']
            . ' GROUP BY tblContainerElements.skuId';
    $holding = $database->runQuery($query);
    
    if(MConfig::$debug_mode){
        echo 'DB Error: ' . $database->error . '<br>';
        echo 'Query: ' . $query . '<br>';
        echo 'Holding: ';
        print_r($holding);
        echo '<br>';
        
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
                      <h3 class="m-b-xs text-black">Stock holding - container: <?php echo $val['val_a']; ?> - <?php echo $val['val_b']; ?></h3>
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

                <div class="table-responsive">
                  <table id="dtTable" class="table table-striped m-b-none" data-ride="datatables">
                    <thead>
                        <tr>
                            <th>Container</th>
                            <th>SKU</th>
                            <th>Title</th>
                            <th>Qty</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach($holding as $row){
                            echo '<tr>';
                            echo '<td>' . $row['ID'] . '</td>';
                            echo '<td>' . $row['SKU'] . '</td>';
                            echo '<td>' . $row['Title'] . '</td>';
                            echo '<td>' . $row['QTY'] . '</td>';
                            echo '<td></td>';
                            echo '</tr>';
                        }
                    ?>
                    </tbody>
 
 
                  </table></div>
                        
                        
                        
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
<!-- dataTables for users -->
<script src="js/datatables/jquery.dataTables.min.js"></script>
<!-- List generation -->
<script>
    
$(document).ready(function() {
    var table = $('#dtTable').DataTable( {
        //"processing": true,
        //"serverSide": true,
        //"bProcessing": true,
        "sPaginationType": "full_numbers",
        //"sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        //"ajax": "js/datatables/scripts/product_file_list.php",
        "columnDefs": [ {
            "targets": -1,
            "data": null,
            "defaultContent": "<button>Details</button>"
        },{
            "targets": [0],
            "visible": true,
            "searchable": true
                
        } ]
    } );





    $('#dtTable tbody').on( 'click', 'button', function () {
        var data = table.row( $(this).parents('tr') ).data();
        window.location.href = ("stock_holding_details?cmd=details&val_a="+ data[0]);
    } );

} );

</script>

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
          '^FD<?php echo $val['val_a']; ?>^FS\n',
          '^FS\n',
          '^XZ\n'
       ];
      return qz.print(config, data);
    }).catch(function(e) { console.error(e); });
}
</script>    
</body>
</html>