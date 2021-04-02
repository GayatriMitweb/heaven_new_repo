<?php
$flag = true;
class quotation_request_master_save{
public function quotation_request_save()
{	
	$enquiry_id = $_POST['enquiry_id'];
	$quotation_for = $_POST['quotation_for'];
	$city_name = $_POST['city_name'];
	$city_name=implode(',' , $city_name);
	$city_id_arr = $_POST['city_id_arr'];
	$city_id_arr = implode(',',$city_id_arr);
	$tour_type = $_POST['tour_type'];
	$quotation_date = $_POST['quotation_date'];
	$airport_pickup = $_POST['airport_pickup'];
	$cab_type = $_POST['cab_type'];
	$transfer_type = $_POST['transfer_type'];
	$enquiry_specification = $_POST['enquiry_specification'];
	$vehicle_name = $_POST['vehicle_name'];
	$vehicle_type = $_POST['vehicle_type'];
	$branch_admin_id = $_POST['branch_admin_id'];
	$emp_id = $_POST['emp_id'];

	$dynamic_fields = $_POST['dynamic_fields'];
	$dynamic_tbl = $_POST['dynamic_tbl'];
	$excursion_specification = $_POST['excursion_specification'];

	$dynamic_fields = json_encode($dynamic_fields);
	$dynamic_tbl = json_encode($dynamic_tbl);

	if($quotation_for=="Hotel"){
		$hotel_entries = $dynamic_tbl;
		$dmc_entries = "";
		$transport_entries = "";
	}
	else if($quotation_for=="DMC"){
		$hotel_entries = "";
		$dmc_entries = $dynamic_tbl;
		$transport_entries = "";
	}
	else if($quotation_for=="Transport"){
		$hotel_entries = "";
		$dmc_entries = "";
		$transport_entries = $dynamic_tbl;
	}

	$quotation_date = get_date_db($quotation_date);

	$created_at = date('Y-m-d H:i:s');

	begin_t();

	$sq_max = mysql_fetch_assoc(mysql_query("select max(request_id) as max from vendor_request_master"));
	$request_id = $sq_max['max']+1;
	$enquiry_specification = addslashes($enquiry_specification);
	$excursion_specification = addslashes($excursion_specification);
	$sq_request = mysql_query("insert into vendor_request_master(request_id, enquiry_id, emp_id, quotation_for,city_id,vendor_city_id, branch_admin_id, tour_type, quotation_date, airport_pickup, cab_type, transfer_type, enquiry_specification, dynamic_fields, hotel_entries, dmc_entries, transport_entries, excursion_specification, created_at) values ('$request_id', '$enquiry_id', '$emp_id', '$quotation_for','$city_name','$city_id_arr', '$branch_admin_id', '$tour_type', '$quotation_date', '$airport_pickup', '$cab_type', '$transfer_type', '$enquiry_specification', '$dynamic_fields', '$hotel_entries', '$dmc_entries', '$transport_entries', '$excursion_specification', '$created_at')");
	if($sq_request){
		if($GLOBALS['flag']){
			commit_t();
			$this->email_send($request_id,$enquiry_id);
			echo "Request has been successfully send.";
			exit;
		}
		else{
			rollback_t();
		}
	}
	else{
		echo "error--Sorry, Quotation Request not sent!";
		rollback_t();		
		exit;
	}

}

public function email_send($request_id,$enquiry_id)
{	
	global $encrypt_decrypt, $secret_key;
	$sq_request = mysql_fetch_assoc(mysql_query("select * from vendor_request_master where request_id='$request_id'"));

	$quotation_for = $sq_request['quotation_for'];
	$date = $sq_request['created_at'];
    $yr = explode("-", $date);
    $year = $yr[0];

	if($quotation_for=="Hotel"){
			$to_arr = array();
			$vendor_name_arr = array();
			$vendor_address_arr = array();
			$contact_person_arr = array();
			$supplier_id_arr = array();

			$sq_hotel = mysql_query("select * from hotel_master where hotel_id in($sq_request[city_id])");

			while($row_dmc = mysql_fetch_assoc($sq_hotel)){
				$email_id = $encrypt_decrypt->fnDecrypt($row_dmc['email_id'], $secret_key);
				array_push($to_arr,$email_id);
				array_push($vendor_name_arr,$row_dmc['hotel_name']);
				array_push($vendor_address_arr,$row_dmc['hotel_address']);
				array_push($contact_person_arr,$row_dmc['contact_person_name']);
				array_push($supplier_id_arr,$row_dmc['hotel_id']);
			}
		$link = 'hotel_quotation_reply.php';	 
	    $this->quotation_mail($sq_request, $quotation_for, $to_arr, $vendor_name_arr, $vendor_address_arr, $contact_person_arr, $supplier_id_arr, $link, $request_id,$enquiry_id,$year);
	 }

	if($quotation_for=="DMC"){
		$to_arr = array();
		$vendor_name_arr = array();
		$vendor_address_arr = array();
		$contact_person_arr = array();
		$supplier_id_arr = array();
		$sq_dmc = mysql_query("select * from dmc_master where dmc_id in($sq_request[city_id])");
		while($row_dmc = mysql_fetch_assoc($sq_dmc)){
			$email_id = $encrypt_decrypt->fnDecrypt($row_dmc['email_id'], $secret_key);
			array_push($to_arr,$email_id);
			array_push($vendor_name_arr,$row_dmc['company_name']);
			array_push($vendor_address_arr,$row_dmc['dmc_address']);
			array_push($contact_person_arr,$row_dmc['contact_person_name']);
			array_push($supplier_id_arr,$row_dmc['dmc_id']);

		}
		$link = 'dmc_quotation_reply.php';
		$this->quotation_mail($sq_request, $quotation_for, $to_arr, $vendor_name_arr, $vendor_address_arr, $contact_person_arr, $supplier_id_arr, $link, $request_id,$enquiry_id,$year);
	}

	if($quotation_for=="Transport"){
		 	$supplier_id_arr = array();
			$to_arr = array();
			$vendor_name_arr = array();
			$vendor_address_arr = array();
			$contact_person_arr = array();
			
			$sq_dmc1 = mysql_query("select * from transport_agency_master where transport_agency_id in($sq_request[city_id])");
			while($row_dmc1 = mysql_fetch_assoc($sq_dmc1)){
				$email_id = $encrypt_decrypt->fnDecrypt($row_dmc1['email_id'], $secret_key);
				array_push($to_arr,$email_id);
				array_push($vendor_name_arr,$row_dmc1['transport_agency_name']);
				array_push($vendor_address_arr,$row_dmc1['transport_agency_address']);
				array_push($contact_person_arr,$row_dmc1['contact_person_name']);
				array_push($supplier_id_arr,$row_dmc1['transport_agency_id']);
			}
			$link = 'transport_quotation_reply.php';	
			$this->quotation_mail($sq_request, $quotation_for, $to_arr, $vendor_name_arr, $vendor_address_arr, $contact_person_arr, $supplier_id_arr, $link, $request_id,$enquiry_id,$year);	
        }
}
public function quotation_mail($sq_request, $quotation_for, $to, $vendor_name, $vendor_address, $contact_person_name, $supplier_id_arr, $link, $request_id,$enquiry_id,$year)
{
	global $app_name, $app_address, $theme_color;
	$sq_request1 = mysql_fetch_assoc(mysql_query("select * from vendor_request_master where request_id='$request_id'"));
	$quotation_for = $sq_request1['quotation_for'];
	$booker_id=$sq_request1['emp_id']; 
	$row=mysql_fetch_assoc(mysql_query("select emp_id,first_name, last_name from emp_master where emp_id='$booker_id'"));
	$booker_id = $row['emp_id'];
	$first_name=$row['first_name'];
	$last_name=$row['last_name'];
	$booker_name = $first_name." ".$last_name;
	$booker_name  = ($booker_id == 0)?'Admin':$booker_name;



	//////////////////////

	$request_id = base64_encode($request_id);
	$count = 0;
	$enqDetails = mysql_fetch_assoc(mysql_query("SELECT enquiry_content from enquiry_master where enquiry_id = '$enquiry_id'"));
	$enqDynamic = json_decode($enqDetails['enquiry_content']);
	$dynamic_fields = json_decode($sq_request1['dynamic_fields']);
	$hotel_dynamic = json_decode($sq_request1['dmc_entries']);
	foreach($enqDynamic as $val){
		switch($val->name){
			case "tour_name" : {$t_place = $val->value;}break;
			case "travel_from_date" : {$t_from = $val->value;} break;
			case "travel_to_date" : {$t_to = $val->value;}break;
			case "hotel_type" : {$hotel_type1 = $val->value;}break;
			case "total_adults" : {$total_eadults = $val->value;}break;
			case "total_childrens" : {$total_echilds = $val->value;}break;
			case "total_infants" : {$total_einfants = $val->value;}break;
		}
	}
	
	foreach($dynamic_fields as $val){
		switch($val->name){
			case "total_adults" : {$t_adult = $val->value;}break;
			case "total_childrens" : {$t_children = $val->value;} break;
			case "total_infants" : {$t_infant = $val->value;}break;
			case "vehicle_type" : {$vehicle_type = $val->value;}break;
		}
	}
	
    for($i=0;$i<sizeof($to);$i++)
	{	
	####################Array Declaration
	$hotel_type = array();$checkin = array(); $checkout = array();$total_rooms = array();$room_cat = array();$meal_plan =array();
	####################
	$supplier_id = base64_encode($supplier_id_arr[$i]);
	if($quotation_for == "DMC"){
		foreach($hotel_dynamic as $val){
			switch($val->name){
				case "dmc_id" : {
					array_push($hotel_type,$val->value);
				}break;
				case "checkin_date" : {
					array_push($checkin,$val->value);
				} break;
				case "checkout_date" : {
					array_push($checkout ,$val->value);
				}break;
				case "total_rooms" : {
					array_push($total_rooms , $val->value);
				}break;
				case "room_cat1" : {
					array_push($room_cat , $val->value);
				} break;
				case "meal_plan" : {
					array_push($meal_plan , $val->value);
				}break;
			}
		}
		$content = '
		<tr>
			<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
				<tr><td style="text-align:left;border: 1px solid #888888; width:50%">Destination Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$t_place.'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Travel From Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.$t_from .'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Travel To Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.$t_to.'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Airport Pickup?</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_request1[airport_pickup].'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Cab Type</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_request1[cab_type].'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Transfer Type</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_request1[transfer_type].'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Enquiry Specification</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_request1[enquiry_specification].'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Excursion</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_request1[excursion_specification].'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Passenger</td>   <td style="text-align:left;border: 1px solid #888888;">'.$t_adult.' Adult(s),'.$t_children.' Child(ren),'.$t_infant.' Infant(s)</td></tr>
			</table>
		</tr>
		';
		for($j=0; $j<sizeof($hotel_type);$j++){
			$content .= '<tr>
			<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
				<tr><th style="text-align:center;border: 1px solid #888888;" colspan=2>Hotel Preference</th></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;width:50%">Hotel Type</td>   <td style="text-align:left;border: 1px solid #888888;">'.$hotel_type[$j].'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Check-In</td>   <td style="text-align:left;border: 1px solid #888888;">'.get_date_user($checkin[$j]).'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Check-Out</td>   <td style="text-align:left;border: 1px solid #888888;">'.get_date_user($checkout[$j]).'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Total Room(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$total_rooms[$j] .'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Room Category</td>   <td style="text-align:left;border: 1px solid #888888;">'.$room_cat[$j].'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Meal Plan</td>   <td style="text-align:left;border: 1px solid #888888;">'.$meal_plan[$j] .'</td></tr>
			</table>
		</tr>
		';
		}
		
	}
	else if($quotation_for == "Hotel"){
		$content = '
		<tr>
			<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
				<tr><td style="text-align:left;border: 1px solid #888888;">Airport Pickup?</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_request1[airport_pickup].'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Cab Type</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_request1[cab_type].'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Enquiry Specification</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_request1[enquiry_specification].'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Passenger</td>   <td style="text-align:left;border: 1px solid #888888;">'.$t_adult.' Adult(s),'.$t_children.' Child(ren),'.$t_infant.' Infant(s)</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Hotel Preference</td>   <td style="text-align:left;border: 1px solid #888888;">'.$hotel_type1.'</td></tr>
			</table>
		</tr>
		';
	}
	else if($quotation_for == "Transport"){
		$content = '
		<tr>
			<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
				<tr><td style="text-align:left;border: 1px solid #888888;">Travel From Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.get_date_user($t_from) .'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Travel To Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.get_date_user($t_to).'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Vehicle Type</td>   <td style="text-align:left;border: 1px solid #888888;">'.$vehicle_type.'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Total Passengers</td>   <td style="text-align:left;border: 1px solid #888888;">'.$total_eadults.' Adult(s),'.$total_echilds.' Child(ren),'.$total_einfants.' Infant(s)</td></tr>
			</table>
		</tr>
		';
	}
	$content .= '
  <tr>
	<td colspan="2" style="padding-top:20px">
		<a style="margin:0px auto;margin-top:10px;font-weight:500;font-size:12px;display:block;color:#ffffff;background:'.$theme_color.';text-decoration:none;padding:5px 10px;border-radius:25px;width:95px;text-align:center" href="'.BASE_URL.'view/vendor/quotation_request/reply/'.$link.'?request='.$request_id.'&supplier='.$supplier_id.'&enquiry_id='.$enquiry_id.'" target="_blank">Quick Reply</a>
	</td>
</tr>
	';
	$subject = 'New quotation request : (Enquiry ID : '.get_enquiry_id($enquiry_id,$year).' )';
	global $model;
	$model->app_email_send('23',$vendor_name[$i],$to[$i], $content,$subject);
 }
}
}

?>