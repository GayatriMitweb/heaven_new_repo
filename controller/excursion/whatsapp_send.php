<?php 
include_once('../../model/model.php');
include_once('../../model/excursion/exc_master.php');


$exc_whatsapp = new exc_master;
$exc_whatsapp->whatsapp_send();
?>