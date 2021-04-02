<?php 
include "../../model/model.php"; 
include "../../model/custom_packages/package_master.php"; 
$package_master1 = new custom_package();

$package_master1->delete_hotel_image();
?>