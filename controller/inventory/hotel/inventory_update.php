<?php
include_once('../../../model/model.php');
include_once('../../../model/inventory/hotel_inventory_master.php');

$hotel_inventory_master = new hotel_inventory_master;
$hotel_inventory_master->hotel_inventory_update();
?>p