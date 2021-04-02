<?php 
include "../../../model/model.php";
include "../../../model/group_tour/traveler_cancelation_and_refund.php";
include_once('../../../model/app_settings/transaction_master.php');
include_once('../../../model/app_settings/bank_cash_book_master.php');

$traveler_cancelation_and_refund = new traveler_cancelation_and_refund();
$traveler_cancelation_and_refund->refund_canceled_traveler_save();
?>