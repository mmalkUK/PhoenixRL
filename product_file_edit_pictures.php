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
    
    if(MConfig::$debug_mode){
        print_r($post);
    }
    
    if(isset($post)){
        foreach($post as $key => $value){
            unlink($_SERVER['DOCUMENT_ROOT']. '/assets/pictures/' . $item->sku . '/' . $value);
        }
        $pictures = array_diff(scandir($_SERVER['DOCUMENT_ROOT']. '/assets/pictures/' . $item->sku . '/'), array('..', '.'));
        $i = 1;
        foreach($pictures as $row){
            rename($_SERVER['DOCUMENT_ROOT']. '/assets/pictures/' . $item->sku . '/' . $row, $_SERVER['DOCUMENT_ROOT']. '/assets/pictures/' . $item->sku . '/new.' . $row);
        }
        foreach($pictures as $row){
            rename($_SERVER['DOCUMENT_ROOT']. '/assets/pictures/' . $item->sku . '/new.' . $row, $_SERVER['DOCUMENT_ROOT']. '/assets/pictures/' . $item->sku . '/' . $i . '.jpg');
            $i++;
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
                      <h3 class="m-b-xs text-black">Edit pictures for: <?php echo $item->id . ': ' . $item->title;?></h3>
                    </div>
                  </section>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="product_file_edit?cmd=edit&val_a=<?php echo $item->accessId; ?>" class="btn btn-primary">Go Back</a>
                        </div>
                    </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="panel b-a">
                        <div class="panel-body">  
                            <form method="POST">
                        <?php

                            $pictures = array_diff(scandir($_SERVER['DOCUMENT_ROOT']. '/assets/pictures/' . $item->sku . '/'), array('..', '.'));
                            $i = 0;
                            foreach($pictures as $row){
                                $i++;
                        ?>
                    
<div class="row">
                                        <div class="form-group">
                                            <div class="col-lg-3">
                                             <a href="<?php echo '/assets/pictures/' . $item->sku . '/' . $row; ?>" class="thumb-lg">
                                                <img src="<?php echo '/assets/pictures/' . $item->sku . '/' . $row; ?>" alt="...">
                                                <i class="on b-white"></i>
                                            </a>                  
                                                </div>
                                            <div class="col-lg-9">
                                            <div class="checkbox">

                                                <label>
                                                    <input   type="checkbox" name="pic_<?php echo $i;?>" value="<?php echo $i . '.jpg'; ?>">Delete<br>
                                                </label>
                                            </div>
                                            </div>
                                        </div>
</div>
                        <?php        
                            }
                        ?>
                            
                                <button type="submit" class="btn btn-danger">Delete</button>
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

</body>
</html>