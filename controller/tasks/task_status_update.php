<?php 
include_once('../../model/model.php');
include_once('../../model/tasks_master.php');

$tasks_master = new tasks_master;
$tasks_master->tasks_status_update();
?>