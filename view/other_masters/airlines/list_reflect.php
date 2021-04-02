<?php include_once("../../../model/model.php");
$count = 0;
$array_s = array();
$temp_arr = array();
$query = "select * from airline_master";
$sq_airline = mysql_query($query);
while($row_airline=mysql_fetch_assoc($sq_airline)){
	$count++;
	 $bg = ($row_airline['active_flag']=="Inactive") ? "danger" : "";
	$airline_id =  $row_airline['airline_id'];
	$airline = $row_airline['airline_name'];
	$airline_code = $row_airline['airline_code'];
	$status = $row_airline['active_flag'];
		$temp_arr = array( "data" => array(
					  (int)($airline_id),
					  $airline,$airline_code,
					  $status,
					  '<button data-toggle="tooltip" class="btn btn-info btn-sm" onclick="update_modal('. $row_airline[airline_id] .')" title="Update Details"><i class="fa fa-pencil-square-o"></i></button>'), "bg" => $bg
					);
		array_push($array_s,$temp_arr); 
   }
   //print_r($array_s);
echo json_encode($array_s);
?>