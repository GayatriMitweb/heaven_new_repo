<?php 
class quotation_update{

public function quotation_master_update()
{
	$quotation_id = $_POST['quotation_id'];
	$enquiry_id = $_POST['enquiry_id'];
	$customer_name = $_POST['customer_name'];
    $email_id = $_POST['email_id'];
    $mobile_no = $_POST['mobile_no'];
	$quotation_date =  $_POST['quotation_date'];
	$subtotal =  $_POST['subtotal'];
	$markup_cost =  $_POST['markup_cost'];
	$markup_cost_subtotal =  $_POST['markup_cost_subtotal'];
	$service_tax =  $_POST['service_tax'];
	$service_charge =  $_POST['service_charge'];		
	$total_tour_cost =  $_POST['total_tour_cost'];

	$roundoff = $_POST['roundoff'];

	$bsmValues = json_decode(json_encode($_POST['bsmValues']));
  	foreach($bsmValues[0] as $key => $value){
      switch($key){
		case 'basic' : $subtotal = ($value != "") ? $value : $subtotal;break;
		case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
		case 'markup' : $markup_cost = ($value != "") ? $value : $markup_cost;break;
      }
    }
 
	//Plane
	$from_city_id_arr = $_POST['from_city_id_arr'];
	$to_city_id_arr = $_POST['to_city_id_arr'];
    $from_sector_arr = $_POST['from_sector_arr'];
	$to_sector_arr = $_POST['to_sector_arr'];
	$total_adult_arr = $_POST['total_adult_arr'];
	$total_child_arr = $_POST['total_child_arr'];
	$total_infant_arr = $_POST['total_infant_arr'];
    $airline_name_arr = $_POST['airline_name_arr'];
    $plane_class_arr = $_POST['plane_class_arr'];
    $arraval_arr = $_POST['arraval_arr'];
    $dapart_arr = $_POST['dapart_arr'];
    $plane_id_arr = $_POST['plane_id_arr'];
 
	$quotation_date = get_date_db($quotation_date);
	$travel_datetime = get_datetime_db($travel_datetime);
	$bsmValues = json_encode($bsmValues);
	$query = "UPDATE flight_quotation_master SET enquiry_id ='$enquiry_id', customer_name='$customer_name', email_id='$email_id', mobile_no='$mobile_no', subtotal = '$subtotal',markup_cost='$markup_cost',markup_cost_subtotal='$markup_cost_subtotal', service_tax = '$service_tax', service_charge = '$service_charge', quotation_cost = '$total_tour_cost', quotation_date='$quotation_date', roundoff = '$roundoff',bsm_values='$bsmValues'  WHERE quotation_id = '$quotation_id'";
	$sq_quotation = mysql_query($query);

	if($sq_quotation){
		$this->plane_entries_update($quotation_id,$from_city_id_arr, $to_city_id_arr,  $from_sector_arr, $to_sector_arr, $plane_class_arr,$airline_name_arr, $arraval_arr, $dapart_arr, $plane_id_arr,$total_adult_arr,$total_child_arr , $total_infant_arr);
		echo "Quotation has been successfully updated.";	
		exit;
	}
	else{
		echo "error--Quotation not updated!";
		exit;
	}

}

public function plane_entries_update($quotation_id,$from_city_id_arr, $to_city_id_arr,  $from_sector_arr, $to_sector_arr, $plane_class_arr,$airline_name_arr, $arraval_arr, $dapart_arr, $plane_id_arr,$total_adult_arr,$total_child_arr , $total_infant_arr)
{
	for($i=0; $i<sizeof($from_city_id_arr); $i++){
			$arraval_arr[$i] = date('Y-m-d H:i:s', strtotime($arraval_arr[$i]));
			$dapart_arr[$i] = date('Y-m-d H:i:s', strtotime($dapart_arr[$i]));
			$from_location = array_slice(explode(' - ', $from_sector_arr[$i]), 1);
			$from_location = implode(' - ',$from_location);
			$to_location = array_slice(explode(' - ', $to_sector_arr[$i]), 1);
			$to_location = implode(' - ',$to_location);
			if($plane_id_arr[$i]=="")
			{
				$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from flight_quotation_plane_entries"));
				$id = $sq_max['max']+1;
				
				$sq_plane = mysql_query("INSERT INTO flight_quotation_plane_entries ( id, quotation_id,  from_city, from_location, to_city, to_location,airline_name, class, total_adult,total_child , total_infant,arraval_time, dapart_time) VALUES ( '$id', '$quotation_id', '$from_city_id_arr[$i]', '$from_location', '$to_city_id_arr[$i]', '$to_location','$airline_name_arr[$i]', '$plane_class_arr[$i]', '$total_adult_arr[$i]','$total_child_arr[$i]' , '$total_infant_arr[$i]','$arraval_arr[$i]', '$dapart_arr[$i]' )");
				if(!$sq_plane)
				{
					echo "record not inserted.";
					exit;
				}
			}else
			{
				$sq_update=mysql_query("UPDATE `flight_quotation_plane_entries` SET `from_location`='$from_location',`to_location`='$to_location',airline_name='$airline_name_arr[$i]',`class`='$plane_class_arr[$i]',`total_adult`='$total_adult_arr[$i]',`total_child` = '$total_child_arr[$i]' , `total_infant` = '$total_infant_arr[$i]',`arraval_time`='$arraval_arr[$i]',`dapart_time`='$dapart_arr[$i]', from_city='$from_city_id_arr[$i]', to_city='$to_city_id_arr[$i]' WHERE `id`='$plane_id_arr[$i]'");
				
				if(!$sq_update)
				{
					echo "record not updated";
					exit;
				}
			}
	}

}
}
?>