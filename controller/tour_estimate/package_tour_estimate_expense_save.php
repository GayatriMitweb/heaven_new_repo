<?php 
include_once('../../model/model.php');
include_once('../../model/tour_estimate/package_tour_estimate_expense.php');

$package_tour_estimate_expense = new package_tour_estimate_expense();
$package_tour_estimate_expense->package_tour_estimate_expense_save();
?>