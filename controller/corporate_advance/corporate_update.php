<?php 
include_once('../../model/model.php');
include_once('../../model/corporate_advance/advance_master.php');
include_once('../../model/app_settings/transaction_master.php');
include_once('../../model/app_settings/bank_cash_book_master.php');

$advance_master = new advance_master();
$advance_master->advance_update();
?>