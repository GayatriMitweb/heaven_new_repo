<?php 
include_once('../../model/model.php');
include_once('../../model/tour_estimate/office_expense.php');
include_once('../../model/app_settings/transaction_master.php');
include_once('../../model/app_settings/bank_cash_book_master.php');

$office_expense = new office_expense();
$office_expense->office_expense_save();
?>