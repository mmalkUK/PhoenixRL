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
                      <h3 class="m-b-xs text-black">Products list</h3>
                    </div>
                  </section>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="panel b-a">                        
                        <form role="form">
                            <div class="form-group">
                              <label>Email address</label>
                              <input type="email" class="form-control" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                              <label>Password</label>
                              <input type="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="checkbox i-checks">
                              <label>
                                <input type="checkbox" checked disabled><i></i> Check me out
                              </label>
                            </div>
                            <button type="submit" class="btn btn-sm btn-default">Submit</button>
                        </form>                      
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