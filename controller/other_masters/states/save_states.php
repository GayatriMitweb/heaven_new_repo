<?php 
include_once('../../../model/model.php');
include_once('../../../model/other_masters/state_master.php');

$state_master = new state_master;
$state_master->state_save();
?>