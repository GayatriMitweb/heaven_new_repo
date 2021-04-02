<?php 
include "../../model/model.php"; 
include "../../model/b2b_customer/b2b_customer.php"; 
include_once('../../model/app_settings/transaction_master.php');
include_once('../../model/app_settings/bank_cash_book_master.php');

$b2b_customer = new b2b_customer(); 
$b2b_customer->customer_update();
?>