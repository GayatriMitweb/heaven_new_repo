<?php 
include_once('../../../../model/model.php');
include_once('../../../../model/vendor/dashboard/vendor_advance_master.php');
include_once('../../../../model/app_settings/transaction_master.php');
include_once('../../../../model/app_settings/bank_cash_book_master.php');
include_once('../../../../view/vendor/inc/vendor_generic_functions.php');

$vendor_payment_master = new vendor_payment_master;
$vendor_payment_master->vendor_payment_save();
?>