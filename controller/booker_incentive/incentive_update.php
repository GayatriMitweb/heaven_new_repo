<?php 
include_once('../../model/model.php');
include_once('../../model/booker_incentive/incentive.php');
include_once('../../model/app_settings/transaction_master.php');
include_once('../../model/app_settings/bank_cash_book_master.php');

$incentive = new incentive;
$incentive->update();
?>