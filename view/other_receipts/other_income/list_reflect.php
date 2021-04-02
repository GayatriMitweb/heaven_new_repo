<?php
include "../../../model/model.php";

$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$income_type_id = $_POST['income_type_id'];
$financial_year_id = $_SESSION['financial_year_id'];

$query = "select * from other_income_master where 1 ";
if($from_date!="" && $to_date!=""){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);

	$query .= " and receipt_date between '$from_date' and '$to_date'";
}
if($income_type_id!=""){
	$query .= " and income_type_id='$income_type_id' ";
}
if($financial_year_id!=""){
	$query .=" and financial_year_id='$financial_year_id'";
}
$query .=" order by income_id desc";
$array_s = array();
		$temp_arr = array();
		$footer_data = array();
		$count = 0;
		$bg;
		$paid_amount=0;
		$sq_income = mysql_query($query);
		while($row_income = mysql_fetch_assoc($sq_income)){

			$sq_income_type_info = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$row_income[income_type_id]'"));
			$sq_paid = mysql_fetch_assoc(mysql_query("select * from other_income_payment_master where income_type_id='$row_income[income_id]'"));
			$paid_amount+=$sq_paid['payment_amount'];

			$year1 = explode("-", $sq_paid['payment_date']);
			$yr1 =$year1[0];
			$bg='';
			if($sq_paid['clearance_status']=="Pending"){ 
				$bg='warning';
				$sq_pending_amount = $sq_pending_amount + $sq_paid['payment_amount'];
				;
			}
			else if($sq_paid['clearance_status']=="Cancelled"){ 
				$bg='danger';
				$sq_cancel_amount = $sq_cancel_amount + $sq_paid['payment_amount'];
				;
			}

			$payment_id_name = "Hotel Payment ID";
			$payment_id = get_other_income_payment_id($sq_paid['payment_id'],$yr1);
			$receipt_date = date('d-m-Y');
			$booking_id = $row_income['receipt_from'];
			$customer_id = $sq_paid['customer_id'];
			$booking_name = $sq_income_type_info['ledger_name'].'('.$row_income['particular'].')';
			$travel_date = 'NA';
			$payment_amount = $sq_paid['payment_amount'];
			$payment_mode1 = $sq_paid['payment_mode'];
			$transaction_id = $sq_paid['transaction_id'];
			$payment_date = date('d-m-Y',strtotime($sq_paid['payment_date']));
			$receipt_date = date('d-m-Y',strtotime($row_income['receipt_date']));
			$bank_name = $sq_paid['bank_name'];
			$receipt_type ="Other Income";
			
			$url1 = BASE_URL."model/app_settings/print_html/receipt_html/receipt_body_html.php?payment_id_name=$payment_id_name&payment_id=$payment_id&receipt_date=$receipt_date&booking_id=$booking_id&customer_id=$customer_id&booking_name=$booking_name&travel_date=$travel_date&payment_amount=$payment_amount&transaction_id=$transaction_id&payment_date=$payment_date&receipt_date=$receipt_date&bank_name=$bank_name&confirm_by=$confirm_by&receipt_type=$receipt_type&payment_mode=$payment_mode1&branch_status=$branch_status";
			$temp_arr = array( "data" => array(
				(int)(++$count),
				$sq_income_type_info['ledger_name'],
				$row_income['receipt_from'],
				get_date_user($row_income['receipt_date']),
				($sq_paid['payment_mode']=='')?'NA':$sq_paid['payment_mode'],
				$row_income['particular'],
				$sq_paid['payment_amount'] ,
				'
				<a onclick="loadOtherPage(\''. $url1 .'\')" data-toggle="tooltip" class="btn btn-info btn-sm" title="Download Receipt"><i class="fa fa-print"></i></a>
				<button class="btn btn-info btn-sm" data-toggle="tooltip" title="Update Details" onclick="update_income_modal('. $sq_paid['payment_id'] .')"><i class="fa fa-pencil-square-o"></i></button>
				<button class="btn btn-info btn-sm" data-toggle="tooltip" onclick="entry_display_modal('. $row_income['income_id'] .')" title="View Details"><i class="fa fa-eye"></i></button>
				'
			  ), "bg" =>$bg );
			  array_push($array_s,$temp_arr); 
			}	
			
			$footer_data = array("footer_data" => array(
				'total_footers' => 4,
				'foot0' => "Paid Amount: ".number_format($paid_amount, 2),
				'col0' => 2,
				'class0' => "info",
				'foot1' => "Pending Clearance : ".number_format($sq_pending_amount, 2),
				'col1' => 2,
				'class1' => "warning",
				'foot2' =>  "Cancellation Charges: ".number_format($sq_cancel_amount, 2),
				'col2' => 2,
				'class2' => "danger",
				'foot3' => "Total Payment : ".number_format(($paid_amount - $sq_pending_amount - $sq_cancel_amount), 2),
				'col3' => 2,
				'class3' => "success",
				)
			);		
			array_push($array_s, $footer_data);	
			echo json_encode($array_s);	
			?>