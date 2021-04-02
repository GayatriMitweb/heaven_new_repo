<?php 
include_once('../../../../model/model.php');
include_once('../../../../model/finance_master/reports/bank_reconciliation/reconcl_master.php');

$reconcl_master = new reconcl_master;
$reconcl_master->reconcl_master_save();
?>