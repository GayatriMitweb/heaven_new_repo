<?php 
include_once('../../../model/model.php');
include_once('../../../model/vendor/quotation_request/quotation_reply_save.php');

$quotation_reply_master_save = new quotation_reply_master_save;
$quotation_reply_master_save->quotation_reply_save();
?>