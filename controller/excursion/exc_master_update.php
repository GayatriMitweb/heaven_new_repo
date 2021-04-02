<?php 
include_once('../../model/model.php');
include_once('../../model/excursion/exc_master.php');
include_once('../../model/app_settings/transaction_master.php');

$exc_master = new exc_master;
$exc_master->exc_master_update();
?>