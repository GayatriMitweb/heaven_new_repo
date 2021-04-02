<?php 
include_once('../../../../model/model.php');
include_once('../../../../model/vendor/dashboard/cancel_estimate_master.php');

$cancel_estimate_master = new cancel_estimate_master;
$cancel_estimate_master->cancel_estimate();
?>