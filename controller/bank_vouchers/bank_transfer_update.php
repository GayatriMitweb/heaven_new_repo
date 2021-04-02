<?php 
include "../../model/model.php"; 
include "../../model/bank_vouchers/bank_transfer_master.php";
include_once('../../model/app_settings/transaction_master.php');
include_once('../../model/app_settings/bank_cash_book_master.php');

$bank_transfer_master = new bank_transfer_master(); 
$bank_transfer_master->bank_transfer_update();
?>