<?php 
include_once('../../../model/model.php');
include_once('../../../model/tour_estimate/other_income/income_master.php');
include_once('../../../model/app_settings/transaction_master.php');
include_once('../../../model/app_settings/bank_cash_book_master.php');

$income_master = new income_master();
$income_master->income_save();
?>