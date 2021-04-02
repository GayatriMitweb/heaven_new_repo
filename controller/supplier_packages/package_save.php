<?php 
include_once('../../model/model.php');
include_once('../../model/supplier_package_master.php');

$supplier_package_master = new supplier_package_master;
$supplier_package_master->package_save();
?>