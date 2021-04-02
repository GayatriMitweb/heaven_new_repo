<?php
include "../../../model/model.php";
include_once('../../../model/b2b_customer/cancel/b2b_sale_cancel.php');

$b2b_sale_cancel = new b2b_sale_cancel(); 
$b2b_sale_cancel->cancel();
?>