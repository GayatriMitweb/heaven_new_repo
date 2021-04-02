<?php 
include_once('../../model/model.php');
include_once('../../model/booker_incentive/payment_master.php');
include_once('../../model/app_settings/transaction_master.php');
include_once('../../model/app_settings/bank_cash_book_master.php');

$payment_master = new payment_master;
$payment_master->payment_save();
?>