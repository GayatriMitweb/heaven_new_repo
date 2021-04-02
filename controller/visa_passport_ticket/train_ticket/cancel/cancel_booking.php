<?php 
include_once('../../../../model/model.php');
include_once('../../../../model/visa_password_ticket/train_ticket/ticket_cancel.php');

$ticket_cancel = new ticket_cancel;
$ticket_cancel->ticket_cancel_save();
?>