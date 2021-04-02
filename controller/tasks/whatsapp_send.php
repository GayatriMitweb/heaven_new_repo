<?php 
include_once('../../model/model.php');
include_once('../../model/tasks_master.php');

$tasks_whatsapp = new tasks_master;
$tasks_whatsapp->whatsapp_send();
?>