<?php 
include "../../../model/model.php"; 
include "../../../model/package_tour/booking/booking_save.php"; 
include "../../../model/package_tour/booking/booking_save_transaction.php"; 
include "../../../model/package_tour/payment.php";
include_once('../../../model/app_settings/transaction_master.php');
include_once('../../../model/app_settings/bank_cash_book_master.php');

$booking_save = new booking_save();
$booking_save->package_tour_booking_master_save();
?>