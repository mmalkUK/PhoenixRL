<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mitem
 *
 * @author Marcin
 */
class MItem {
    public static $DTFields = array(
        'tblItems.accessId' => 'AccessId',
        'tblItems.id' => 'Id',
        'tblItems.Sku' => 'Sku',
        'tblItems.Title' => 'Title',
        'tblSuppliers.supplier_name' => 'Supplier',
        'tblProductGroups.name' => 'Product Group',
        '1' => ''
    );
    
    public static $join_list = 'INNER JOIN tblSuppliers ON tblItems.supplierId = tblSuppliers.id INNER JOIN tblProductGroups ON tblItems.productGroupId = tblProductGroups.id';

    public $id;
    public $accessId;
    public $active;
    public $creation_date;
    public $created_by;
    public $lockTime;
    public $lockId;
    public $clientId;
    public $supplierId;
    public $sku;
    public $title;
    public $subtitle;
    public $model;
    public $brand;
    public $charityId;
    public $productGroupId;
    public $fullDescription;
    public $shortDescription;
    public $RRP;
    public $RRPdate;
    public $weight;
    public $length;
    public $width;
    public $height;
    public $paskageId;
    public $postage;
    
}
