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

    $item = $database->selectSingleClass('tblItems', 'MItem', array('accessId' => $val_a));
    
    $post = filter_input_array(INPUT_POST);
    
    if(isset($post)){
      
        foreach($post as $key => $value){
            if($value == $item->$key){
                unset($post[$key]);
            }
        }
        
        if(MConfig::$debug_mode){
            echo 'POST: ';
            print_r($post);
            echo '<br>';
        }
        
        if(isset($post['RRP'])){
            $post['RRPdate'] = date('Y-m-d H:i:s');
        }
        
        if(count($post) > 0){
            $database->update('tblItems', $post, array('id' => $item->id));
        }
        

        $item = $database->selectSingleClass('tblItems', 'MItem', array('accessId' => $val_a));
        
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
                      <h3 class="m-b-xs text-black">Product Details</h3>
                    </div>
                  </section>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="product_file_edit_ean?cmd=edit&val_a=<?php echo $item->accessId; ?>" class="btn btn-primary">Edit EAN</a>
                            <a href="product_file_edit_pictures?cmd=edit&val_a=<?php echo $item->accessId; ?>" class="btn btn-primary">Edit Pictures</a>
                        </div>
                    </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="panel b-a">
                        <div class="panel-body">  
                            <form method="POST">
                            <div class="form-group">
                              <label>ID</label>
                              <input name="id" id="id" type="text" class="form-control" disabled="" value="<?php echo $item->id; ?>">
                            </div>

                            <div class="form-group">
                              <label>Active</label>
                              <input id="sku" type="text" class="form-control" disabled="" value="<?php if($item->active == "1"){echo 'Yes';}else{echo "No";} ?>">
                            </div> 
                            
                            
                            <div class="form-group">
                              <label>SKU</label>
                              <input id="sku" type="text" class="form-control" disabled="" value="<?php echo $item->sku; ?>">
                            </div>

                            <div class="form-group">
                              <label>EAN 1</label>
                              <?php
                                $eans = $database->selectArrayClass('tblBarcodes', 'MBarcode', array('itemId' => $item->id));
                                $count = count($eans);
                              ?>
                              <input name="ean1" disabled="" type="text" class="form-control" placeholder="" value="<?php if($count >=1) echo $eans[0]->barcode; ?>">
                            </div>                            

                            <div class="form-group">
                              <label>EAN 2</label>
                              <input name="ean2" disabled="" type="text" class="form-control" placeholder="" value="<?php if($count >=2) echo $eans[1]->barcode; ?>">
                            </div>                            
                            
                            <div class="form-group">
                              <label>Title</label>
                              <input name="title" type="text" class="form-control" value="<?php echo $item->title; ?>">
                            </div>
                            
                            <div class="form-group">
                              <label>Subtitle</label>
                              <input name="subtitle" type="text" class="form-control" value="<?php echo $item->subtitle; ?>">
                            </div>

                            <div class="form-group">
                              <label>Model</label>
                              <input name="model" type="text" class="form-control" placeholder="" value="<?php echo $item->model; ?>">
                            </div>

                            <div class="form-group">
                              <label>Brand</label>
                              <input name="brand" type="text" class="form-control" placeholder="" value="<?php echo $item->brand; ?>">
                            </div>
                            
                            <div class="form-group">
                              <label>Client</label>
                                <select name="clientId" class="form-control m-b">
                                <?php 
                                    $clients = $database->selectArrayClass('tblClients', 'MClient');
                                    echo $db->error;
                                    foreach($clients as $row){
                                        echo '<option';
                                        if($row->id == $item->clientId) echo ' selected';
                                        echo ' value="' . $row->id . '">' . $row->client_name . '</option>';
                                    }
                                ?>
                                </select>
                            </div>                            
                            
                            <div class="form-group">
                              <label>Supplier</label>
                                <select name="supplierId" class="form-control m-b">
                                <?php 
                                    $suppliers = $database->selectArrayClass('tblSuppliers', 'MSupplier');
                                    foreach($suppliers as $row){
                                        echo '<option';
                                        if($row->id == $item->supplierId) echo ' selected';
                                        echo ' value="' . $row->id . '">' . $row->supplier_name . '</option>';
                                    }
                                ?>
                                </select>
                            </div>                            

                            <div class="form-group">
                              <label>Donation</label>
                                <select name="charityId" class="form-control m-b">
                                <?php 
                                    $charities = $database->selectArrayClass('tblCharity', 'MCharity');
                                    foreach($charities as $row){
                                        echo '<option';
                                        if($row->id == $item->charityId) echo ' selected';
                                        echo ' value="' . $row->id . '">' . $row->donation * 100 . '%</option>';
                                    }
                                ?>
                                </select>

                            </div>                             

                            <div class="form-group">
                              <label>Product Group</label>
                                <select name="productGroupId" class="form-control m-b">
                                <?php 
                                    $groups = $database->selectArrayClass('tblProductGroups', 'MProductGroup');
                                    foreach($groups as $row){
                                        echo '<option';
                                        if($row->id == $item->productGroupId) echo ' selected';
                                        echo ' value="' . $row->id . '">' . $row->name . '</option>';
                                    }
                                ?>
                                </select>

                            </div>                            
                            
                            
<!-- full description -->
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Full Description</label>
                      <textarea name="fullDescription"><?php echo $item->fullDescription ;?></textarea>                            
                    </div>
                    <div class="row"></div>     
<!-- short description -->                            
       
                    <div class="form-group" >
                      <label class="col-sm-2 control-label">Short Description</label>                        
                      <textarea name="shortDescription"><?php echo $item->shortDescription . " " ;?></textarea>                            
                    </div>
                    <div class="row"></div>
                            
                            <div class="form-group">
                              <label>RRP</label>
                              <input name="RRP" type="text" class="form-control" placeholder="" value="<?php echo $item->RRP; ?>">
                            </div>                            
                            
                             <div class="form-group">
                              <label>Weight</label>
                              <input name="weight" type="text" class="form-control" placeholder="" value="<?php echo $item->weight; ?>">
                            </div>                            

                            <div class="form-group">
                              <label>Length</label>
                              <input name="length" type="text" class="form-control" placeholder="" value="<?php echo $item->length; ?>">
                            </div>                     
                            
                            <div class="form-group">
                              <label>Height</label>
                              <input name="height" type="text" class="form-control" placeholder="" value="<?php echo $item->height; ?>">
                            </div>                             
                            
                            <div class="form-group">
                              <label>Width</label>
                              <input name="width" type="text" class="form-control" placeholder="" value="<?php echo $item->width; ?>">
                            </div>               

                            <div class="form-group">
                              <label>Postage</label>
                              <input name="postage" type="text" class="form-control" placeholder="" value="<?php echo $item->postage; ?>">
                            </div>
                    
                            <div class="form-group">
                                <label>Package</label>
                                <select name="packageId" class="form-control m-b">
                                <?php 
                                    $packages = $database->selectArrayClass('tblPackages', 'MPackage');
                                    foreach($packages as $row){
                                        echo '<option';
                                        if($row->id == $item->packageId) echo ' selected';
                                        echo ' value="' . $row->id . '">' . $row->size . '</option>';
                                    }
                                ?>
                                </select>
                            </div>                      
                    
                    <div class="form-group">
                        <?php

                            $pictures = array_diff(scandir($_SERVER['DOCUMENT_ROOT']. '/assets/pictures/' . $item->sku . '/'), array('..', '.'));
                            foreach($pictures as $row){
                        ?>
                            <a href="<?php echo '/assets/pictures/' . $item->sku . '/' . $row; ?>" class="avatar thumb-lg">
                              <img src="<?php echo '/assets/pictures/' . $item->sku . '/' . $row; ?>" alt="...">
                              <i class="on b-white"></i>
                            </a>                        
                        
                        <?php        
                            }
                        ?>
                        
                    </div>                 
                            
                    <button type="submit" class="btn btn-danger">Save</button>
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