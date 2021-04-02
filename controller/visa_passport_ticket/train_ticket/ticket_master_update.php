<?php 
include_once('../../../model/model.php');
include_once('../../../model/visa_password_ticket/train_ticket/ticket_master/ticket_update.php');
include_once('../../../model/app_settings/transaction_master.php');

$ticket_update = new ticket_update;
$ticket_update->ticket_master_update();
?>