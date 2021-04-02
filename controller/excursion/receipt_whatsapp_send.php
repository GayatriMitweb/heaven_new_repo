<?php 
include_once('../../model/model.php');
include_once('../../model/excursion/exc_payment_master.php');


$exc_whatsapp = new exc_payment_master;
$exc_whatsapp->whatsapp_send();
?> 