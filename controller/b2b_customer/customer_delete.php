<?php 
include_once('../../model/model.php');
include_once('../../model/b2b_customer/b2b_customer.php');

$b2b_customer = new b2b_customer;
$b2b_customer->customer_delete();
?>