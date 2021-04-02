<?php 
include "../../model/model.php";
include "../../model/cms/email_cms_save.php";

$email_cms_save = new email_cms_save();
$email_cms_save->cms_save();
?>