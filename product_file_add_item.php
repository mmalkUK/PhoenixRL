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
    
    $post = filter_input_array(INPUT_POST);
    
    if(isset($post)){
        $ean1 = $post['ean1'];
        unset($post['ean1']);
        $ean2 = $post['ean2'];
        unset($post['ean2']);
        
        $post['accessId'] = UUID::generate_uuid();
        $post['creation_date'] = date('Y-m-d H:i:s');
        $post['created_by'] = $_SESSION['user']->id;
        $post['RRPdate'] = date('Y-m-d H:i:s');
        
        $newId = $database->insertRow('tblItems', $post);

        $ean_array['active'] = 1;
        $ean_array['creation_date'] = date('Y-m-d H:i:s');
        $ean_array['created_by'] = $_SESSION['user']->id;
        $ean_array['clientId'] = $post['clientId'];
        $ean_array['itemId'] = $newId;
        
        
        if($ean1 != ""){
            $ean_array['accessId'] = UUID::generate_uuid();
            $ean_array['barcode'] = $ean1;
            $database->insertRow('tblBarcodes', $ean_array);
        }
        
         if($ean2 != ""){
            $ean_array['accessId'] = UUID::generate_uuid();
            $ean_array['barcode'] = $ean2;
            $database->insertRow('tblBarcodes', $ean_array);
        }       
        
        mkdir($_SERVER['DOCUMENT_ROOT']. '/assets/pictures/' . $post['sku'] . '/');
        $total = count($_FILES['files']['name']);

        if($total > 0){
            // Loop through each file
            for($i=0; $i<$total; $i++) {
              //Get the temp file path
              $tmpFilePath = $_FILES['files']['tmp_name'][$i];
              //$extension = end(explode(".", $_FILES["files"]["name"][$i]));
              //Make sure we have a filepath
              if ($tmpFilePath != ""){
                //Setup our new file path
                $j = $i+1;
                $newFilePath = $_SERVER['DOCUMENT_ROOT']. '/assets/pictures/' . $post['sku'] . '/' . $j. '.jpg';
                //Upload the file into the temp dir
                move_uploaded_file($tmpFilePath, $newFilePath); 

              }
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
                        <form id="form1" role="form" enctype="multipart/form-data" method="POST" data-validate="parsley">
                            
                            <div class="form-group">
                              <label>SKU</label>
                              <input id="sku" type="text" class="form-control" data-required="true" data-minlength="6" placeholder="" name="sku">
                            </div>

                            <div class="form-group">
                              <label>EAN 1</label>
                              <input type="text" class="form-control" placeholder="" name="ean1">
                            </div>                            

                            <div class="form-group">
                              <label>EAN 2</label>
                              <input type="text" class="form-control" placeholder="" name="ean2">
                            </div>                            
                            
                            <div class="form-group">
                              <label>Title</label>
                              <input type="text" class="form-control" data-required="true" placeholder="" name="title">
                            </div>
                            
                            <div class="form-group">
                              <label>Subtitle</label>
                              <input type="text" class="form-control" placeholder="" name="subtitle">
                            </div>

                            <div class="form-group">
                              <label>Model</label>
                              <input type="text" class="form-control" placeholder="" name="model">
                            </div>

                            <div class="form-group">
                              <label>Brand</label>
                              <input type="text" class="form-control" placeholder="" name="brand">
                            </div>
                            
                            <div class="form-group">
                              <label>Client</label>
                                <select name="clientId" class="form-control m-b">
                                <?php 
                                    $clients = $database->selectArrayClass('tblClients', 'MClient');
                                    echo $db->error;
                                    foreach($clients as $row){
                                        echo '<option value="' . $row->id . '">' . $row->client_name . '</option>';
                                    }
                                ?>
                                </select>
                            </div>                            
                            
                            <div class="form-group">
                              <label>Supplier</label>
                                <select name="supplierId" class="form-control m-b">
                                <?php 
                                    $suppliers = $database->selectArrayClass('tblSuppliers', 'MSupplier');
                                    echo $db->error;
                                    foreach($suppliers as $row){
                                        echo '<option value="' . $row->id . '">' . $row->supplier_name . '</option>';
                                    }
                                ?>
                                </select>
                            </div>                            

                            <div class="form-group">
                              <label>Donation</label>
                                <select name="charityId" class="form-control m-b">
                                <?php 
                                    $charities = $database->selectArrayClass('tblCharity', 'MCharity');
                                    echo $db->error;
                                    foreach($charities as $row){
                                        echo '<option value="' . $row->id . '">' . $row->donation * 100 . '%</option>';
                                    }
                                ?>
                                </select>
                            </div>                             

                            <div class="form-group">
                              <label>Product Group</label>
                                <select name="productGroupId" class="form-control m-b">
                                <?php 
                                    $groups = $database->selectArrayClass('tblProductGroups', 'MProductGroup');
                                    echo $db->error;
                                    foreach($groups as $row){
                                        echo '<option value="' . $row->id . '">' . $row->name . '</option>';
                                    }
                                ?>
                                </select>
                            </div>                            
                            
                            
<!-- full description -->
                            
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Full Description</label>
                      <textarea name="fullDescription"></textarea>
                    </div>
                        
<!-- short description -->                            
       
                    <div class="form-group" >
                        
                      <label class="col-sm-2 control-label">Sort Description</label>
                      <textarea name="shortDescription"></textarea>
                    </div>
                    <input type="hidden" name="shortDescription" id="editorSubmit2">                            
                           
                            
                            <div class="form-group">
                              <label>RRP</label>
                              <input type="text" class="form-control"  	data-parsley-type="number" data-step="0.01" data-min="0.00" data-required="true" placeholder="" name="RRP">
                            </div>                            
                            
                             <div class="form-group">
                              <label>Weight</label>
                              <input type="text" class="form-control" data-parsley-type="number" data-step="0.001" data-min="0.00" placeholder="" name="weight">
                            </div>                            

                            <div class="form-group">
                              <label>Length</label>
                              <input type="text" class="form-control" data-parsley-type="number" data-step="0.001" data-min="0.00" placeholder="" name="length">
                            </div>                     
                            
                            <div class="form-group">
                              <label>Height</label>
                              <input type="text" class="form-control" data-parsley-type="number" data-step="0.001" data-min="0.00" placeholder="" name="height">
                            </div>                             
                            
                            <div class="form-group">
                              <label>Width</label>
                              <input type="text" class="form-control" data-parsley-type="number" data-step="0.001" data-min="0.00" placeholder="" name="width">
                            </div>               

                            <div class="form-group">
                              <label>Package</label>
                                <select name="packageId" class="form-control m-b">
                                <?php 
                                    $packages = $database->selectArrayClass('tblPackages', 'MPackage');
                                    echo $db->error;
                                    foreach($packages as $row){
                                        echo '<option value="' . $row->id . '">' . $row->size . '</option>';
                                    }
                                ?>
                                </select>
                            </div>                      

                            <div class="form-group">
                              <label>Postage</label>
                              <input type="text" class="form-control" data-parsley-type="number" data-step="0.01" data-min="0.00" placeholder="" name="postage">
                            </div>                    

                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Pictures</label>
                      <div class="col-sm-10">
                        <input type="file" class="filestyle" name="files[]" multiple data-icon="true" data-classButton="btn btn-default" data-classInput="form-control inline v-middle input-s">
                      </div>
                    </div>                 
                            
                    <input type="hidden" name="active" value="1">
                    
                    
                            <button type="submit" class="btn btn-sm btn-default">Submit</button>
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
<script type="text/javascript">
    $(document).ready(function() {
        $('#form1').submit(function(e) {
        var test;    
        $.ajax({
            url : "/ajax/check_if_exist.php",
            type : "GET",
            async: false,
            data : {'cmd' : 'sku', 'val_a' : $('#sku').val() },
            success : function (data){

                if(data == "0"){
                    test = true;
                }else{ 
                    alert('Sku already exist'); 
                    test = false; 
                }
          },
        });        
        
        return test;        
    });
});
</script>
<!-- tinymce -->
<script src="js/tinymce/tinymce.min.js"></script>  
<script>
tinymce.init({
  selector: 'textarea',
  height: 500,
  theme: 'modern',
  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
  ],
  toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons | codesample',
  image_advtab: true
 });
</script>
</body>
</html>