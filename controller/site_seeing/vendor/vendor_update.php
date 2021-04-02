<?php 
include "../../../model/model.php"; 
include "../../../model/site_seeing/vendor_master.php"; 
include "../../../model/vendor_login/vendor_login_master.php";
include_once('../../../model/app_settings/transaction_master.php');

$vendor_master = new vendor_master;
$vendor_master->vendor_update();
?>