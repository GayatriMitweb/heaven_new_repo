<?php 
include_once('../../../model/model.php');
include_once('../../../model/b2b_settings/cms/cms_master.php');

$cms_master = new cms_master;
$cms_master->delete();
?>