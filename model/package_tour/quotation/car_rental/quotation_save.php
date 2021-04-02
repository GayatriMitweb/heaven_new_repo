<?php 
class quotation_save{

public function quotation_master_save()
{
	$enquiry_id = $_POST['enquiry_id'];
	$login_id = $_POST['login_id'];
	$emp_id = $_POST['emp_id'];
	$customer_name = $_POST['customer_name'];
	$email_id = $_POST['email_id'];
    $mobile_no = $_POST['mobile_no'];
    $total_pax = $_POST['total_pax'];
    $days_of_traveling = $_POST['days_of_traveling'];
	$traveling_date =  $_POST['traveling_date'];
	$travel_type =  $_POST['travel_type'];
	$places_to_visit =  $_POST['places_to_visit'];
	$vehicle_name =  $_POST['vehicle_name'];
	$from_date =  $_POST['from_date'];
	$to_date = $_POST['to_date'];
	
	$route =  $_POST['route'];
	$extra_km_cost =  $_POST['extra_km_cost'];
	$extra_hr_cost =  $_POST['extra_hr_cost'];
	$daily_km =  $_POST['daily_km'];		
	$subtotal =  $_POST['subtotal'];
	$markup_cost =  $_POST['markup_cost'];
	$markup_cost_subtotal =  $_POST['markup_cost_subtotal'];
	$taxation_id =  $_POST['taxation_id'];
	$service_charge =  $_POST['service_charge'];
	$service_tax_subtotal =  $_POST['service_tax_subtotal'];
	$permit =  $_POST['permit'];
	$toll_parking =  $_POST['toll_parking'];
	$driver_allowance =  $_POST['driver_allowance'];
	$total_tour_cost =  $_POST['total_tour_cost'];
	$quotation_date  = $_POST['quotation_date'];
	$branch_admin_id = $_POST['branch_admin_id'];
	$financial_year_id = $_POST['financial_year_id'];
	$total_hr = $_POST['total_hr'];
	$total_km = $_POST['total_km'];
	$rate = $_POST['rate'];
	$total_max_km = $_POST['total_max_km'];
	$state_entry = $_POST['state_entry'];
	$other_charge = $_POST['other_charge'];
	$capacity= $_POST['capacity'];
	$local_places_to_visit = $_POST['local_places_to_visit'];
	$roundoff = $_POST['roundoff'];

	$bsmValues = json_decode(json_encode($_POST['bsmValues']));
  	foreach($bsmValues[0] as $key => $value){
      switch($key){
		case 'basic' : $subtotal = ($value != "") ? $value : $subtotal;break;
		case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
		case 'markup' : $markup_cost = ($value != "") ? $value : $markup_cost;break;
      }
    }

	$enquiry_content = '[{"name":"total_pax","value":"'.$total_pax.'"},{"name":"days_of_traveling","value":"'.$days_of_traveling.'"},{"name":"traveling_date","value":"'.$traveling_date.'"},{"name":"vehicle_type","value":"'.$vehicle_type.'"},{"name":"travel_type","value":"'.$travel_type.'"},{"name":"budget","value":"0"},{"name":"places_to_visit","value":"'.$places_to_visit.'"}]';

	$traveling_date = get_date_db($traveling_date);	
	$quotation_date = get_date_db($quotation_date);
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$created_at = date('Y-m-d');
	 
	$customer_name = addslashes($customer_name);
	$sq_max = mysql_fetch_assoc(mysql_query("select max(quotation_id) as max from car_rental_quotation_master"));
	$quotation_id = $sq_max['max']+1;
    $bsmValues = json_encode($bsmValues);
	$places_to_visit = addslashes($places_to_visit);
	$local_places_to_visit = addslashes($local_places_to_visit);
	$q = "insert into car_rental_quotation_master ( quotation_id, enquiry_id, login_id,emp_id, branch_admin_id,financial_year_id, customer_name,email_id,mobile_no, total_pax,days_of_traveling,traveling_date,travel_type,places_to_visit,vehicle_name,from_date,to_date,route,extra_km_cost,extra_hr_cost,daily_km,subtotal,markup_cost,markup_cost_subtotal,taxation_id,service_charge,service_tax_subtotal,permit,toll_parking,driver_allowance,total_tour_cost,created_at,quotation_date,total_hrs,total_km,rate,total_max_km,state_entry,other_charge,capacity,local_places_to_visit,bsm_values,roundoff) values ('$quotation_id','$enquiry_id','$login_id','$emp_id', '$branch_admin_id','$financial_year_id', '$customer_name','$email_id','$mobile_no', '$total_pax','$days_of_traveling','$traveling_date','$travel_type','$places_to_visit','$vehicle_name','$from_date','$to_date','','$extra_km_cost','$extra_hr_cost','$daily_km','$subtotal','$markup_cost','$markup_cost_subtotal','$taxation_id','$service_charge','$service_tax_subtotal','$permit','$toll_parking','$driver_allowance','$total_tour_cost','$created_at','$quotation_date','$total_hr','$total_km','$rate','$total_max_km','$state_entry','$other_charge','$capacity','$local_places_to_visit','$bsmValues','$roundoff')";
	
	$sq_quotation = mysql_query($q);

	if($sq_quotation){
		 
		////////////Enquiry Save///////////
		if($enquiry_id == 0){
			$sq_max_id = mysql_fetch_assoc(mysql_query("select max(enquiry_id) as max from enquiry_master"));
			$enquiry_id1 = $sq_max_id['max']+1;
			$sq_enquiry = mysql_query("insert into enquiry_master (enquiry_id, login_id,branch_admin_id,financial_year_id, enquiry_type,enquiry, name, mobile_no, landline_no, email_id,location, assigned_emp_id, enquiry_specification, enquiry_date, followup_date, reference_id, enquiry_content ) values ('$enquiry_id1', '$login_id', '$branch_admin_id','$financial_year_id', 'Car Rental','Strong', '$customer_name', '$mobile_no', '', '$email_id','', '$emp_id','', '$quotation_date', '$quotation_date', '', '$enquiry_content')");
			if($sq_enquiry){
				$sq_quot_update = mysql_query("update car_rental_quotation_master set enquiry_id='$enquiry_id1' where quotation_id='$quotation_id'");
			}

			$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from enquiry_master_entries"));
			$entry_id = $sq_max['max'] + 1;
			$sq_followup = mysql_query("insert into enquiry_master_entries(entry_id, enquiry_id, followup_reply,  followup_status,  followup_type, followup_date, followup_stage, created_at) values('$entry_id', '$enquiry_id1', '', 'Active','', '$quotation_date','Strong', '$quotation_date')");
			$sq_entryid = mysql_query("update enquiry_master set entry_id='$entry_id' where enquiry_id='$enquiry_id1'");
		}

		/////////////Enquiry Save End///////////////
		echo "Quotation has been successfully saved.";
		exit;
	}
	else{
		echo "error--Quotation not saved!";
		exit;
	}

}
public function quotation_whatsapp(){
	$quotation_id = $_POST['quotation_id'];

	$currency = "Rs.";
	global $app_name, $app_cancel_pdf,$model,$quot_note,$app_contact_no;
	
	$all_message = "";
	$sq_quotation = mysql_fetch_assoc(mysql_query("select * from car_rental_quotation_master where quotation_id='$quotation_id'"));
	
	$mobile_no = mysql_fetch_assoc(mysql_query("SELECT landline_no FROM `enquiry_master` WHERE enquiry_id = ".$sq_quotation['enquiry_id']));
	$sq_login = mysql_fetch_assoc(mysql_query("select * from roles where id='$sq_quotation[login_id]'"));
	$sq_emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_login[emp_id]'"));

	if($sq_login['emp_id'] == 0){
		$contact = $app_contact_no;
	}
	else{
		$contact = $sq_emp_info['mobile_no'];
	}
	

	$whatsapp_msg = rawurlencode('Hello Dear '.$sq_quotation['customer_name'].',
Hope you are doing great. This is car on rent quotation details as per your request. We look forward to having you onboard with us.
*Route* : '.$sq_quotation['route'].'
*Duration* : '.$sq_quotation['days_of_traveling'].' Days
*Cost* : '.$currency.$sq_quotation['total_tour_cost'].'

Please contact for more details : '.$contact.'
Thank you.');
	$all_message .=$whatsapp_msg;
	$link = 'https://web.whatsapp.com/send?phone='.$mobile_no['landline_no'].'&text='.$all_message;
	echo $link;
}
}
?>
 