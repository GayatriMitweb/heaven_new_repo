<?php 
include_once('../../../../model/model.php');
include_once('../../../../model/visa_password_ticket/visa/vendor_master.php');
include_once("../../../../model/vendor_login/vendor_login_master.php");

$vendor_master = new vendor_master;
$vendor_master->vendor_save();
?>