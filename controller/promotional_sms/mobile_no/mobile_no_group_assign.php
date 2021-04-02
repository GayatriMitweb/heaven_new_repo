<?php 
include_once('../../../model/model.php');
include_once('../../../model/promotional_sms/mobile_no.php');

$mobile_no = new mobile_no;
$mobile_no->mobile_no_group_assign();
?>