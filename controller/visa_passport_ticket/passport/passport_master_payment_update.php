<?php 
include_once('../../../model/model.php');
include_once('../../../model/visa_password_ticket/passport/passport_payment_master.php');
include_once('../../../model/app_settings/transaction_master.php');
include_once('../../../model/app_settings/bank_cash_book_master.php');

$passport_payment_master = new passport_payment_master;
$passport_payment_master->passport_payment_master_update();
?>