<?php
include "../../../model/model.php";
include_once('../../../model/b2b_customer/cancel/refund_estimate.php');
include_once('../../../model/app_settings/transaction_master.php');
include_once('../../../model/app_settings/bank_cash_book_master.php');

$b2b_refund_estimate = new b2b_refund_estimate(); 
$b2b_refund_estimate->refund_estimate();
?>