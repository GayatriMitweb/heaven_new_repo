<?php 
include_once('../../../model/model.php');
include_once('../../../model/employee/employee_salary_master.php');

$employee_salary_master = new employee_salary_master;
$employee_salary_master->employee_salary_update();
?>