<?php
include_once('../model.php');
 
 	$due_date=date('Y-m-d');
	 global $secret_key,$encrypt_decrypt;
 	$sq_vendor = mysql_num_rows(mysql_query("select * from vendor_estimate where due_date='$due_date' and status!='Cancel'"));

 	if($sq_vendor > 0){

	 	$sq_vendor_details =  mysql_query("select * from vendor_estimate where due_date='$due_date' and status!='Cancel'");

	 	while($row_vendor=mysql_fetch_assoc($sq_vendor_details)){

	 	$estimate_id = $row_vendor['estimate_id'];
	 	$total_cost = $row_vendor['net_total'];
	 	$vendor_type = $row_vendor['vendor_type'];
	 	$estimate_type = $row_vendor['estimate_type'];
	 	$vendor_type_id = $row_vendor['vendor_type_id'];

	   $sq_total_paid =  mysql_query("select sum(payment_amount) as sum from vendor_payment_master where vendor_type='$vendor_type' and vendor_type_id='$vendor_type_id'");

	   while($row_paid=mysql_fetch_assoc($sq_total_paid)){

	   $paid_amount = $row_paid['sum'];

	   $payment_remain = $total_cost - $paid_amount;

	   if($vendor_type=="Hotel Vendor"){
		$sq_hotel = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$vendor_type_id'"));
		$vendor_name = $sq_hotel['hotel_name'];
		}	
		if($vendor_type=="Transport Vendor"){
			$sq_transport = mysql_fetch_assoc(mysql_query("select * from transport_agency_master where transport_agency_id='$vendor_type_id'"));
			$vendor_name = $sq_transport['transport_agency_name'];
		}	
		if($vendor_type=="Car Rental Vendor"){
			$sq_cra_rental_vendor = mysql_fetch_assoc(mysql_query("select * from car_rental_vendor where vendor_id='$vendor_type_id'"));
			$vendor_name = $sq_cra_rental_vendor['vendor_name'];
		}
		if($vendor_type=="DMC Vendor"){
			$sq_dmc_vendor = mysql_fetch_assoc(mysql_query("select * from dmc_master where dmc_id='$vendor_type_id'"));
			$vendor_name = $sq_dmc_vendor['company_name'];
		}
		if($vendor_type=="Visa Vendor"){
			$sq_visa_vendor = mysql_fetch_assoc(mysql_query("select * from visa_vendor where vendor_id='$vendor_type_id'"));
			$vendor_name = $sq_visa_vendor['vendor_name'];
		}
		if($vendor_type=="Passport Vendor"){
			$sq_passport_vendor = mysql_fetch_assoc(mysql_query("select * from passport_vendor where vendor_id='$vendor_type_id'"));
			$vendor_name = $sq_passport_vendor['vendor_name'];
		}
		if($vendor_type=="Ticket Vendor"){
			$sq_vendor = mysql_fetch_assoc(mysql_query("select * from ticket_vendor where vendor_id='$vendor_type_id'"));
			$vendor_name = $sq_vendor['vendor_name'];
		}
		if($vendor_type=="Train Ticket Vendor"){
			$sq_vendor = mysql_fetch_assoc(mysql_query("select * from train_ticket_vendor where vendor_id='$vendor_type_id'"));
			$vendor_name = $sq_vendor['vendor_name'];
		}
		if($vendor_type=="Itinerary Vendor"){
			$sq_vendor = mysql_fetch_assoc(mysql_query("select * from site_seeing_vendor where vendor_id='$vendor_type_id'"));
			$vendor_name = $sq_vendor['vendor_name'];
		}
		if($vendor_type=="Insuarance Vendor"){
			$sq_vendor = mysql_fetch_assoc(mysql_query("select * from insuarance_vendor where vendor_id='$vendor_type_id'"));
			$vendor_name = $sq_vendor['vendor_name'];
		}
		if($vendor_type=="Other Vendor"){
			$sq_vendor = mysql_fetch_assoc(mysql_query("select * from other_vendors where vendor_id='$vendor_type_id'"));
			$vendor_name = $sq_vendor['vendor_name'];
		}


	    if($payment_remain > 0){
   		$sq_count = mysql_num_rows(mysql_query("SELECT * from  remainder_status where remainder_name = 'vendor_payment_pending_remainder' and date='$due_date' and status='Done'"));
		if($sq_count==0)
		{
	       vendor_payment_remainder_mail($payment_remain, $estimate_id, $estimate_type, $vendor_type, $vendor_name );
	    }
	  }
   	}
  }
}
$row=mysql_query("SELECT max(id) as max from remainder_status");
$value=mysql_fetch_assoc($row);
$max=$value['max']+1;
$sq_check_status=mysql_query("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','vendor_payment_pending_remainder','$due_date','Done')");

 function vendor_payment_remainder_mail($payment_remain, $estimate_id, $estimate_type, $vendor_type, $vendor_name )
	{
		global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;
		$sq_customer = mysql_fetch_assoc(mysql_query("select *from customer_master where customer_id='$cust_id'"));
		
		$email_id = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key);
		$content = '
		<tr>
            <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
              <tr><td style="text-align:left;border: 1px solid #888888;">Vendor name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$vendor_name.'</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;">Vendor Type</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$vendor_type.'</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;"> Total payment Remain</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '. $payment_remain.'</td></tr>
            </table>
          </tr>';
		$subject = 'Vendor Payment Reminder (Purchase ID :'.$estimate_id.' ).';
		global $model;
		$model->app_email_send('92',"Admin",$app_email_id, $content , $subject);
		 
	}

?>