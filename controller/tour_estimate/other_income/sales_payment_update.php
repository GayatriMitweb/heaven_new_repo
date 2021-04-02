<?php 
include_once('../../../model/model.php');
include_once('../../../model/tour_estimate/other_income/sales_payment_master.php');
include_once('../../../model/app_settings/transaction_master.php');
include_once('../../../model/app_settings/bank_cash_book_master.php');

$sales_payment_master = new sales_payment_master;
$sales_payment_master->sales_payment_update();
?>