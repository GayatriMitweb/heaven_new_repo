<?php 
include_once('../../../model/model.php');
include_once('../../../model/excursion/exc_cancel.php');

$exc_cancel = new exc_cancel;
$exc_cancel->exc_cancel_save();
?>