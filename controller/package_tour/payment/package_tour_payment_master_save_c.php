<?php 
include "../../../model/model.php"; 
include "../../../model/package_tour/payment.php";
include "../../../model/package_tour/booking/booking_save.php";  
include_once('../../../model/app_settings/transaction_master.php');
include_once('../../../model/app_settings/bank_cash_book_master.php');

$payment = new payment();
$payment->package_tour_payment_master_save();
?>
