<?php 
include_once('../../model/model.php');
include_once('../../model/excursion/exc_service_voucher.php');

$exc_service_voucher = new exc_service_voucher;
$exc_service_voucher->exc_service_voucher_save();
?>