<?php 
include "../../../model/model.php";
include "../../../model/hotel/booking_master.php";
include "../../../model/hotel/payment_master.php";
include_once('../../../model/app_settings/transaction_master.php');
include_once('../../../model/app_settings/bank_cash_book_master.php');

$booking_master = new booking_master();
$booking_master->booking_save();
?>