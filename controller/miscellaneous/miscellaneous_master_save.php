<?php 
include_once('../../model/model.php');
include_once('../../model/miscellaneous/miscellaneous_master.php');
include_once('../../model/miscellaneous/miscellaneous_payment_master.php');
include_once('../../model/app_settings/transaction_master.php');
include_once('../../model/app_settings/bank_cash_book_master.php');
 
$visa_master = new miscellaneous_master;
$visa_master->miscellaneous_master_save();
?>