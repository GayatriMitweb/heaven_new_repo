<?php 
include "../../model/model.php"; 
include "../../model/cruise/cruise_master.php";
include "../../model/vendor_login/vendor_login_master.php"; 
include_once('../../model/app_settings/transaction_master.php');

$cruise_master = new cruise_master(); 
$cruise_master->cruise_save();
?>