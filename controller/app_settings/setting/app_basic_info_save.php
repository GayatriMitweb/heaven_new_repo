<?php 
include_once('../../../model/model.php');
include_once('../../../model/app_settings/app_settings_master.php');

$app_settings_master = new app_settings_master;
$app_settings_master->app_basic_info_save();
?>