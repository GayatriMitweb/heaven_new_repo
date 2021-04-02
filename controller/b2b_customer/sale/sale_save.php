<?php 
include "../../../model/model.php"; 
include "../../../model/b2b_customer/sale/sale_save.php"; 

$b2b_sale = new b2b_sale(); 
$b2b_sale->save();
?>