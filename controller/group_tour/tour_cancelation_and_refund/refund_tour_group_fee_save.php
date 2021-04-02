<?php 
include "../../../model/model.php";
include "../../../model/group_tour/tour_cancelation_and_refund.php";
include_once('../../../model/app_settings/transaction_master.php');
include_once('../../../model/app_settings/bank_cash_book_master.php');

$tour_cancelation_and_refund = new tour_cancelation_and_refund();
$tour_cancelation_and_refund->refund_tour_group_fee_save();
?>