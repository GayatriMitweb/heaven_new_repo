<?php 
include "../../model/model.php"; 
include "../../model/other_vendor/other_vendor_master.php";
include "../../model/vendor_login/vendor_login_master.php"; 
include_once('../../model/app_settings/transaction_master.php');

$other_vendor_master = new other_vendor_master(); 
$other_vendor_master->update_vendor();
?>