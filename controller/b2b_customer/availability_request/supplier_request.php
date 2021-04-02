<?php
include "../../../model/model.php";
include "../../../model/b2b_customer/availability_request/availability_request.php";

$b2b_request = new b2b_request(); 
$b2b_request->request_mail_toSupplier();
?>