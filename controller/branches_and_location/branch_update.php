<?php
include_once('../../model/model.php');
include_once('../../model/branches_and_locations/branch_master.php');

$branch_master = new branch_master;
$branch_master->branch_master_update();
?>