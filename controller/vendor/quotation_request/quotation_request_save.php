<?php 
include_once('../../../model/model.php');
include_once('../../../model/vendor/quotation_request/quotation_request_master_save.php');

$quotation_request_master_save = new quotation_request_master_save;
$quotation_request_master_save->quotation_request_save();
?>