<?php 
include_once('../../../model/model.php');
include_once('../../../model/employee/employee_performance_master.php');

$employee_performance_master = new employee_performance_master;
$employee_performance_master->employee_performance_save();
?>