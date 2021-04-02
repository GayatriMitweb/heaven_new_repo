<?php 
include_once('../../../model/model.php');
include_once('../../../model/package_tour/service_voucher/hotel_service_voucher.php');

$hotel_service_voucher = new hotel_service_voucher;
$hotel_service_voucher->package_service_voucher_save();
?>