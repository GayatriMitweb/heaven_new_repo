<?php 
include_once('../../../model/model.php');
include_once('../../../model/visa_password_ticket/train_ticket/ticket_payment_master.php');


$ticket_whatsapp_send = new ticket_payment_master;
$ticket_whatsapp_send->whatsapp_send();
?> 