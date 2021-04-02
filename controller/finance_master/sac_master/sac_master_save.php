<?php 
include_once('../../../model/model.php');
include_once('../../../model/finance_master/sac_master/sac_master.php');

$sac_master = new sac_master;
$sac_master->sac_master_save();
?>