<?php 
include "../../model/model.php"; 
include "../../model/visa_master/visa_master_save.php"; 

$visa_master = new visa_master(); 
$visa_master->visa_master_save();
?>