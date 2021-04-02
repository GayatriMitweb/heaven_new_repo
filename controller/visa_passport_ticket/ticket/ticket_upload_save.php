<?php 
include_once('../../../model/model.php');
include_once('../../../model/visa_password_ticket/ticket/ticket_upload_master.php');

$ticket_upload_master = new ticket_upload_master;
$ticket_upload_master->ticket_upload_save();
?>