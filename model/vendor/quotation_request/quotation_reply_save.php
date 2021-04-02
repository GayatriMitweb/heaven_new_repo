<?php 
$flag = true;
class quotation_reply_master_save{

public function quotation_reply_save()
{	

	$transport_cost = $_POST['transport_cost'];
	$total_cost = $_POST['total_cost'];
	$enquiry_spec = $_POST['enquiry_spec'];
	$request_id = $_POST['request_id'];
	$supplier_id = $_POST['supplier_id'];
	$created_by = $_POST['created_by'];
	$currency_code = $_POST['currency_code'];
	$enquiry_id =$_POST['enquiry_id'];

	$created_at = date('Y-m-d');
	$currency_name = mysql_fetch_assoc(mysql_query("select default_currency from currency_name_master where id=".$currency_code));
	begin_t();
	$sq_count = mysql_num_rows(mysql_query("select * from vendor_reply_master where request_id='$request_id' and supplier_id='$supplier_id' and quotation_for='Transport Vendor' "));
	if($sq_count!=0){
		echo "Quotation reply already send!!!";
	}
	else{
	$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from vendor_reply_master"));
	$id = $sq_max['max']+1;
	$enquiry_spec = addslashes($enquiry_spec);
	$sq_request = mysql_query("insert into vendor_reply_master(id,request_id, quotation_for, supplier_id, transport_cost, total_cost, currency_code, enquiry_spec , created_at,created_by,enquiry_id) values ('$id','$request_id', 'Transport Vendor', '$supplier_id', '$transport_cost', '$total_cost', '$currency_code', '$enquiry_spec' , '$created_at', '$created_by','$enquiry_id')");
	
	if($sq_request){


		if($GLOBALS['flag']){
			commit_t();
			
			echo "Quotation Reply sent!";
			$this->quotation_reply_email($request_id,$transport_cost,$total_cost,$currency_name['default_currency'],$enquiry_spec,$created_by,$created_at,'Transport','0','0','0',$enquiry_id);
			exit;
		}
		else{
			rollback_t();
		}

	}
	else{
		echo "error--Sorry, Quotation Reply not sent!";
		rollback_t();		
		exit;
	}
 }
}
public function hotel_quotation_reply_save()
{	

	$hotel_cost = $_POST['hotel_cost'];
	$total_cost = $_POST['total_cost'];
	$enquiry_spec = $_POST['enquiry_spec'];
	$request_id = $_POST['request_id'];
	$supplier_id = $_POST['supplier_id'];
	$created_by = $_POST['created_by'];
	$currency_code = $_POST['currency_code'];
	$enquiry_id = $_POST['enquiry_id'];
	$created_at = date('Y-m-d H:i:s');
	begin_t();
	$enquiry_spec = addslashes($enquiry_spec);
	$currency_name = mysql_fetch_assoc(mysql_query("select default_currency from currency_name_master where id=".$currency_code));
	$sq_count = mysql_num_rows(mysql_query("select * from vendor_reply_master where request_id='$request_id' and supplier_id='$supplier_id'and quotation_for='Hotel Vendor' "));
	if($sq_count!=0){
		echo "Quotation reply already send!!!";
	}
	else{
	$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from vendor_reply_master"));
	$id = $sq_max['max']+1;
	$q1 = "insert into vendor_reply_master(id ,request_id, quotation_for, supplier_id, hotel_cost, total_cost, currency_code, enquiry_spec , created_at, created_by,enquiry_id) values ('$id','$request_id', 'Hotel Vendor', '$supplier_id', '$hotel_cost', '$total_cost', '$currency_code', '$enquiry_spec' , '$created_at','$created_by','$enquiry_id')";
	$sq_request = mysql_query($q1);
	if($sq_request){

		if($GLOBALS['flag']){
			commit_t();
			echo "Quotation Reply sent!";
			 $this->quotation_reply_email($request_id,$hotel_cost,$total_cost,$currency_name['default_currency'],$enquiry_spec,$created_by,$created_at,'Hotel','0','0','0',$enquiry_id);
			exit;
		}
		else{
			rollback_t();
		}

	}
	else{
		echo "error--Sorry, Quotation Reply not sent!";
		rollback_t();		
		exit;
	}
	}
}

public function dmc_quotation_reply_save()
{	
	$transport_cost = $_POST['transport_cost'];
	$hotel_cost = $_POST['hotel_cost'];
	$excursion_cost = $_POST['excursion_cost'];
	$visa_cost = $_POST['visa_cost'];
	$total_cost = $_POST['total_cost'];
	$enquiry_spec = $_POST['enquiry_spec'];
	$request_id = $_POST['request_id'];
	$supplier_id = $_POST['supplier_id'];
	$created_by = $_POST['created_by'];
	$currency_code = $_POST['currency_code'];
	$enquiry_id = $_POST['enquiry_id'];
	$created_at = date('Y-m-d H:i:s');

	begin_t();
	$enquiry_spec = addslashes($enquiry_spec);
	$sq_count = mysql_num_rows(mysql_query("select * from vendor_reply_master where request_id='$request_id' and supplier_id='$supplier_id'and quotation_for='DMC Vendor' "));
	$currency_name = mysql_fetch_assoc(mysql_query("select default_currency from currency_name_master where id=".$currency_code));
	if($sq_count!=0){
		echo "Quotation reply already send!!!";
	}
	else{
	$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from vendor_reply_master"));
	$id = $sq_max['max']+1;
	$sq_request = mysql_query("insert into vendor_reply_master(id ,request_id, quotation_for, supplier_id, transport_cost, excursion_cost, visa_cost, hotel_cost, total_cost, currency_code, enquiry_spec , created_at, created_by,enquiry_id) values ('$id','$request_id', 'DMC Vendor', '$supplier_id', '$transport_cost', '$excursion_cost', '$visa_cost', '$hotel_cost', '$total_cost', '$currency_code', '$enquiry_spec' , '$created_at','$created_by','$enquiry_id')");
	if($sq_request){


		if($GLOBALS['flag']){
			commit_t();
			//$this->email_send($request_id);
			echo "Quotation Reply sent!";
		 $this->quotation_reply_email($request_id,$hotel_cost,$total_cost,$currency_name['default_currency'],$enquiry_spec,$created_by,$created_at,'DMC',$transport_cost,$excursion_cost,$visa_cost,$enquiry_id);
			exit;
		}
		else{
			rollback_t();
		}

	}
	else{
		echo "error--Sorry, Quotation Reply not sent!";
		rollback_t();		
		exit;
	}
  }	
}

public function quotation_reply_email($request_id,$hotel_cost,$total_cost,$currency_code,$enquiry_spec,$created_by,$created_at,$for,$transport_cost,$excursion_cost,$visa_cost,$enquiry_id){
  global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;
	$date = $created_at;
	$yr = explode("-", $date);
	$year =$yr[0];
	$transport_cost = ($transport_cost == '')?  0 : $transport_cost;
	$hotel_cost = ($hotel_cost == '')? 0 : $hotel_cost;
	$excursion_cost = ($excursion_cost == '')?  0 : $excursion_cost;
	$visa_cost = ($visa_cost == '')? 0 : $visa_cost;
	$supp_name = '';
	
    if($for=='Transport'){
		$sq_request=mysql_fetch_assoc(mysql_query("select * from vendor_reply_master where request_id='$request_id' "));
		$sq_count = mysql_fetch_assoc(mysql_query("select * from vendor_request_master where request_id='$sq_request[request_id]' "));
		$enq_customer_name = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id = ".$sq_count['enquiry_id']));
	    $supp_name = mysql_fetch_assoc(mysql_query("select transport_agency_name as name from transport_agency_master where transport_agency_id = '$sq_request[supplier_id]'"));
		  $content = '
		  <tr>
		  <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
			<tr><td style="text-align:left;border: 1px solid #888888;">Request ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$request_id.'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Enquiry ID</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$sq_count['enquiry_id'].'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Transport Cost</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_code.' '.$hotel_cost.'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Total Cost</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_code.' '.$total_cost.'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Other Comments</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enquiry_spec.'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.$created_at.'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Created By</td>   <td style="text-align:left;border: 1px solid #888888;">'.$created_by.'</td></tr>
		  </table>
		</tr>
		';

	}
	if($for=='Hotel'){
	   $sq_request=mysql_fetch_assoc(mysql_query("select * from vendor_reply_master where request_id='$request_id' "));
	   $sq_count = mysql_fetch_assoc(mysql_query("select * from vendor_request_master where request_id='$sq_request[request_id]' "));
	   $enq_customer_name = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id = ".$sq_count['enquiry_id']));
	   $supp_name = mysql_fetch_assoc(mysql_query("select hotel_name as name from hotel_master where hotel_id= '$sq_request[supplier_id]'"));
	   $content = '
		<tr>
		  <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
			<tr><td style="text-align:left;border: 1px solid #888888;">Request ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$request_id.'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Enquiry ID</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$sq_count['enquiry_id'].'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Hotel Cost</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_code.' '.$hotel_cost.'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Total Cost</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_code.' '.$total_cost.'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Other Comments</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enquiry_spec.'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.$created_at.'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Created By</td>   <td style="text-align:left;border: 1px solid #888888;">'.$created_by.'</td></tr>
		  </table>
		</tr>
	  ';
	}
	if($for=='DMC'){
		$sq_request=mysql_fetch_assoc(mysql_query("select * from vendor_reply_master where request_id='$request_id' "));
		$sq_count = mysql_fetch_assoc(mysql_query("select * from vendor_request_master where request_id='$sq_request[request_id]' "));
		$enq_customer_name = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id = ".$sq_count['enquiry_id']));
		$supp_name = mysql_fetch_assoc(mysql_query("select company_name as name from dmc_master where dmc_id = '$sq_request[supplier_id]'"));
			  
		  $content = '

		  <tr>
		  <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
			<tr><td style="text-align:left;border: 1px solid #888888;">Request ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$request_id.'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Enquiry ID</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$sq_count['enquiry_id'].'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Transport Cost</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_code.' '.$transport_cost.'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Excursion Cost</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_code.' '.$excursion_cost.'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Visa Cost</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_code.' '.$visa_cost.'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Hotel Cost</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_code.' '.$hotel_cost.'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Total Cost</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_code.' '.$total_cost.'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Other Comments</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enquiry_spec.'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.$created_at.'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Created By</td>   <td style="text-align:left;border: 1px solid #888888;">'.$created_by.'</td></tr>
		  </table>
		</tr>
		  ';
	}
	$subject = "Supplier Quotation Reply ($supp_name[name], $enq_customer_name[name], ".get_enquiry_id($sq_count['enquiry_id'],$year).")";
  	global $model;
  	$model->app_email_send('24',"Admin",$app_email_id, $content,$subject);
}

}

?>