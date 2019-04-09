<?php

    session_start();

    if(!MHelper::isSecure(MConfig::$secure_connection)){
        header('Location: indexError');
        die();
    }
    
    if(!isset($_SESSION['user'])){
        header('Location: index');
        die();        
    }
    
    $user = $_SESSION['user'];
    
    if(!isset($user)){
        header('Location: index');
        die();
    }


