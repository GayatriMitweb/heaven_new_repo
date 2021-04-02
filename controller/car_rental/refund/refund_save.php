<?php 
include_once('../../../model/model.php');
include_once('../../../model/car_rental/refund_booking.php');
include_once('../../../model/app_settings/transaction_master.php');
include_once('../../../model/app_settings/bank_cash_book_master.php');

$refund_booking = new refund_booking;
$refund_booking->refund_booking_save();
?>