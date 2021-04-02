<?php 
include "../../model/model.php"; 
include "../../model/hotel/hotel_master.php";
include "../../model/vendor_login/vendor_login_master.php";
include_once('../../model/app_settings/transaction_master.php');

$hotel_master = new hotel_master();
$hotel_master->vendor_csv_save();
?>