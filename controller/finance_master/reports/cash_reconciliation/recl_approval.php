<?php 
include_once('../../../../model/model.php');
include_once('../../../../model/finance_master/reports/cash_reconciliation/reconcl_master.php');

$reconcl_master = new reconcl_master;
$reconcl_master->reconcl_approval_save();
?>