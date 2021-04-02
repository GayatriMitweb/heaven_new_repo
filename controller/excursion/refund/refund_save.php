<?php 
include_once('../../../model/model.php');
include_once('../../../model/excursion/exc_refund.php');
include_once('../../../model/app_settings/transaction_master.php');
include_once('../../../model/app_settings/bank_cash_book_master.php');

$exc_refund = new exc_refund;
$exc_refund->exc_refund_save();
?>