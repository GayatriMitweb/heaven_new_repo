<?php 
include "../../../model/model.php"; 
include "../../../model/employee/user_log_master.php";

$user_log_master = new user_log_master();
$user_log_master->attendance_csv_save();
?>