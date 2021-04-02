<?php 
include_once('../../../model/model.php');
include_once('../../../model/other_masters/destination_master.php');

$destination_master = new destination_master;
$destination_master->destination_save();
?>