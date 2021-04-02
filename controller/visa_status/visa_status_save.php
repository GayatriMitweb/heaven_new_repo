<?php 
include_once('../../model/model.php');
include_once('../../model/visa_status/visa_status_save.php');

$visa_status_save = new visa_status;
$visa_status_save->visa_status_save();
?>