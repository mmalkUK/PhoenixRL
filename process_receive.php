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

    $post = filter_input_array(INPUT_POST);

    if(MConfig::$debug_mode){
        echo ('<br>Post:<br>');
        print_r($post);
    }
    
    if(isset($post)){
        
        $item = $database->selectSingleClass('tblItems', "MItem", array('sku' => $post['skuId']));
        $post['skuId'] = $item->id;
        $post['created_by'] = $_SESSION['user']->id;
        $qty = $post['qty'];
        $post['qty'] = 1;
        
        for($i = 1; $i <= $qty; $i++){        

//            if(MConfig::$debug_mode){
//                echo ("For saving line $i:<br>");
//                print_r($post);
//                echo ("<br>");
//            }
            
            $post['accessId'] = UUID::generate_uuid();
            $post['creation_date'] = date('Y-m-d H:i:s');    
            $database->insertRow('tblContainerElements', $post);

            if(MConfig::$debug_mode){
                echo ("<br>Database error:<br>");
                echo $database->error;
            }
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
                      <h3 class="m-b-xs text-black">Products - Add Item</h3>
                    </div>
                  </section>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="panel b-a">
                        <div class="panel-body">
                            
                            
                  <form id="wizardform" method="POST">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <ul class="nav nav-tabs font-bold">
                          <li><a href="#step1" data-toggle="tab">Choose Item</a></li>
                          <li><a href="#step2" data-toggle="tab">Choose pallet</a></li>
                          <li><a href="#step3" data-toggle="tab">Confirm</a></li>
                        </ul>
                      </div>
                      <div class="panel-body">
                        <div class="line line-lg"></div>
                        <h4>Progress</h4>
                        <p id="wizard_qty"></p>
                        <p id="wizard_comment"></p>
                        <div class="progress progress-xs m-t-md">
                          <div class="progress-bar bg-success"></div>
                        </div>
                        <div class="tab-content">
                          <div class="tab-pane" id="step1">
                            <input id="error" value="0" type="hidden">
                            <p>SKU</p>
                            <input id="sku" name="skuId" type="text" class="form-control" data-trigger="change" data-required="true" minlength="1" autofocus> 
                            <p>Qty</p>
                            <input id="qty" name="qty" type="number" value="1" min="1" class="form-control" data-trigger="change" data-required="true"  minlength="1"> 
                            <p>Grade</p>
                            <select name="gradeId" class="form-control m-b">
                            <?php 
                                $grades = $database->selectArrayClass('tblGrades', 'MGrade');
                                echo $db->error;
                                foreach($grades as $row){
                                    echo '<option value="' . $row->id . '">' . $row->grade . '</option>';
                                }
                            ?>
                            </select>

                          </div>
                          <div class="tab-pane" id="step2">
                            <p>Container ID</p>
                            <input id="container" name="containerId" type="text" class="form-control" data-trigger="change" data-required="true" minlength="1">
                          </div>
                          <div class="tab-pane" id="step3">
                              <button type="submit" class="btn btn-sm btn-success">Confirm</button>
                          </div>
                          <ul class="pager wizard m-b-sm">
                            <li class="previous first" style="display:none;"><a href="#">First</a></li>
                            <li class="previous"><a href="#">Previous</a></li>
                            <li class="next last" style="display:none;"><a href="#">Last</a></li>
                            <li class="next"><a href="#">Next</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
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
  
  <!-- parsley -->
<script src="js/parsley/parsley.min.js"></script>
<script src="js/parsley/parsley.extend.js"></script>  

<!-- wizard -->
<script src="js/wizard/jquery.bootstrap.wizard.js"></script>
<script src="js/wizard/receive.js"></script>

</body>
</html>