<?php 
include_once('../../../model/model.php');
include_once('../../../model/other_masters/inclusions_master.php');

$inclusions_master = new inclusions_master;
$inclusions_master->inclusion_save();
?>