<?php 
include_once('../../../model/model.php');
include_once('../../../model/finance_master/bank_master/bank_master.php');
include_once('../../../model/app_settings/transaction_master.php');

$bank_master = new bank_master;
$bank_master->bank_master_save();
?>