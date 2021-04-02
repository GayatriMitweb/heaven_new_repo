<?php  
include_once('../../model/model.php');

global $app_name, $app_address;

$quotation_for = "Hotel";

if($quotation_for=="Hotel"){
	$vendor_name = "hotel_name";
	$vendor_address = "";
}
if($quotation_for=="Transport"){
	$vendor_name = "hotel_name";
	$vendor_address = "";
}
if($quotation_for=="DMC"){
	$vendor_name = "hotel_name";
	$vendor_address = "";
}

$emp_id = $_SESSION['emp_id'];
if($emp_id==0){
	$generated_by = $app_name;
}
else{
	$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'"));
	$generated_by = $sq_emp['first_name'].' '.$sq_emp['last_name'];
}


if($quotation_for=="Hotel" || $quotation_for=="DMC"){

	$content1 = '
	<tr><td colspan="2" style="padding-top:20px">No Of Pax : _____________________</td></tr>
	<tr>
		<td colspan="2">
			<table style="width:100%; margin-top:10px; border-collapse:collapse;" cellspacing=0 cellpadding=0>
				<tr>
					<th style="border:1px solid #ddd; padding:5px">Adults</th>
					<th style="border:1px solid #ddd; padding:5px">Childrens</th>
					<th style="border:1px solid #ddd; padding:5px">Infants</th>
					<th style="border:1px solid #ddd; padding:5px">Child With Bed</th>
					<th style="border:1px solid #ddd; padding:5px">Child Without Bed</th>
				</tr>
				<tr>
					<td style="border:1px solid #ddd; padding:5px">Adults</td>
					<td style="border:1px solid #ddd; padding:5px">Childrens</td>
					<td style="border:1px solid #ddd; padding:5px">Infants</td>
					<td style="border:1px solid #ddd; padding:5px">Child With Bed</td>
					<td style="border:1px solid #ddd; padding:5px">Child Without Bed</td>
				</tr>
			</table>
		</td>
	</tr>
	';

	$content2 = '
	<tr>
		<td colspan="2">
			<table style="width:100%; margin-top:20px; border-collapse:collapse;" cellspacing=0 cellpadding=0>
				<tr>
					<th colspan="3" style="border:1px solid #ddd; padding:5px">Travel</th>				
				</tr>
				<tr>
					<th style="border:1px solid #ddd; padding:5px">Check-In</th>
					<th style="border:1px solid #ddd; padding:5px">Check-out</th>
					<th style="border:1px solid #ddd; padding:5px">Meal Plan</th>
				</tr>
				<tr>
					<td style="border:1px solid #ddd; padding:5px">______________</td>
					<td style="border:1px solid #ddd; padding:5px">______________</td>
					<td style="border:1px solid #ddd; padding:5px">______________</td>
				</tr>
			</table>
		</td>
	</tr>
	';

}

$content = $model->emailer_head();
$content .= '

<table style="width:100%; padding:0 30px">
<tr>
	<td style="width:360px">
		<p>
		To, <br>
		Sales/Reservation Manager,<br>
		'.$quotation_for.' Name: '.$vendor_name.'<br>
		Address: '.$vendor_address.'
		</p>
	</td>
	<td>
		From,<br>
		'.$app_address.'<br>
		Quotation requested By :'.$generated_by.'
	</td>
</tr>
<tr><td colspan="2">Subject:Tour Quotation Request</td></tr>
<tr><td colspan="2">Dear ______________________,</td></tr>

'.$content1.'
'.$content2.'

<tr>
	<td colspan="2">
		<table style="width:100%; margin-top:20px; margin-bottom:20px;">
			<tr><td style="padding-top:7px;">Tour Type : ________________</td></tr>
			<tr><td style="padding-top:7px;">Quotation Date : ________________</td></tr>
			<tr><td style="padding-top:7px;">Airport Pickup : ________________</td></tr>
			<tr><td style="padding-top:7px;">Cab Type : ________________</td></tr>
			<tr><td style="padding-top:7px;">Transfer Type : ________________</td></tr>
			<tr><td style="padding-top:7px;">Specification : ________________</td></tr>
		</table>
	</td>
</tr>


</table>

';
$content .= $model->emailer_footer();
echo $content;


//$subject = "iTours Testing";
//$to = "vishal.itweb@gmail.com";
//$model->app_email_master($to, $content, $subject);
?>