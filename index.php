<?php

    date_default_timezone_set('UTC');
    if(!function_exists("__autoload")) {
        function __autoload($class_name) {
            include_once 'classes/' . $class_name . '.php';
        }
    } 

    session_start();
    $post = filter_input_array(INPUT_POST);
    $cmd = filter_input(INPUT_GET, 'cmd');

    $error = '';
    if(isset($post['user_name']) && isset($post['password'])){
        $database = new MDatabase(MConfig::$db_address, MConfig::$db_username, MConfig::$db_password, MConfig::$db_database, null, MConfig::$db_type);
        
        $user = $database->selectSingleClass('tblUsers', 'MUser', array('user_name' => $post['user_name']));

        if(isset($user->id)){
            if($user->check_password(md5($post['password']))){
          
                $accessTime = new DateTime($user->actualTime);
                if(empty($user->actualTime)){
                    $accessTime = new DateTime(date('Y-m-d H:i:s'));
                    $accessTime->sub(new DateInterval('PT200S'));
                }
                $actualTime = new DateTime(date('Y-m-d H:i:s'));
                $accessTime->add(new DateInterval('PT120S'));
                if($actualTime > $accessTime) {
                //check if user is active
                    if($user->active == 1){
                        //record last login date and reseta login fails
                        $user->lastLogin = date('Y-m-d H:i:s');
                        $user->login_fails = 0;
                        $database->update('tblUsers', array('login_fails' => $user->login_fails, 'lastLogin' => $user->lastLogin), array('id' => $user->id));
                        $user->set_code($database);
                        $user->keep_alive($database);
                        $_SESSION['user'] = $user;
                        header('Location: mainscreen');
                        die();
                    }
                }else{
                    $error = 'Already logged in. Log out from your previous session or wait 120 seconds if session was closed incorretly';
                    session_destroy();
                }
                
            }else{ //wrong password supplied so add count for fails and if more than 3 block user
                $user->login_fails += 1;
                if($user->login_fails > 3){
                    $user->active = 0;
                }
                $database->update('tblUsers', array('login_fails' => $user->login_fails, 'active' => $user->active), array('id' => $user->id));
                $error = 'Incorrect username or password';
                session_destroy();
            }
        }else{
            $error = 'Incorrect username or password';
            session_destroy();
        }
    }

    
?>

<!DOCTYPE html>
<html lang="en" class=" ">
<?php include 'elements/html_head.php'; ?>
<body class="" >
  <section id="content" class="m-t-lg wrapper-md animated fadeInUp">    
    <div class="container aside-xl">
      <a class="navbar-brand block" href="index">Phoenix RL</a>
      <section class="m-b-lg">
        <header class="wrapper text-center">
          <strong>Sign In</strong>
        </header>
          <form method="POST" action="">
          <div class="list-group">
            <div class="list-group-item">
              <input type="text" placeholder="Username" name="user_name" class="form-control no-border">
            </div>
            <div class="list-group-item">
               <input type="password" placeholder="Password" name="password" class="form-control no-border">
            </div>
          </div>
          <button type="submit" class="btn btn-lg btn-primary btn-block">Sign in</button>
          <!-- <div class="text-center m-t m-b"><a href="#"><small>Forgot password?</small></a></div>-->
          <div class="line line-dashed"></div>
        </form>
      </section>
    </div>
  </section>
  <!-- footer -->
  <footer id="footer">
    <div class="text-center padder">
      <p>
        <small>Phoenix RL<br>&copy; 2017</small>
      </p>
    </div>
  </footer>
  <!-- / footer -->
  <script src="js/jquery.js"></script>
  <!-- Bootstrap -->
  <script src="js/bootstrap.js"></script>
  <!-- App -->
  <script src="js/app.js"></script>  
  <script src="js/slimscroll/jquery.slimscroll.min.js"></script>
  <script src="js/app.plugin.js"></script>
  <script src="js/bootstrap-dialog.js"></script>  
  <?php 
    if($error != ''){
        echo MDialogHelper::error_dialog($error);
    }
  ?>  
</body>
</html>

