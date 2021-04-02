<?php 
include "../../model/model.php"; 
include "../../model/employee/employee_master.php"; 

$employee_master = new employee_master(); 
$employee_master->emp_photo_save();
?>