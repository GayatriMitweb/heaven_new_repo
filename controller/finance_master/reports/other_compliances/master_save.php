<?php 
include_once('../../../../model/model.php');
include_once('../../../../model/finance_master/reports/other_compliances/master_save.php');

$save_master = new save_master;
$save_master->master_save();
?>