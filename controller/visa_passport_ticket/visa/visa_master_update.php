<?php 
include_once('../../../model/model.php');
include_once('../../../model/visa_password_ticket/visa/visa_master.php');
include_once('../../../model/app_settings/transaction_master.php');

$visa_master = new visa_master;
$visa_master->visa_master_update();
?>