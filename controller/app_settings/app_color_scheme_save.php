<?php 
include_once('../../model/model.php');
include_once('../../model/app_settings/app_color_scheme.php');

$app_color_scheme = new app_color_scheme();
$app_color_scheme->app_color_scheme_save();
?>