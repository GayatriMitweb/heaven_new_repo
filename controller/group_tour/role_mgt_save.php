<?php 
include "../../model/model.php"; 
include "../../model/group_tour/role_mgt.php"; 

$role_mgt = new role_mgt();
$role_mgt->role_mgt_save();
?>