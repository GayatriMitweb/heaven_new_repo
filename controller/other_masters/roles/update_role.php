<?php 
include_once('../../../model/model.php');
include_once('../../../model/other_masters/roles_master.php');

$roles_master = new roles_master;
$roles_master->role_update();
?>