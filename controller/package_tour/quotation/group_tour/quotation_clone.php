<?php 
include "../../../../model/model.php"; 
include "../../../../model/package_tour/quotation/group_tour/quotation_clone.php"; 

$quotation_clone = new quotation_clone;
$quotation_clone->quotation_master_clone();
?>