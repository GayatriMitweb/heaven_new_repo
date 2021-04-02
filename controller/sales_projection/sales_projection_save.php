<?php
 include "../../model/model.php"; 
include "../../model/sales_projection/sales_projection_master.php"; 

$sales_projection_master = new sales_projection_master;
$sales_projection_master->sales_projection_save();
?>