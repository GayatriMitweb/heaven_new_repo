<?php 
class quotation_update{

public function quotation_master_update()
{
	$quotation_id = $_POST['quotation_id'];
	$enquiry_id = $_POST['enquiry_id'];
	$tour_name = $_POST['tour_name'];
	$tour_name =  $_POST['tour_name'];
	$from_date =  $_POST['from_date'];
	$to_date =  $_POST['to_date'];
	$total_days =  $_POST['total_days'];
	$customer_name =  $_POST['customer_name'];
	$email_id =  $_POST['email_id'];
	$total_adult = $_POST['total_adult'];
	$total_children =  $_POST['total_children'];
	$total_infant =  $_POST['total_infant'];
	$total_passangers =  $_POST['total_passangers'];
	$children_without_bed =  $_POST['children_without_bed'];
	$children_with_bed =  $_POST['children_with_bed'];		
	$quotation_date =  $_POST['quotation_date'];
	$booking_type =  $_POST['booking_type'];
	$adult_cost =  $_POST['adult_cost'];
	$children_cost =  $_POST['children_cost'];
	$infant_cost =  $_POST['infant_cost'];
	$with_bed_cost =  $_POST['with_bed_cost'];
	$tour_cost =  $_POST['tour_cost'];
	$markup_cost =  $_POST['markup_cost'];
	$service_charge =  $_POST['service_charge'];
	$service_tax =  $_POST['service_tax'];
	$taxation_id =  $_POST['taxation_id'];
	$service_tax_subtotal =  $_POST['service_tax_subtotal'];
	$total_tour_cost =  $_POST['total_tour_cost'];
	$incl = $_POST['incl'];
	$excl = $_POST['excl'];
	$terms = $_POST['terms'];

	//Train
    $train_from_location_arr = $_POST['train_from_location_arr'];
    $train_to_location_arr = $_POST['train_to_location_arr'];
	$train_class_arr = $_POST['train_class_arr'];
	$train_arrival_date_arr = $_POST['train_arrival_date_arr'];
	$train_departure_date_arr = $_POST['train_departure_date_arr'];
	$train_id_arr = $_POST['train_id_arr'];

	//Plane
	$from_city_id_arr = $_POST['from_city_id_arr'];
	$to_city_id_arr = $_POST['to_city_id_arr'];
    $plane_from_location_arr = $_POST['plane_from_location_arr'];
    $plane_to_location_arr = $_POST['plane_to_location_arr'];
    $airline_name_arr = $_POST['airline_name_arr'];
    $plane_class_arr = $_POST['plane_class_arr'];
    $arraval_arr = $_POST['arraval_arr'];
    $dapart_arr = $_POST['dapart_arr'];
    $plane_id_arr = $_POST['plane_id_arr'];
   	
   	//Cruise
   	$dept_datetime_arr = $_POST['dept_datetime_arr'];
   	$arrival_datetime_arr = $_POST['arrival_datetime_arr'];
   	$route_arr = $_POST['route_arr'];
   	$cabin_arr = $_POST['cabin_arr'];
   	$sharing_arr = $_POST['sharing_arr'];
	$c_entry_id_arr = $_POST['c_entry_id_arr'];
	   
 	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$quotation_date1 = get_date_db($quotation_date);
	$bsmValues = json_decode(json_encode($_POST['bsmValues']));
    foreach($bsmValues[0] as $key => $value){
      switch($key){
      case 'basic' : $tour_cost = ($value != "") ? $value : $tour_cost;break;
      case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
      case 'markup' : $markup = ($value != "") ? $value : $markup;break;
      case 'discount' : $discount = ($value != "") ? $value : $discount;break;
      }
	}
	$incl = addslashes($incl);
    $excl = addslashes($excl);
	$terms = addslashes($terms);
	$bsmValues = json_encode($bsmValues);
	$query = "update group_tour_quotation_master set tour_name = '$tour_name', from_date = '$from_date', to_date = '$to_date', total_days = '$total_days', customer_name = '$customer_name', email_id='$email_id', total_adult = '$total_adult', total_children = '$total_children', total_infant = '$total_infant', total_passangers = '$total_passangers', children_without_bed = '$children_without_bed', children_with_bed = '$children_with_bed', quotation_date='$quotation_date1', booking_type = '$booking_type', adult_cost = '$adult_cost', children_cost = '$children_cost', infant_cost = '$infant_cost', with_bed_cost = '$with_bed_cost', tour_cost = '$tour_cost',service_charge ='$service_charge', service_tax_subtotal = '$service_tax_subtotal', quotation_cost = '$total_tour_cost', incl= '$incl', excl= '$excl', terms= '$terms', enquiry_id= '$enquiry_id',bsm_values='$bsmValues' where quotation_id = '$quotation_id'";
	$sq_quotation = mysql_query($query);

	if($sq_quotation){
		$this->train_entries_update($quotation_id, $train_from_location_arr, $train_to_location_arr, $train_class_arr, $train_arrival_date_arr, $train_departure_date_arr, $train_id_arr);
		$this->plane_entries_update($quotation_id, $from_city_id_arr, $to_city_id_arr, $plane_from_location_arr, $plane_to_location_arr, $plane_class_arr,$airline_name_arr, $arraval_arr, $dapart_arr, $plane_id_arr);
		$this->cruise_entries_save($quotation_id,$dept_datetime_arr, $arrival_datetime_arr, $route_arr, $cabin_arr,$sharing_arr,$c_entry_id_arr);
		echo "Quotation has been successfully updated.";	
		exit;
	}
	else{
		echo "error--Quotation not updated!";
		exit;
	}

}

public function train_entries_update($quotation_id, $train_from_location_arr, $train_to_location_arr, $train_class_arr, $train_arrival_date_arr, $train_departure_date_arr, $train_id_arr)
{
	for($i=0; $i<sizeof($train_from_location_arr); $i++){

		$train_arrival_date_arr[$i] = date('Y-m-d H:i:s', strtotime($train_arrival_date_arr[$i]));
		$train_departure_date_arr[$i] = date('Y-m-d H:i:s', strtotime($train_departure_date_arr[$i]));

		if($train_id_arr[$i] != ""){
			$sq_train = mysql_query("update group_tour_quotation_train_entries set from_location='$train_from_location_arr[$i]', to_location='$train_to_location_arr[$i]', class='$train_class_arr[$i]', arrival_date='$train_arrival_date_arr[$i]', departure_date='$train_departure_date_arr[$i]' where id='$train_id_arr[$i]' ");
			if(!$sq_train){
				echo "error--Train information not updated!";
				exit;
			}
		}
		else{
			$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from group_tour_quotation_train_entries"));
			$id = $sq_max['max']+1;

			$sq_train = mysql_query("insert into group_tour_quotation_train_entries ( id, quotation_id, from_location, to_location, class, arrival_date, departure_date ) values ( '$id', '$quotation_id', '$train_from_location_arr[$i]', '$train_to_location_arr[$i]', '$train_class_arr[$i]', '$train_arrival_date_arr[$i]', '$train_departure_date_arr[$i]' )");
			if(!$sq_train){
				echo "error--Train information not saved!";
				exit;
			}
		}
	}
}

public function plane_entries_update($quotation_id, $from_city_id_arr, $to_city_id_arr,  $plane_from_location_arr, $plane_to_location_arr, $plane_class_arr,$airline_name_arr, $arraval_arr, $dapart_arr, $plane_id_arr)
{
	for($i=0; $i<sizeof($plane_from_location_arr); $i++){
			$arraval_arr[$i] = date('Y-m-d H:i:s', strtotime($arraval_arr[$i]));
			$dapart_arr[$i] = date('Y-m-d H:i:s', strtotime($dapart_arr[$i]));
			$from_location = array_slice(explode(' - ', $plane_from_location_arr[$i]), 1);
			$from_location = implode(' - ',$from_location);
			$to_location = array_slice(explode(' - ', $plane_to_location_arr[$i]), 1);
			$to_location = implode(' - ',$to_location);
			if($plane_id_arr[$i]=="")
			{
				$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from group_tour_quotation_plane_entries"));
				$id = $sq_max['max']+1;

				$sq_plane = mysql_query("insert into group_tour_quotation_plane_entries ( id, quotation_id, from_city, from_location, to_city, to_location,airline_name, class, arraval_time, dapart_time) values ( '$id', '$quotation_id', '$from_city_id_arr[$i]', '$from_location', '$to_city_id_arr[$i]', '$to_location','$airline_name_arr[$i]', '$plane_class_arr[$i]', '$arraval_arr[$i]', '$dapart_arr[$i]' )");
				if(!$sq_plane)
				{
					echo "record not inserted.";
					exit;
				}
			}else
			{
				$sq_update=mysql_query("UPDATE `group_tour_quotation_plane_entries` SET `from_location`='$from_location',`to_location`='$to_location',airline_name='$airline_name_arr[$i]',`class`='$plane_class_arr[$i]',`arraval_time`='$arraval_arr[$i]',`dapart_time`='$dapart_arr[$i]' , from_city='$from_city_id_arr[$i]', to_city='$to_city_id_arr[$i]' WHERE `id`='$plane_id_arr[$i]'");
				if(!$sq_update)
				{
					echo "record not updated";
					exit;
				}
			}
	}

}

public function cruise_entries_save($quotation_id,$dept_datetime_arr, $arrival_datetime_arr, $route_arr, $cabin_arr,$sharing_arr,$c_entry_id_arr)
{
	for($i=0; $i<sizeof($arrival_datetime_arr); $i++){

		$arrival_datetime_arr[$i] = date('Y-m-d H:i:s', strtotime($arrival_datetime_arr[$i]));
		$dept_datetime_arr[$i] = date('Y-m-d H:i:s', strtotime($dept_datetime_arr[$i]));

		if($c_entry_id_arr[$i]=="")
		{
			$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from group_tour_quotation_cruise_entries"));
			$id = $sq_max['max']+1;

			$sq_cruise = mysql_query("insert into group_tour_quotation_cruise_entries ( id, quotation_id, dept_datetime, arrival_datetime, route, cabin, sharing ) values ( '$id', '$quotation_id', '$dept_datetime_arr[$i]', '$arrival_datetime_arr[$i]', '$route_arr[$i]', '$cabin_arr[$i]', '$sharing_arr[$i]')");
			if(!$sq_cruise){
				echo "error--Cruise information not saved!";
				exit;
			}
		}
		else
		{
			$sq_update=mysql_query("UPDATE `group_tour_quotation_cruise_entries` SET `dept_datetime`='$dept_datetime_arr[$i]',`arrival_datetime`='$arrival_datetime_arr[$i]',route='$route_arr[$i]',`cabin`='$cabin_arr[$i]',`sharing`='$sharing_arr[$i]' WHERE `id`='$c_entry_id_arr[$i]'");
				if(!$sq_update)
				{
					echo "Record not updated";
					exit;
				}
		}
	}

}

}
?>