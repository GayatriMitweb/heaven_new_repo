<?php 
include_once('../../../model/model.php');
include_once('../../../model/other_masters/airline_master.php');

$airline_master = new airline_master;
$airline_master->airline_update();
?>