<?php 
include_once('../../model/model.php');
include_once('../../model/miscellaneous/miscellaneous_master.php');
 
$misc_whatsapp = new miscellaneous_master;
$misc_whatsapp->whatsapp_send();
?>