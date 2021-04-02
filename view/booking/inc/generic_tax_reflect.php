<?php 
include "../../../../model/model.php"; 

$taxation_id = $_POST['taxation_id'];
if($taxation_id==0){
	echo "0";
	exit;
}

$sq_taxation = mysql_fetch_assoc(mysql_query("select * from taxation_master where taxation_id='$taxation_id'"));

echo $sq_taxation['tax_in_percentage'];
exit;
?>