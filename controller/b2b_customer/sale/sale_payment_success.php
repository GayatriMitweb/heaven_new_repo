<?php 
include "../../../model/model.php"; 
include "../../../model/b2b_customer/sale/sale_save.php"; 
include_once('../../../model/app_settings/transaction_master.php');
include_once('../../../model/app_settings/bank_cash_book_master.php');

$b2b_sale = new b2b_sale(); 
$b2b_sale->success_save();
?>