<?php 
include "../../model/model.php"; 
include "../../model/other_expense/expense_master.php";
include_once('../../model/app_settings/transaction_master.php');
include_once('../../model/app_settings/bank_cash_book_master.php');

$expense_master = new expense_master(); 
$expense_master->expense_save();
?>