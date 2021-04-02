<?php 
include "../../model/model.php"; 
include "../../model/group_tour/branch_mgt.php"; 

$branch_mgt = new branch_mgt();
$branch_mgt->branch_mgt_save();
?>