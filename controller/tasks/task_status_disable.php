<?php 
include "../../model/model.php"; 
include "../../model/tasks_master.php"; 


$task_id = $_POST["task_id"]; 

$tasks_master = new tasks_master();
$tasks_master->task_status_disable($task_id);
?>