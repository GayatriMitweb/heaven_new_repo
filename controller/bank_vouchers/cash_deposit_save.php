<?php 
include "../../model/model.php"; 
include "../../model/bank_vouchers/cash_master.php";
include_once('../../model/app_settings/transaction_master.php');
include_once('../../model/app_settings/bank_cash_book_master.php');

$cash_master = new cash_master(); 
$cash_master->cash_deposit_save();
?>