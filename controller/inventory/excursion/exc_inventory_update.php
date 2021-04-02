<?php 
include_once('../../../model/model.php');
include_once('../../../model/inventory/exc_inventory_master.php');

$exc_inventory_master = new exc_inventory_master;
$exc_inventory_master->exc_inventory_update();
?>