<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MContainer
 *
 * @author malic
 */
class MContainer {
    
    public static $DTFields = array(
        'tblContainers.id' => 'ID',
        'tblContainerTypes.type' => 'Type',
        'tblContainerStatuses.status' => 'Status',
        'tblSuppliers.supplier_name' => 'Supplier',
        'tblContainers.allowMix' => 'Allow Mix' ,
        '1' => ''
    );
    
    public static $join_list = 'INNER JOIN tblSuppliers ON tblContainers.supplierId = tblSuppliers.id INNER JOIN tblContainerTypes ON tblContainers.containerTypeId = tblContainerTypes.id INNER JOIN tblContainerStatuses ON tblContainers.containerStatusId = tblContainerStatuses.id ';    
    
    public $id;
    public $accessId;
    public $active;
    public $creation_date;
    public $created_by;
    public $lockTime;
    public $lockId;
    public $containerTypeId;
    public $containerStatusId;
    public $supplierId;
    public $allowMix;
    
    

}
