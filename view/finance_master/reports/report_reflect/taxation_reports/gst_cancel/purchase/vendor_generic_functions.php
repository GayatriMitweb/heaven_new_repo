<?php 
function get_vendor_name($vendor_type, $vendor_type_id)
{
	if($vendor_type=="Hotel Vendor"){
		$sq_hotel = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$vendor_type_id'"));
		$vendor_type_val = $sq_hotel['hotel_name'];
	}	
	if($vendor_type=="Transport Vendor"){
		$sq_transport = mysql_fetch_assoc(mysql_query("select * from transport_agency_master where transport_agency_id='$vendor_type_id'"));
		$vendor_type_val = $sq_transport['transport_agency_name'];
	}	
	if($vendor_type=="Car Rental Vendor"){
		$sq_cra_rental_vendor = mysql_fetch_assoc(mysql_query("select * from car_rental_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_val = $sq_cra_rental_vendor['vendor_name'];
	}
	if($vendor_type=="DMC Vendor"){
		$sq_dmc_vendor = mysql_fetch_assoc(mysql_query("select * from dmc_master where dmc_id='$vendor_type_id'"));
		$vendor_type_val = $sq_dmc_vendor['company_name'];
	}
	if($vendor_type=="Visa Vendor"){
		$sq_visa_vendor = mysql_fetch_assoc(mysql_query("select * from visa_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_val = $sq_visa_vendor['vendor_name'];
	}
	if($vendor_type=="Passport Vendor"){
		$sq_passport_vendor = mysql_fetch_assoc(mysql_query("select * from passport_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_val = $sq_passport_vendor['vendor_name'];
	}
	if($vendor_type=="Ticket Vendor"){
		$sq_vendor = mysql_fetch_assoc(mysql_query("select * from ticket_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_val = $sq_vendor['vendor_name'];
	}
	if($vendor_type=="Train Ticket Vendor"){
		$sq_vendor = mysql_fetch_assoc(mysql_query("select * from train_ticket_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_val = $sq_vendor['vendor_name'];
	}
	if($vendor_type=="Excursion Vendor"){
		$sq_vendor = mysql_fetch_assoc(mysql_query("select * from site_seeing_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_val = $sq_vendor['vendor_name'];
	}
	if($vendor_type=="Insuarance Vendor"){
		$sq_vendor = mysql_fetch_assoc(mysql_query("select * from insuarance_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_val = $sq_vendor['vendor_name'];
	}
	if($vendor_type=="Other Vendor"){
		$sq_vendor = mysql_fetch_assoc(mysql_query("select * from other_vendors where vendor_id='$vendor_type_id'"));
		$vendor_type_val = $sq_vendor['vendor_name'];
	}
	if($vendor_type=="Cruise Vendor"){
		$sq_vendor = mysql_fetch_assoc(mysql_query("select * from cruise_master where cruise_id='$vendor_type_id'"));
		$vendor_type_val = $sq_vendor['company_name'];
	}

	return $vendor_type_val;
}

function get_service_info($estimate_type)
{
	if($estimate_type=="Group Tour"){
		$sq_hotel = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Group Tour'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}	
	if($estimate_type=="Excursion Booking"){
		$sq_hotel = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Excursion'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}	
	if($estimate_type=="Forex Booking"){
		$sq_hotel = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Forex'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}
	if($estimate_type=="Passport Booking"){
		$sq_hotel = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Passport'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}
	if($estimate_type=="Car Rental"){
		$sq_hotel = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Car Rental'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}
	if($estimate_type=="Passport Vendor"){
		$sq_hotel = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Group Tour'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}
	if($estimate_type=="Bus Booking"){
		$sq_hotel = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Bus'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}
	if($estimate_type=="Hotel Booking"){
		$sq_hotel = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Hotel / Accommodation'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}
	if($estimate_type=="Visa Booking"){
		$sq_hotel = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Visa'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}
	if($estimate_type=="Package Tour"){
		$sq_hotel = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Package Tour'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}
	if($estimate_type=="Train Ticket Booking"){
		$sq_hotel = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Train'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}
	if($estimate_type=="Ticket Booking"){
		$sq_hotel = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Flight'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}
	if($estimate_type=="Miscellaneous Booking"){
		$sq_hotel = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Miscellaneous'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}
	if($estimate_type=="Other Expense"){
		$sq_hotel = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Other Expense'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}

	return $vendor_type_val;
}

function get_vendor_info($vendor_type, $vendor_type_id)
{
	$vendor_type_arr = array();
	if($vendor_type=="Hotel Vendor"){
		$sq_hotel = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$vendor_type_id'"));
		$vendor_type_arr[0] = $sq_hotel['service_tax_no'];
		$vendor_type_arr[1] = $sq_hotel['state_id'];
	}	
	if($vendor_type=="Transport Vendor"){
		$sq_transport = mysql_fetch_assoc(mysql_query("select * from transport_agency_master where transport_agency_id='$vendor_type_id'"));
		$vendor_type_arr[0] = $sq_transport['service_tax_no'];
		$vendor_type_arr[1] = $sq_transport['state_id'];
	}	
	if($vendor_type=="Car Rental Vendor"){
		$sq_cra_rental_vendor = mysql_fetch_assoc(mysql_query("select * from car_rental_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_arr[0] = $sq_cra_rental_vendor['service_tax_no'];
		$vendor_type_arr[1] = $sq_cra_rental_vendor['state_id'];
	}
	if($vendor_type=="DMC Vendor"){
		$sq_dmc_vendor = mysql_fetch_assoc(mysql_query("select * from dmc_master where dmc_id='$vendor_type_id'"));
		$vendor_type_arr[0] = $sq_dmc_vendor['service_tax_no'];
		$vendor_type_arr[1] = $sq_dmc_vendor['state_id'];
	}
	if($vendor_type=="Visa Vendor"){
		$sq_visa_vendor = mysql_fetch_assoc(mysql_query("select * from visa_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_arr[0] = $sq_visa_vendor['service_tax_no'];
		$vendor_type_arr[1] = $sq_visa_vendor['state_id'];
	}
	if($vendor_type=="Passport Vendor"){
		$sq_passport_vendor = mysql_fetch_assoc(mysql_query("select * from passport_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_arr[0] = $sq_passport_vendor['service_tax_no'];
		$vendor_type_arr[1] = $sq_passport_vendor['state_id'];
	}
	if($vendor_type=="Ticket Vendor"){
		$sq_vendor = mysql_fetch_assoc(mysql_query("select * from ticket_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_arr[0] = $sq_vendor['service_tax_no'];
		$vendor_type_arr[1] = $sq_vendor['state_id'];
	}
	if($vendor_type=="Train Ticket Vendor"){
		$sq_vendor = mysql_fetch_assoc(mysql_query("select * from train_ticket_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_arr[0] = $sq_vendor['service_tax_no'];
		$vendor_type_arr[1] = $sq_vendor['state_id'];
	}
	if($vendor_type=="Excursion Vendor"){
		$sq_vendor = mysql_fetch_assoc(mysql_query("select * from site_seeing_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_arr[0] = $sq_vendor['service_tax_no'];
		$vendor_type_arr[1] = $sq_vendor['state_id'];
	}
	if($vendor_type=="Insuarance Vendor"){
		$sq_vendor = mysql_fetch_assoc(mysql_query("select * from insuarance_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_arr[0] = $sq_vendor['service_tax_no'];
		$vendor_type_arr[1] = $sq_vendor['state_id'];
	}
	if($vendor_type=="Other Vendor"){
		$sq_vendor = mysql_fetch_assoc(mysql_query("select * from other_vendors where vendor_id='$vendor_type_id'"));
		$vendor_type_arr[0] = $sq_vendor['service_tax_no'];
		$vendor_type_arr[1] = $sq_vendor['state_id'];
	}
	if($vendor_type=="Cruise Vendor"){
		$sq_vendor = mysql_fetch_assoc(mysql_query("select * from cruise_master where cruise_id='$vendor_type_id'"));
		$vendor_type_arr[0] = $sq_vendor['service_tax_no'];
		$vendor_type_arr[1] = $sq_vendor['state_id'];
	}

	return array('service_tax'=>$vendor_type_arr[0],'state_id'=>$vendor_type_arr[1]);
}

?>