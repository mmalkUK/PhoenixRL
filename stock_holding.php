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
    $query = 'SELECT tblContainerElements.skuId AS ID, tblItems.sku AS SKU, tblItems.title AS Title, sum(tblContainerElements.qty) AS QTY FROM tblContainerElements'
            . ' INNER JOIN tblItems on tblContainerElements.skuId = tblItems.id WHERE tblContainerElements.active = 1 GROUP BY tblContainerElements.skuId';
    $holding = $database->runQuery($query);
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
                      <h3 class="m-b-xs text-black">Stock holding</h3>
                    </div>
                  </section>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="panel b-a">

                <div class="table-responsive">
                  <table id="dtTable" class="table table-striped m-b-none" data-ride="datatables">
                    <thead>
                        <tr>
                            <th>Id</th>
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
            "visible": false,
            "searchable": false
                
        } ]
    } );





    $('#dtTable tbody').on( 'click', 'button', function () {
        var data = table.row( $(this).parents('tr') ).data();
        window.location.href = ("stock_holding_details?cmd=details&val_a="+ data[0]);
    } );

} );

</script>
    
    
</body>
</html>