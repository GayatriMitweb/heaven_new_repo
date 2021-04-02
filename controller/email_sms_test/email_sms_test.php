<?php 
include "../../model/model.php"; 
include "../../model/email_sms_test/email_sms_test.php"; 

$enquiry_master = new test(); 
$enquiry_master->send();
?>