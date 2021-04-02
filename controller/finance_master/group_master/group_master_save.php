<?php 
include_once('../../../model/model.php');
include_once('../../../model/finance_master/group_master/group_master.php');

$subgroup_master = new subgroup_master;
$subgroup_master->subgroup_master_save();
?>