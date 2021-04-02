<?php 
include_once('../../../model/model.php');
include_once('../../../model/miscellaneous/visa_cancel.php');

$visa_cancel = new miscellaneous_cancel;
$visa_cancel->miscellaneous_cancel_save();
?>