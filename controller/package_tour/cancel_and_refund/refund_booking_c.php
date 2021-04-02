<?php 
include "../../../model/model.php"; 
include "../../../model/package_tour/cancel_and_refund/refund_booking.php"; 
include_once('../../../model/app_settings/transaction_master.php');
include_once('../../../model/app_settings/bank_cash_book_master.php');

$refund_booking = new refund_booking();
$refund_booking->refund_canceled_traveler_save();
?>