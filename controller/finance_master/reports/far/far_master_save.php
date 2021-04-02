<?php 
include_once('../../../../model/model.php');
include_once('../../../../model/finance_master/reports/far/far_master.php');

$far_master = new far_master;
$far_master->far_master_save();
?>