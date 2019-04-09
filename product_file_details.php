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
                            <div class="doc-buttons">
                                <a href="product_file_edit?cmd=edit&val_a=<?php echo $item->accessId; ?>" class="btn btn-warning">Edit</a>
                                
                                <a href="product_file_generate_ebay_layout?cmd=ebay&val_a=<?php echo $item->accessId; ?>" class="btn btn-s-md btn-info">Generate eBay Layout</a>
                            </div>
                        </div>
                    </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="panel b-a">
                        <div class="panel-body">              
                            <div class="form-group">
                              <label>ID</label>
                              <input id="sku" type="text" class="form-control" disabled="" value="<?php echo $item->id; ?>">
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
                              <input type="text" class="form-control" disabled="" placeholder="" value="<?php if($count >=1) echo $eans[0]->barcode; ?>">
                            </div>                            

                            <div class="form-group">
                              <label>EAN 2</label>
                              <input type="text" class="form-control" disabled="" placeholder="" value="<?php if($count >=2) echo $eans[1]->barcode; ?>">
                            </div>                            
                            
                            <div class="form-group">
                              <label>Title</label>
                              <input type="text" class="form-control" disabled="" value="<?php echo $item->title; ?>">
                            </div>
                            
                            <div class="form-group">
                              <label>Subtitle</label>
                              <input type="text" class="form-control" disabled="" value="<?php echo $item->subtitle; ?>">
                            </div>

                            <div class="form-group">
                              <label>Model</label>
                              <input type="text" class="form-control" placeholder="" disabled="" value="<?php echo $item->model; ?>">
                            </div>

                            <div class="form-group">
                              <label>Brand</label>
                              <input type="text" class="form-control" placeholder="" disabled="" value="<?php echo $item->brand; ?>">
                            </div>
                            
                            <div class="form-group">
                              <label>Client</label>
                                <?php 
                                    $client = $database->selectSingleClass('tblClients', 'MClient', array('id' => $item->clientId));
                                ?>
                              <input type="text" class="form-control" placeholder="" disabled="" value="<?php echo $client->client_name; ?>">
                            </div>                            
                            
                            <div class="form-group">
                              <label>Supplier</label>
                                <?php 
                                    $supplier = $database->selectSingleClass('tblSuppliers', 'MSupplier', array('id' => $item->supplierId));
                                ?>
                              <input type="text" class="form-control" placeholder="" disabled="" value="<?php echo $supplier->supplier_name; ?>">
                            </div>                            

                            <div class="form-group">
                              <label>Donation</label>
                                <?php 
                                    $charity = $database->selectSingleClass('tblCharity', 'MCharity', array('id' => $item->charityId));
                                ?>
                              <input type="text" class="form-control" placeholder="" disabled="" value="<?php echo $charity->donation; ?>%">

                            </div>                             

                            <div class="form-group">
                              <label>Product Group</label>
                                <?php 
                                    $group = $database->selectSingleClass('tblProductGroups', 'MProductGroup', array('id' => $item->productGroupId));
                                ?>
                              <input type="text" class="form-control" placeholder="" disabled="" value="<?php echo $group->name; ?>">

                            </div>                            
                            
                            
<!-- full description -->
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Full Description</label>
                      <div class="col-lg-10"><?php echo $item->fullDescription ;?></div>                            
                    </div>
                    <div class="row"></div>     
<!-- short description -->                            
       
                    <div class="form-group" >
                      <label class="col-sm-2 control-label">Short Description</label>                        
                      <div class="col-lg-10"><?php echo $item->shortDescription . " " ;?></div>                            
                    </div>
                    <div class="row"></div>
                            
                            <div class="form-group">
                              <label>RRP</label>
                              <input type="text" class="form-control" placeholder="" disabled="" value="<?php echo $item->RRP; ?>">
                            </div>                            
                            
                             <div class="form-group">
                              <label>Weight</label>
                              <input type="text" class="form-control" placeholder="" disabled="" value="<?php echo $item->weight; ?>">
                            </div>                            

                            <div class="form-group">
                              <label>Length</label>
                              <input type="text" class="form-control" placeholder="" disabled="" value="<?php echo $item->length; ?>">
                            </div>                     
                            
                            <div class="form-group">
                              <label>Height</label>
                              <input type="text" class="form-control" placeholder="" disabled="" value="<?php echo $item->height; ?>">
                            </div>                             
                            
                            <div class="form-group">
                              <label>Width</label>
                              <input type="text" class="form-control" placeholder="" disabled="" value="<?php echo $item->width; ?>">
                            </div>               

                            <div class="form-group">
                              <label>Postage</label>
                              <input type="text" class="form-control" placeholder="" disabled="" value="<?php echo $item->postage; ?>">
                            </div>                     
                    
                            <div class="form-group">
                                <label>Package</label>
                                <?php 
                                    $package = $database->selectSingleClass('tblPackages', 'MPackage', array('id' => $item->packageId));
                                ?>
                                <input type="text" class="form-control" placeholder="" disabled="" value="<?php echo $package->size; ?>">
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
  
</body>
</html>