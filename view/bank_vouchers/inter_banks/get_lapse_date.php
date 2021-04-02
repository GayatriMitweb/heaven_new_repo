<?php 
include "../../../model/model.php";
$trans_type= $_POST['trans_type'];
$ins_date= $_POST['ins_date'];

$ins_date = get_date_db($ins_date);
if($ins_date!=''){
	if($trans_type == 'DD' || $trans_type == 'Cheque'){
		//Get Date after 3 months of Instrument date 
	   	$lapse_date = strtotime ('3 months',strtotime($ins_date));
		$lapse_date1 = date('d-m-Y',$lapse_date);
		echo $lapse_date1;
	}
	else{
		
	}
}
?>