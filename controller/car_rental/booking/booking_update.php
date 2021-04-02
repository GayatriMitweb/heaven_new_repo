<?php 
include_once('../../../model/model.php');
include_once('../../../model/car_rental/booking_master.php');
include_once('../../../model/app_settings/transaction_master.php');

$booking_master = new booking_master;
$booking_master->booking_update();
?>