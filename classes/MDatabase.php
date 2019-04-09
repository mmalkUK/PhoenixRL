<?php

/*
 * Project:			Database connector
 * Version:			0.2
 * File:			MDatabase.php
 * Location:		
 * Author:			Marcin Malicki
 * Contact:			mechanic@profondo.co.uk
 * Web:				http://profondo.co.uk
 * Description:                 Database class helper
 * Creation date:               24/12/2014
 * Changes:			All the time
 */

class MDatabase {
    private $host;
    private $user;
    private $password;
    private $database;
    
    private $connection;
    public $error;
    public $error_query;
    
    private $statement;
    private $resultCount;
    
    private $debug_mode;
	
    private $instance;
    private $type;
    

    public function __construct($host, $uset, $password, $database, $instance = null, $type = "mysql", $debug_mode = false) {
        $this->debug_mode = $debug_mode;
        $this->host = $host;
        $this->user = $uset;
        $this->password = $password;
        $this->database = $database;
        $this->error = null;
        $this->error_query = null;
        $this->instance = $instance;
        $this->type = $type;
        
        //set database source name
        $dsn = null;
		
	if($type == "mssql-win"){
			$dsn = "sqlsrv:server=" . $this->host . ";Database=" . $this->database;  
		}else if($type == "mssql"){ 
			$dsn = 'dblib:host=' . $this->host . ';dbname=' . $this->database;
		}else{ //for mysql as default
                    $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->database;
                }
		
        //set options
        $options = array(
                    PDO::ATTR_PERSISTENT => true, 
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        // Create a new PDO instanace
        try{
			if($type == 'mssql'){
				$this->connection = new PDO($dsn, $this->user, $this->password);
				$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}else{
				$this->connection = new PDO($dsn, $this->user, $this->password, $options);
			}
        }
        // Catch any errors
        catch(PDOException $ex){
            $this->error = $ex->getMessage();
            echo $this->error;
        }
    }
    
	public function setInstance($instance){
		$this->instance = $instance;
	}
	
    public function getError(){
        if(is_null($this->error)){
            return $this->error;
        }
        return $this->error . ' query: ' . $this->error_query;
    }
    
    public function __destruct() {
        $this->connection = null;
    }

    public function selectSingleClass($table, $class, $whereArray, $whereStatement = null, $additionalStatement = null){
        $query = "SELECT * FROM $table";
        
        if($whereArray != null){
            $query .= " WHERE ";
        }
        if($whereArray != null){
            $query .= $this->buildWhere($whereArray);
        }else{
            $query .= $whereStatement;
        }
 
        if($additionalStatement != null){
            $query .= ' '. $additionalStatement;
        }
		
		$query = $this->limit($query);   
        $this->prepare($query);
        $this->statement->setFetchMode(PDO::FETCH_CLASS, $class);
        $this->execute($whereArray);
        
        return $this->statement->fetch();
    }

    public function selectArrayClass($table, $class, $whereArray = null, $whereStatement = null, $additionalStatement = null){
        $query = "SELECT * FROM $table ";
        
        if($whereArray != null){
            $query .= " WHERE ";
        }
        if($whereArray != null){
            $query .= $this->buildWhere($whereArray);
        }else{
            $query .= $whereStatement;
        }
        
        if($additionalStatement != null){
            $query .= ' '. $additionalStatement;
        }
		
		$query = $this->limit($query);
        $this->prepare($query);
        $this->execute($whereArray);	
        return $this->statement->fetchAll(PDO::FETCH_CLASS, $class);
    }    
      
    public function getVar($var){
        $query = "SELECT value FROM vars WHERE variable = :variable";
		
		if($this->instance != null){
			$query .= " AND instanceId =" . $this->instance;
		} 
		        
        $this->prepare($query);
        $this->execute(array(':variable' => $var));

        return $this->statement->fetch(PDO::FETCH_ASSOC)['value'];
    }
	
	public function getInstance(){
		return $this->instance;	
	}
	
	public function setVar($var, $value){
		$query = "UPDATE vars SET value=:value WHERE variable=:variable";
		
		if($this->instance != null){
			$query .= " AND instanceId='" . $this->instance . "'";
		}
		
		$this->prepare($query);
		$this->execute(array(':value' => $value, ':variable' => $var));
		return $this->statement->rowCount();
	}
	    
	public function getField($table, $collumn, $variable, $value, $override = false){
        $query = "SELECT $collumn FROM $table WHERE $variable = :$variable";
		if($this->instance != null && $override == false){
			$query .= " AND instanceId =" . $this->instance;
		}

        $this->prepare($query);
        $this->execute(array(":$variable" => $value));
        return $this->statement->fetch(PDO::FETCH_ASSOC)[$collumn];
    }    
    
    public function insertRow($table, $dataArray){
        $query = "INSERT INTO $table (";
		$values = ":";
 
        $i = 0;
        foreach($dataArray as $key => $value) {
            if($i == 0){
                $query .= "";
            }else{
                $query .= ", ";
		$values .= ", :";
            }
        
            $query .= $key;
            $values .= $key;
		
            $i++;
        }

		if($this->instance != null){
			$query .= ", instanceId";
			$values .= ", '" . $this->instance . "'";
		}
		
        $query .= ") VALUES (" . $values . ")";    

        if($this->debug_mode){
            echo $query;
        }
        
        $this->prepare($query);
        $this->execute($dataArray);
        
        return $this->connection->lastInsertId();
    }
    
    public function checkIfExist($table, $dataArray){
        $select = '';
        $where = '';
        
        $i = 0;
        foreach($dataArray as $key => $value){
            if($i != 0){
                $select .= ', ';
                $where .= ' AND ';
            }
            $select .= $key;
            $where .= $key . '=:' . $key;
            $i++;
        }
        
        $query = 'SELECT count(' . $select . ") FROM $table WHERE " . $where;
		if($this->instance != null){
			$query .= " AND instanceID='" . $this->instance . "'";
		}
		
        $this->prepare($query);
        $this->execute($dataArray);
        if($this->statement->fetchColumn() > 0){
            return true;
        }
        return false;
    }
    
    public function update($table, $dataArray, $whereArray){
        $where = '';
        $i = 0;
        
        $query_array = array();
        foreach($whereArray as $key => $value){
            if($i != 0){
                $where .= ' AND ';
            }
            $where .= $key . '=:' . $key . '_w';
            $query_array[$key . '_w'] = $value;
            $i++;
        }
        
        
        $data = '';
        $i = 0;
        
        foreach($dataArray as $key => $value){
            if($i != 0){
                $data .= ', ';
            }
            $data .= $key . '=:' . $key;
            $query_array[$key] = $value;
            $i++;
        }
        
        $query = "UPDATE $table SET " . $data . " WHERE " . $where;
    
		if($this->instance != null){
			$query .= " AND instanceId='" . $this->instance . "'";
		}
	    
        $this->prepare($query);
        $this->execute($query_array);
        
        return $this->statement->rowCount();
    }
    
    private function prepare($query){
        try{
            $this->statement = $this->connection->prepare($query);
        } catch(PDOException $ex){
            $this->error = $ex->getMessage();
        }        
    }
    
    private function execute($array = null){
        try{
            if($array != null){
                $this->statement->execute($array);
            }else{
                $this->statement->execute();
            }
            $this->resultCount = $this->statement->rowCount();
        } catch(PDOException $ex){
            $this->error = $ex->getMessage();
        }        
    }

    public function getResultCount(){
        return $this->resultCount;
    }
    
    public function getDTSearchCount($table, $data, $where){
        $query = "SELECT count(*) AS c FROM $table";

        if(isset($data['join'])){
            $query .= " " . $data['join'];
        }          
        
        $query .= " WHERE " . $where;
        
        $this->prepare($query);
        $this->execute();

        return $this->statement->fetch()['c'];    
        
    }
    
    private function buildWhere($whereArray){
        $where = '';
        $i = 0;
        foreach($whereArray as $key => $value){
            if($i != 0){
                $where .= ' AND ';
            }
            $where .= $key . '=:' . $key;
            $i++;
        }        
        
		if($this->instance != null){
			$where .= " AND instanceId='" . $this->instance . "'";
		}
		
        return $where;
    }
    
	public function runQuery($query, $fetch = null, $type2 = false){
		$query = $this->limit($query);
		$this->prepare($query);
        $this->execute();
		if($fetch == null){
			return $this->statement->fetchAll();
		}else if($fetch == true && $type2 == false){
            return $this->statement->rowCount();
        }else{
            return $this->statement->fetchAll($fetch);
        }
        
        
    }
    
    public function getRowsCount($table, $whereArray = null, $whereStatement = null){
        $query = "SELECT count(*) AS c FROM $table";
        if($whereArray != null){
            $query .= " WHERE ";
        }
        if($whereArray != null){
            $query .= $this->buildWhere($whereArray);
        }else{
            $query .= $whereStatement;
        }
        
        $this->prepare($query);
        $this->execute($whereArray);
        
        return $this->statement->fetch()['c'];
    }
    
    public function delete($table, $whereArray = null, $whereStatement = null){
        $query = "DELETE FROM $table";
        if($whereArray != null){
            $query .= " WHERE ";
        }
        if($whereArray != null){
            $query .= $this->buildWhere($whereArray);
        }else{
            $query .= $whereStatement;
        }
        
        $this->prepare($query);
        $this->execute($whereArray);        
        
        return $this->statement->rowCount();
    }
	
    public function mainLog($message){
            return $this->insertRow('dbo.logs', array('message' => $message));	
    }
	
    public function selectDT($table, $data, $where = null, $join = null){
            $query = "SELECT ";
            $i = 0;
            foreach($data as $key => $value){
                if($key != 'join'){
                    if($i != 0){
                            $query .= ', ';
                    }
                    $query .= $key . ' AS ' . '"' . $value . '"';
                    $i++;
                }
            }          

            $query .= " FROM $table";

            if($this->instance != null){
                    $query .= " WHERE instanceId='" . $this->instance . "'";
            }

            if($this->instance == null && $where != null){
                    $query .= " WHERE";
            }

            if($where != null){
                    $query .= " " . $where;	
            }

            if(isset($data['join'])){
                $query .= " " . $data['join'];
            }
            
            if($join != null){
                $query .= " " . $join;
            }

            $query = $this->limit($query);
            $this->prepare($query);
            $this->execute();
            $this->error_query = $query;
            
            return $this->statement->fetchAll();

    }
	
    public function selectDTSS($table, $data, $where = null, $orderby, $orderdir ,$start = 0, $limit = 10){
        $query = "SELECT ";
            $i = 0;
            foreach($data as $key => $value){
                if($key != 'join'){
                    if($i != 0){
                            $query .= ', ';
                    }
                    $query .= $key . ' AS ' . '"' . $value . '"';
                    $i++;
                }
            }          

            $query .= " FROM $table";

            if(isset($data['join'])){
                $query .= " " . $data['join'];
            }            
            
            if($this->instance != null){
                    $query .= " WHERE instanceId='" . $this->instance . "'";
            }

            if($this->instance == null && $where != null){
                    $query .= " WHERE";
            }

            if($where != null){
                    $query .= " " . $where;	
            }



            $query .= " ORDER BY $orderby $orderdir LIMIT $start, $limit";
            
            
            $query = $this->limit($query);

            $this->prepare($query);
            $this->execute();

            return $this->statement->fetchAll();

    }    
    
    public function getMax($table, $collumn){
            $query = "SELECT MAX($collumn) as MAX FROM $table";

                    if($this->instance != null){
                    $query .= " WHERE instanceId =" . $this->instance;
            } 

            $this->prepare($query);
            $this->execute();

            return $this->statement->fetch(PDO::FETCH_ASSOC)['MAX'];		
    }	
	
    public function limit($query){
            //set output to be the same as input in case there is no limit
            $newQuery = $query;
            //find where LIMIT starts
            $posLimit = strpos($query, "LIMIT ");
            //if limit found
            if($posLimit > 1){
                    //get whole query length
                    $queryLen = strlen($query);
                    //remove SELECT and LIMIT to get pure query
                    $cut = substr($query, 7, $posLimit - 7);
                    //get number for limit
                    $limit = substr($query, $posLimit+6);
                    
                    $is_offset = strpos($limit, ",");
                    
                    if($is_offset < 1){
                        //set TOP
                        $top = "TOP $limit";
                        //build new query
                        $newQuery = "SELECT $top $cut";
                    }else{
                        $explode = array();
                        $explode = explode(",", $limit);
                        
                        $newQuery = "SELECT $cut OFFSET $explode[0] ROWS FETCH NEXT $explode[1] ROWS ONLY";
                    }
            }
            
            return $newQuery;	
    }
        
    public function selectEdit($table, $data, $whereArray = null){
        return $this->select($table, $data, $whereArray);
    }   
    
    public function selectEditRaw($table, $data, $whereArray = null){
        return $this->select($table, $data, $whereArray, true);
    }

    public function select($table, $data, $whereArray = null, $raw = false){
        $query = "SELECT ";
        $i = 0;
        foreach($data as $key => $value){
            if($i != 0){
                $query .= ', ';
            }
            
            $query .= $key;
            if(!$raw){
                $query .= ' AS ' . '"' . $value[0] . '"';
            }
            $i++;
        }          
        
        $query .= " FROM $table";

       if($whereArray != null){
            $query .= " WHERE ";
        }
        if($whereArray != null){
            $query .= $this->buildWhere($whereArray);
        }
        $this->prepare($query);
        $this->execute($whereArray);
        
        return $this->statement->fetch();        
    }
    
    public function get_id($table, $where, $id = "id"){
        $query = "SELECT $id FROM $table WHERE ";
        $query .= $this->buildWhere($where);
        $this->prepare($query);
        $this->execute($where);
        
        return $this->statement->fetch();          
        
    }
    public function get_id_by_ac($table, $ac){
        $query = "SELECT id FROM $table WHERE accessId='$ac'";

        $this->prepare($query);
        $this->execute();
        
        return $this->statement->fetch()['id'];          
        
    }    
}
