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
    
    
    $database = new MDatabase(MConfig::$db_address, MConfig::$db_username, MConfig::$db_password, MConfig::$db_database, null, MConfig::$db_type);

    if(isset($cmd)){
        if($cmd == 'sku'){
            $respond = $database->checkIfExist('tblItems', array('sku' => $val['val_a']) );
            if($respond){
                echo '1';
            }else{
                echo '0';
            }
        }else if($cmd == 'container_receive'){
            $respond = $database->checkIfExist('tblContainers', array('id' => $val['val_a']) );
            if($respond){
                if($respond->status < 99){
                    echo '1';
                }else{
                    echo '0';
                }    
            }else{
                echo '0';
            }            
        }else{
            echo 'Unknown cmd';
        }
    }else{
        echo 'Incorrect cmd';
    }  
