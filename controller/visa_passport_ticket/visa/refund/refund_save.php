<?php 
include_once('../../../../model/model.php');
include_once('../../../../model/visa_password_ticket/visa/visa_refund.php');
include_once('../../../../model/app_settings/transaction_master.php');
include_once('../../../../model/app_settings/bank_cash_book_master.php');

$visa_refund = new visa_refund;
$visa_refund->visa_refund_save();
?>