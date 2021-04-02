<?php 
include_once('../../../model/model.php');
include_once('../../../model/employee/user_log_master.php');

$user_log_master = new user_log_master;
$user_log_master->user_log_update();
?>