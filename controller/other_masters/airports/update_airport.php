<?php 
include_once('../../../model/model.php');
include_once('../../../model/other_masters/airport_master.php');

$airport_master = new airport_master;
$airport_master->airport_update();
?>