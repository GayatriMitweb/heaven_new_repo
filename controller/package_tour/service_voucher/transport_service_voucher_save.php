<?php 
include_once('../../../model/model.php');
include_once('../../../model/package_tour/service_voucher/transport_service_voucher.php');

$transport_service_voucher = new transport_service_voucher;
$transport_service_voucher->transport_service_voucher_save();
?>