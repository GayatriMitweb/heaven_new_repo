<?php 
include_once('../../../model/model.php');
include_once('../../../model/finance_master/ledger_master/ledger_master.php');

$ledger_master = new ledger_master;
$ledger_master->ledger_master_save();
?>