<?php 
include_once('../../model/model.php');
include_once('../../model/b2b_settings/basic_info_save.php');

$basic_info = new basic_info_master;
$basic_info->basic_info_save();
?>