<?php
include "../../../model/model.php";
include_once('../../../model/b2b_customer/refund/b2b_booking_refund.php');
include_once('../../../model/app_settings/transaction_master.php');
include_once('../../../model/app_settings/bank_cash_book_master.php');


$b2b_refund = new b2b_refund(); 
$b2b_refund->refund_save();
?>