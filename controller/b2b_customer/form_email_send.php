<?php 
include "../../model/model.php"; 
include "../../model/b2b_customer/b2b_customer.php"; 

$b2b_customer = new b2b_customer(); 
$b2b_customer->reg_form_send();
?>