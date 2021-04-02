<?php 
include "../../model/model.php"; 
include "../../model/terms_and_conditions/terms_and_conditions.php"; 

$terms_and_conditions = new terms_and_conditions(); 
$terms_and_conditions->terms_and_conditions_update();
?>