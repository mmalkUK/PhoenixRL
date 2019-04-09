<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MConfig
 *
 * @author malic
 */
class MConfig {
    //database connection details
    public static $db_address  = 'localhost';
    public static $db_username = 'phoenixrl_php';
    public static $db_password = 'phoenixrl_php';
    public static $db_database = 'phoenixrl_dev';
    public static $db_type     = 'mysql';
    
    
    public static $config_server_type       = 'dev';
    
    public static $secure_connection        = false;
    
    public static $debug_mode               = true;
    public static $debug_supress_savings    = false;
    
}
