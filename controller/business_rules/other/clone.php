<?php 
include "../../../model/model.php"; 
include "../../../model/business_rules/other_rules.php";

$taxes_master = new other_rules_master(); 
$taxes_master->clone_rule();
?>