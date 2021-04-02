<?php 
include "../../model/model.php"; 
include "../../model/dmc/dmc_master.php";
include "../../model/vendor_login/vendor_login_master.php";
include_once('../../model/app_settings/transaction_master.php');

$dmc_master = new dmc_master(); 
$dmc_master->dmc_save();
?>