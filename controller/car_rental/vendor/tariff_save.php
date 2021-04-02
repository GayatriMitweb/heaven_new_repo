<?php 
include_once('../../../model/model.php');
include_once('../../../model/car_rental/tariff_master.php');

$vendor_master = new vendor_master;
$vendor_master->vendor_save();
?>