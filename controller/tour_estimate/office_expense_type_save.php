<?php 
include_once('../../model/model.php');
include_once('../../model/tour_estimate/office_expense.php');

$office_expense = new office_expense();
$office_expense->office_expense_type_save();
?>