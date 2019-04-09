<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author mmalicki
 */
class MUser {
    public $id;
    
    public $full_name;
    public $position;
    public $email;
    public $active;
    public $login_fails;
    public $firstTimeLogin;
    public $creation_date;
    public $created_by;
    public $lastLogin;
    
    
    private $password;
    private $reset_question_1;
    private $reset_question_2;
    private $reset_question_3;
    private $reset_answer_1;
    private $reset_answer_2;
    private $reset_answer_3;
    
    private $access_level;
    private $client_access;
    public $accessId;
    public $actualTime;
    private $code;
    
    public function check_password($password){
        if($this->password == $password){
            return true;
        }
        return false;
    }
    
    public function get_access_level(){
        return $this->access_level;
    }
    
    public function keep_alive_js(){
        $java = '';
        $java .= '<script>' . "\n";
        $java .= '  function keep_user_alive(){' . "\n";
        $java .= '    var jqxhr = $.get( "keep_alive?cmd=kl", function(text) {' . "\n";
        $java .= '      if(text != \'1\'){' . "\n";
        $java .= '          alert (\'something went wrong\');' . "\n";        
        $java .= '          window.location.href = "index";' . "\n";                
        $java .= '      }' . "\n";                        
        $java .= '      })' . "\n";
        $java .= '      .fail(function() {' . "\n";
        $java .= '          alert (\'something went wrong\');' . "\n";        
        $java .= '          window.location.href = "index";' . "\n";                
        $java .= '      })' . "\n";
        $java .= '      }' . "\n";
        $java .= '      setInterval( keep_user_alive, 40000 );' . "\n";
        $java .= '</script>' . "\n";    
        return $java;  
    }
    
   
    public function keep_alive(&$database){
        $query = "UPDATE dbo.tblUsers SET actualTime = getDate() WHERE accessId='$this->accessId' AND code='$this->code'";
        $result = $database->runQuery($query, true);
        if($result > 0){
            return true;
        }
        
        return false;  
    }
    
    public function set_code(&$database){
        $code = MHelper::encryptStringArray($this->lastLogin);
        $this->code = $code;
        $query = "UPDATE dbo.tblUsers SET code = '$code' WHERE accessId='$this->accessId'";
        $database->runQuery($query, true);
    }
    
    public function logout(&$database){
        $query = "UPDATE dbo.tblUsers SET code = NULL, actualTime = NULL WHERE accessId='$this->accessId'";
        $database->runQuery($query, true);        
    }
}
