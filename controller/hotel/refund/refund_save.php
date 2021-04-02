<?php 
include_once('../../../model/model.php');
include_once('../../../model/hotel/hotel_booking_refund.php');
include_once('../../../model/app_settings/transaction_master.php');
include_once('../../../model/app_settings/bank_cash_book_master.php');

$hotel_booking_refund = new hotel_booking_refund;
$hotel_booking_refund->hotel_refund_save();
?>