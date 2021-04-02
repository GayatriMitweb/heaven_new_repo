<?php 
include "../../model/model.php"; 
include "../../model/custom_packages/package_clone.php"; 

$package_clone = new package_clone;
$package_clone->package_clone_save();
?>