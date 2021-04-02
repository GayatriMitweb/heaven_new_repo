<?php 
include_once('../../model/model.php');
include_once('../../model/passport_id_info_save.php');

$passport_info_save = new passport_info;
$passport_info_save->passport_info_save();
?>