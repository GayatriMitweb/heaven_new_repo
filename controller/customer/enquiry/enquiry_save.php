<?php 
include_once('../../../model/model.php');
include_once('../../../model/customer/enquiry_master.php');

$enquiry_master = new enquiry_master;
$enquiry_master->enquiry_save();
?>