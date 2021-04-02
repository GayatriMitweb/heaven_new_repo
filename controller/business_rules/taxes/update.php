<?php 
include "../../../model/model.php"; 
include "../../../model/business_rules/taxes.php";

$taxes_master = new taxes_master(); 
$taxes_master->update();
?>