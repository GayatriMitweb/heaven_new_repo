<?php 
$flag = true;
class vendor_bid_master{

public function vendor_bid_save()
{
	$entry_id = $_POST['entry_id1'];
	$bid_amount = $_POST['bid_amount'];
	$vendor_specification = $_POST['vendor_specification'];
	$vendor_name = $_SESSION['username'];
	$email = $_SESSION['email'];
	$service_arr = $_POST['service_arr'];
	$description_arr = $_POST['description_arr'];
	$amount_arr = $_POST['amount_arr'];
	$entry_id_arr = $_POST['entry_id_arr'];

	begin_t();

	$sq_bid = mysql_query("update vendor_request_vendor_entries set bid_amount='$bid_amount', bid_status='Done',vendor_specification='$vendor_specification' where entry_id='$entry_id'");
	if($sq_bid){
		commit_t();
		echo "Vendor bid updated!";
		$this->vendor_acknowlage($entry_id,$bid_amount,$vendor_specification,$vendor_name,$email);
	}
	else{
		rollback_t();
		echo "error--Sorry, Vendor bid not updated"."/".$bid_amount."/".$vendor_specification."/".$entry_id;
		exit;
	}

	for($i=0;$i<count($service_arr);$i++)
	{
		if($entry_id_arr[$i]=="")
		{
			$sq_max = mysql_fetch_assoc(mysql_query("select max(response_id) as max from vendor_response_entries"));
				$response_id = $sq_max['max'] + 1;
			$sq_query=mysql_query("INSERT INTO vendor_response_entries(response_id, entry_id, services, description, amount) VALUES ('$response_id','$entry_id','$service_arr[$i]','$description_arr[$i]','$amount_arr[$i]')");			
			if(!$sq_query)
			{
				$GLOBALS['flag'] = false;
				echo "Record not inserted";
			}
		}
		else
		{
			$sq_update=mysql_query("UPDATE vendor_response_entries SET entry_id='$entry_id' ,services='$service_arr[$i]',description='$description_arr[$i]', amount='$amount_arr[$i]' WHERE response_id='$entry_id_arr[$i]'");
			if(!$sq_update)
			{
				$GLOBALS['flag'] = false;
				echo "Record not Updated";
			}
		}
	}

}


function vendor_acknowlage($entry_id,$amount,$note,$vendor_name,$email)
{
	global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;
 	 global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;
 	 $sq_request_id=mysql_fetch_assoc(mysql_query("select * from vendor_request_vendor_entries where entry_id='$entry_id'"));
	 $content = '
	 <style type="text/css">
		td,th
		{
			padding:15px; 
			border:0px solid #c5c5c5;
		}
	</style>
		<p>Dear '.$app_name.'</p>
	    <p>Thank you for contacting us.</p>
	    <p>This is Acknowlegment that we recived Quotation.</p>
	    <p><strong>Booking Quotation</strong></p>
	    <p>Vendor Name:'.$vendor_name.'</p>
	    <p>Quotation Id : '.ge_vendor_request_id($sq_request_id['request_id']).'</p>	      
	    <table style="border-collapse: collapse;">
	        <thead>
	        	<tr>
	          		<th>Sr.no</th><th>Service</th><th>Description</th><th>Amount</th>
	          	</tr>
	        </thead>	          
	        <tbody>
	        ';
	        $count=1;
	        $sq_quotation_record=mysql_query("select * from vendor_response_entries where entry_id='$entry_id'");
	        while($sq_row=mysql_fetch_assoc($sq_quotation_record))
	        {
	        $content .='<tr>
	            <td>'.$count.'</td><td>'.$sq_row['services'].'</td><td>'.$sq_row['description'].'</td><td>'.$sq_row['amount'].'</td>
	          </tr>';
	          $count++;
	      	}
	          $content.='<tr><td style="padding:7px; border:1px solid #c5c5c5">Total Amount :&nbsp;&nbsp;<span style="color:'.$mail_color.'">'.$amount.'</span></td></tr>
          		<tr><td style="padding:7px; border:1px solid #c5c5c5">Specification :&nbsp;&nbsp;<span style="color:'.$mail_color.'">'.$note.'</span></td></tr>
	        </tbody>		        
	    </table>	      
	    <img src="'.BASE_URL.'/images/email/vacation.png" style="width:175px; height:auto; margin-bottom: -10px;" alt="">	   
	  ';

	  global $model;
	  $subject = " Vendor Quotation Acknowlagement for ".ge_vendor_request_id($sq_request_id['request_id']);
	  $model->app_email_master($app_email_id, $content, $subject);

}

}
?>