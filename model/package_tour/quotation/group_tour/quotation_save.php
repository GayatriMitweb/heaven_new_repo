<?php 
class quotation_save{

public function quotation_master_save()
{
	$enquiry_id = $_POST['enquiry_id'];
	$login_id = $_POST['login_id'];
	$emp_id = $_POST['emp_id'];
    $tour_name = $_POST['tour_name'];
    $tour_group_id =  $_POST['tour_group_id'];
    $tour_group = $_POST['tour_group'];
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
	$branch_admin_id = $_POST['branch_admin_id'];
	$financial_year_id = $_POST['financial_year_id'];

	$country_code = $_POST['country_code'];
	$mobile_no = $country_code.$_POST['mobile_no'];

	//Train
    $train_from_location_arr = $_POST['train_from_location_arr'];
    $train_to_location_arr = $_POST['train_to_location_arr'];
	$train_class_arr = $_POST['train_class_arr'];
	$train_arrival_date_arr = $_POST['train_arrival_date_arr'];
	$train_departure_date_arr = $_POST['train_departure_date_arr'];

	//Plane
	$from_city_id_arr = $_POST['from_city_id_arr'];
	$to_city_id_arr = $_POST['to_city_id_arr'];
    $plane_from_location_arr = $_POST['plane_from_location_arr'];
    $plane_to_location_arr = $_POST['plane_to_location_arr'];
    $airline_name_arr = $_POST['airline_name_arr'];
    $plane_class_arr = $_POST['plane_class_arr'];
    $arraval_arr = $_POST['arraval_arr'];
    $dapart_arr = $_POST['dapart_arr'];
   	
   	//Cruise
   	$dept_datetime_arr = $_POST['dept_datetime_arr'];
   	$arrival_datetime_arr = $_POST['arrival_datetime_arr'];
   	$route_arr = $_POST['route_arr'];
   	$cabin_arr = $_POST['cabin_arr'];
	$sharing_arr = $_POST['sharing_arr'];

	$bsmValues = json_decode(json_encode($_POST['bsmValues']));
    foreach($bsmValues[0] as $key => $value){
      switch($key){
      case 'basic' : $tour_cost = ($value != "") ? $value : $tour_cost;break;
      case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
      case 'markup' : $markup = ($value != "") ? $value : $markup;break;
      case 'discount' : $discount = ($value != "") ? $value : $discount;break;
      }
	}
	
	$enquiry_content = '[{"name":"tour_name","value":"'.$tour_name.'"},{"name":"travel_from_date","value":"'.$from_date.'"},{"name":"travel_to_date","value":"'.$to_date.'"},{"name":"budget","value":"0"},{"name":"total_adult","value":"'.$total_adult.'"},{"name":"total_children","value":"'.$total_children.'"},{"name":"total_infant","value":"'.$total_infant.'"},{"name":"total_members","value":"'.$total_passangers.'"},{"name":"hotel_type","value":""},{"name":"children_without_bed","value":"'.$children_without_bed.'"},{"name":"children_with_bed","value":"'.$children_with_bed.'"}]';

	$quotation_date = get_date_db($quotation_date);	
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$created_at = date('Y-m-d');
	$quotation_id_arr = array();

	$sq_max = mysql_fetch_assoc(mysql_query("select max(quotation_id) as max from group_tour_quotation_master"));
	$quotation_id = $sq_max['max']+1;
    $quotation_id_arr[$i] = $quotation_id;

    $incl = addslashes($incl);
    $excl = addslashes($excl);
	$terms = addslashes($terms);
	$bsmValues = json_encode($bsmValues);
	$sq_quotation = mysql_query("insert into group_tour_quotation_master ( quotation_id, branch_admin_id,financial_year_id, tour_name, from_date, to_date, total_days, customer_name, email_id, total_adult, total_children, total_infant, total_passangers, children_without_bed, children_with_bed, quotation_date, booking_type,  adult_cost, children_cost , infant_cost, with_bed_cost, tour_cost,service_charge, service_tax_subtotal, quotation_cost, incl, excl, terms, tour_group_id, created_at, login_id, enquiry_id, tour_group,emp_id,bsm_values ) values ( '$quotation_id', '$branch_admin_id','$financial_year_id', '$tour_name', '$from_date', '$to_date', '$total_days', '$customer_name', '$email_id', '$total_adult', '$total_children', '$total_infant', '$total_passangers', '$children_without_bed', '$children_with_bed', '$quotation_date', '$booking_type', '$adult_cost','$children_cost','$infant_cost','$with_bed_cost','$tour_cost','$service_charge', '$service_tax_subtotal', '$total_tour_cost','$incl','$excl','$terms', '$tour_group_id', '$created_at', '$login_id', '$enquiry_id', '$tour_group','$emp_id','$bsmValues' )");

	if($sq_quotation){
		////////////Enquiry Save///////////
		if($enquiry_id == 0){
			$sq_max_id = mysql_fetch_assoc(mysql_query("select max(enquiry_id) as max from enquiry_master"));
			$enquiry_id1 = $sq_max_id['max']+1;
			$sq_enquiry = mysql_query("insert into enquiry_master (enquiry_id, login_id,branch_admin_id,financial_year_id, enquiry_type,enquiry, name, mobile_no, landline_no, email_id,location, assigned_emp_id, enquiry_specification, enquiry_date, followup_date, reference_id, enquiry_content ) values ('$enquiry_id1', '$login_id', '$branch_admin_id','$financial_year_id', 'Group Booking','Strong', '$customer_name', '', '$mobile_no', '$email_id','', '$emp_id', '', '$quotation_date', '$quotation_date', '', '$enquiry_content')");
			if($sq_enquiry){
				$sq_quot_update = mysql_query("update group_tour_quotation_master set enquiry_id='$enquiry_id1' where quotation_id='$quotation_id'");
			}

			$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from enquiry_master_entries"));
			$entry_id = $sq_max['max'] + 1;
			$sq_followup = mysql_query("insert into enquiry_master_entries(entry_id, enquiry_id, followup_reply,  followup_status,  followup_type, followup_date, followup_stage, created_at) values('$entry_id', '$enquiry_id1', '', 'Active','', '$quotation_date','Strong', '$quotation_date')");
			$sq_entryid = mysql_query("update enquiry_master set entry_id='$entry_id' where enquiry_id='$enquiry_id1'");
		}

		/////////////Enquiry Save End///////////////
		$this->train_entries_save($quotation_id, $train_from_location_arr, $train_to_location_arr, $train_class_arr, $train_arrival_date_arr, $train_departure_date_arr);
		$this->plane_entries_save($quotation_id,$from_city_id_arr, $plane_from_location_arr, $to_city_id_arr, $plane_to_location_arr, $plane_class_arr,$airline_name_arr, $arraval_arr, $dapart_arr);
		$this->cruise_entries_save($quotation_id,$dept_datetime_arr, $arrival_datetime_arr, $route_arr, $cabin_arr,$sharing_arr);

		echo "Quotation has been successfully saved.";
		exit;
	}
	else{
		echo "error--Quotation not saved!";
		exit;
	}

}

public function train_entries_save($quotation_id, $train_from_location_arr, $train_to_location_arr, $train_class_arr, $train_arrival_date_arr, $train_departure_date_arr)
{
	for($i=0; $i<sizeof($train_from_location_arr); $i++){

		$train_arrival_date_arr[$i] = date('Y-m-d H:i:s', strtotime($train_arrival_date_arr[$i]));
		$train_departure_date_arr[$i] = date('Y-m-d H:i:s', strtotime($train_departure_date_arr[$i]));

		$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from group_tour_quotation_train_entries"));
		$id = $sq_max['max']+1;

		$sq_train = mysql_query("insert into group_tour_quotation_train_entries ( id, quotation_id, from_location, to_location, class, arrival_date, departure_date ) values ( '$id', '$quotation_id', '$train_from_location_arr[$i]', '$train_to_location_arr[$i]', '$train_class_arr[$i]', '$train_arrival_date_arr[$i]', '$train_departure_date_arr[$i]' )");
		if(!$sq_train){
			echo "error--Train information not saved!";
			exit;
		}
	}

}

public function plane_entries_save($quotation_id, $from_city_id_arr, $plane_from_location_arr, $to_city_id_arr, $plane_to_location_arr, $plane_class_arr,$airline_name_arr, $arraval_arr, $dapart_arr)
{
	for($i=0; $i<sizeof($plane_from_location_arr); $i++){
         //$arraval_arr = get_datetime_db($arraval_arr);
		$arraval_arr[$i] = date('Y-m-d H:i:s', strtotime($arraval_arr[$i]));
		$dapart_arr[$i] = date('Y-m-d H:i:s', strtotime($dapart_arr[$i]));
		$from_location = array_slice(explode(' - ', $plane_from_location_arr[$i]), 1);
		$from_location = implode(' - ',$from_location);
		$to_location = array_slice(explode(' - ', $plane_to_location_arr[$i]), 1);
		$to_location = implode(' - ',$to_location);

		$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from group_tour_quotation_plane_entries"));
		$id = $sq_max['max']+1;

		$sq_plane = mysql_query("insert into group_tour_quotation_plane_entries ( id, quotation_id,from_city, from_location,to_city, to_location,airline_name, class, arraval_time, dapart_time) values ( '$id', '$quotation_id', '$from_city_id_arr[$i]', '$from_location', '$to_city_id_arr[$i]', '$to_location','$airline_name_arr[$i]', '$plane_class_arr[$i]', '$arraval_arr[$i]', '$dapart_arr[$i]' )");
		if(!$sq_plane){
			echo "error--Plane information not saved!";
			exit;
		}


	}

}

public function cruise_entries_save($quotation_id,$dept_datetime_arr, $arrival_datetime_arr, $route_arr, $cabin_arr,$sharing_arr)
{
	for($i=0; $i<sizeof($arrival_datetime_arr); $i++){

		$arrival_datetime_arr[$i] = date('Y-m-d H:i:s', strtotime($arrival_datetime_arr[$i]));
		$dept_datetime_arr[$i] = date('Y-m-d H:i:s', strtotime($dept_datetime_arr[$i]));

		$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from group_tour_quotation_cruise_entries"));
		$id = $sq_max['max']+1;

		$sq_cruise = mysql_query("insert into group_tour_quotation_cruise_entries ( id, quotation_id, dept_datetime, arrival_datetime, route, cabin, sharing ) values ( '$id', '$quotation_id', '$dept_datetime_arr[$i]', '$arrival_datetime_arr[$i]', '$route_arr[$i]', '$cabin_arr[$i]', '$sharing_arr[$i]')");
		if(!$sq_cruise){
			echo "error--Cruise information not saved!";
			exit;
		}
	}

}


}
?>
 