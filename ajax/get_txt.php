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
            $respond = $database->selectSingleClass('tblItems', 'MItem', array('sku' => $val['val']));
            if($respond){
                echo $respond->sku . ' - ' . $respond->title;
            }else{
                echo 'Error';
            }
        }else if($cmd == 'container_receive'){
            $respond = $database->selectSingleClass('tblContainers', 'MContainer', array('id' => $val['val']));
            if($respond){
                $supplier = $database->selectSingleClass('tblSuppliers', 'MSupplier', array('id' => $respond->supplierId));
                $containerStatus = $database->selectSingleClass('tblContainerStatuses', 'MContainerStatus', array('id' => $respond->containerStatusId));
                $containerType = $database->selectSingleClass('tblContainerTypes', 'MContainerType', array('id' => $respond->containerTypeId));
                echo $respond->id . ' - ' . $containerType->type . ' - ' . $containerStatus->status;
            }else{
                echo 'Error';
            }
        }else if($cmd == 'sku_price'){
            $respond = $database->selectSingleClass('tblItems', 'MItem', array('sku' => $val['val']));
            if($respond){
                echo $respond->RRP;
            }else{
                echo 'Error';
            }        
        }else if($cmd == 'container_receive_dispatch'){
            $respond = $database->selectSingleClass('tblContainers', 'MContainer', array('id' => $val['val']));
            if($respond){
                $supplier = $database->selectSingleClass('tblSuppliers', 'MSupplier', array('id' => $respond->supplierId));
                $containerStatus = $database->selectSingleClass('tblContainerStatuses', 'MContainerStatus', array('id' => $respond->containerStatusId));
                $containerType = $database->selectSingleClass('tblContainerTypes', 'MContainerType', array('id' => $respond->containerTypeId));
                //check if item exist in this container
                $item = $database->selectSingleClass('tblItems', 'MItem', array('sku' => $val['val2']));
                if($item){
                    $query = 'SELECT sum(qty) AS QTY FROM tblContainerElements WHERE active = 1 and containerId=' . $val['val'] . ' and skuId=' . $item->id;
                    $result = $database->runQuery($query);

                    if($result){
                        if(isset($result[0]['QTY'])){
                            if($result[0]['QTY'] > 0){
                                echo $respond->id . ' - ' . $containerType->type . ' - ' . $containerStatus->status;
                            }else{
                                echo 'Error - Qty less than 0';
                            }
                        }else{
                            echo 'Error - Qty not exist';
                        }
                            
                        
                    }else{
                        echo 'Error - Item not in container';
                    }
                    
                }else{
                    echo 'Error - Item doesn\'t exist';
                }
                
                
            }else{
                echo 'Error';
            }
        }else{
            echo 'Error';
        }
    }else{
        echo 'Error';
    }  
