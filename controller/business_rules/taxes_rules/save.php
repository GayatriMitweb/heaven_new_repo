<?php 
include "../../../model/model.php"; 
include "../../../model/business_rules/taxes_rules.php";

$taxes_master = new taxes_rules_master(); 
$taxes_master->save();
?>