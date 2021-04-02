<?php 
include_once('../../../model/model.php');
include_once('../../../model/finance_master/journal_entry/journal_master.php');
include_once('../../../model/app_settings/transaction_master.php');
include_once('../../../model/app_settings/bank_cash_book_master.php');

$journal_master = new journal_master;
$journal_master->journal_master_update();
?>