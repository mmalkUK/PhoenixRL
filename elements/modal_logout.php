<?php 

    date_default_timezone_set('UTC');
    if(!function_exists("__autoload")) {
        function __autoload($class_name) {
            include_once $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class_name . '.php';
        }
    } 

    include $_SERVER['DOCUMENT_ROOT'] . '/elements/php_session_check.php';

?>
<div class="modal-over">
  <div class="modal-center animated fadeInUp text-center" style="width:200px;margin:-80px 0 0 -100px;">
    <div class="thumb-md"><img src="images/phoenix.png" class="img-circle b-a b-light b-3x"></div>
    <p class="text-white h4 m-t m-b"><?php echo $_SESSION['user']->full_name; ?></p>
    <div class="input-group">
        <p>Are you sure?</p>
      <span class="btn-group">
          <a href="mainscreen?cmd=logout" class="btn btn-s-md btn-danger btn-rounded">Logout</a>
          
          <button class="btn btn-success btn-rounded" type="button" data-dismiss="modal">Cancel</button>
      </span>
    </div>
  </div>
</div>