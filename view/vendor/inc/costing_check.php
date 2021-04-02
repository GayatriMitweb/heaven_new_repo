<?php
include "../../../model/model.php";

$estimate_type = $_POST['estimate_type'];
$estimate_type_id = $_POST['estimate_type_id'];

$sq_estimate_count = mysql_num_rows(mysql_query("select * from vendor_estimate where estimate_type='$estimate_type' and estimate_type_id='$estimate_type_id'"));
	 if($sq_estimate_count > 0){
	  	echo $sq_estimate_count;
	 }
?>        