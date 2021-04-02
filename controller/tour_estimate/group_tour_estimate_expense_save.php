<?php 
include_once('../../model/model.php');
include_once('../../model/tour_estimate/group_tour_estimate_expense.php');

$group_tour_estimate_expense = new group_tour_estimate_expense();
$group_tour_estimate_expense->group_tour_estimate_expense_save();
?>