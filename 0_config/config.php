<?php

include_once 'server_type.php';

//system critical settings
$config = array();
$config['secure_connection'] = FALSE;
$config['use_POST'] = TRUE;
$config['lock_extend_time'] = 120;

//set database connection
$db = array();

if($config_server_type == 'live'){
    $db['address'] = "localhost";
    $db['username'] = "";
    $db['password'] = "";
    $db['database'] = "";
    $db['type'] = 'mysql';
}

if($config_server_type == 'dev'){
    $db['address'] = "localhost";
    $db['username'] = "";
    $db['password'] = "";
    $db['database'] = "";
    $db['type'] = 'mysql';
}

//Set debug modes
$debug_mode = false;
$debug_supress_saving = false;

if($config_server_type == 'dev'){
    $debug_mode = true;
    $debug_supress_saving = false;
}

