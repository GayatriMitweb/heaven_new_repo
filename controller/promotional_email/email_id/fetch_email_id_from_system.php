<?php 
include_once('../../../model/model.php');
include_once('../../../model/promotional_email/email_id.php');

$email_id = new email_id;
$email_id->fetch_email_id_from_system();
?>