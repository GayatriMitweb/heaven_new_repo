<?php 
include "../../../model/model.php";
include "../../../model/group_tour/booking_payment.php";
include_once('../../../model/app_settings/transaction_master.php');
include_once('../../../model/app_settings/bank_cash_book_master.php');

$booking_payment = new booking_payment();
$booking_payment->save_payment_details();
?>