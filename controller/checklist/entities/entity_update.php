<?php 
include_once('../../../model/model.php');
include_once('../../../model/checklist/entities_master.php');

$entities_master = new entities_master;
$entities_master->entity_update();
?>