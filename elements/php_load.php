<?php

 
    
    session_start();
    
    if(!isset($_SESSION['user'])){
        header('Location: index');
        die();        
    }
    
    $user = $_SESSION['user'];
    
    if(!isset($user)){
        header('Location: index');
        die();
    }
    
    $cmd = filter_input(INPUT_GET, 'cmd');
    $id = filter_input(INPUT_GET, 'id');
    
    if(!isset($cmd)){
        header('Location: index');
        die();        
    }
    
    if(!isset($id)){
        header('Location: index');
        die();        
    }
    
    if(!AccessControll::checkPermission($user->get_access_level(), $cmd)){
        header('Location: index');
        die();        
    }
    