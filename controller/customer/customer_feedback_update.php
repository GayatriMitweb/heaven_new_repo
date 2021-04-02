<?php 
include_once('../../model/model.php');
include_once('../../model/customer/feedback_master.php');

$feedback_master = new feedback_master;
$feedback_master->feedback_update();
?>