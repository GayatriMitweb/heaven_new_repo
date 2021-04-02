<?php 
include_once('../../model/model.php');
include_once('../../model/miscellaneous/miscellaneous_payment_master.php');
include_once('../../model/app_settings/transaction_master.php');
include_once('../../model/app_settings/bank_cash_book_master.php');

$visa_payment_master = new miscellaneous_payment_master;
$visa_payment_master->miscellaneous_payment_master_save();
?>