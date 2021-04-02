<?php 
include_once('../../../model/model.php');
include_once('../../../model/other_masters/references_master.php');

$references_master = new references_master;
$references_master->reference_update();
?>