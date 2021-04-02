<?php 
include_once('../../../model/model.php');
include_once('../../../model/vendor/quotation_request/quotation_request_master_update.php');

$quotation_request_master_update = new quotation_request_master_update;
$quotation_request_master_update->quotation_request_update();
?>