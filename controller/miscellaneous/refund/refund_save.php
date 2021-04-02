<?php 
include_once('../../../model/model.php');
include_once('../../../model/miscellaneous/visa_refund.php');
include_once('../../../model/app_settings/transaction_master.php');
include_once('../../../model/app_settings/bank_cash_book_master.php');

$visa_refund = new miscellaneous_refund;
$visa_refund->miscellaneous_refund_save();
?>