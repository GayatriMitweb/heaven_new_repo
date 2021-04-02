<?php 
include "../../model/model.php"; 
include "../../model/insuarance_vendor/insuarance_vendor_master.php"; 
include "../../model/vendor_login/vendor_login_master.php";
include_once('../../model/app_settings/transaction_master.php');

$insuarance_vendor_master = new insuarance_vendor_master;
$insuarance_vendor_master->vendor_save();
?>