<?php 
include_once('../../model/model.php');
include_once('../../model/tasks_master_clone.php');

$tasks_clone = new tasks_clone;
$tasks_clone->tasks_master_clone();
?>