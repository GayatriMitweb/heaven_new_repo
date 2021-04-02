<?php
include "../../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$customer_id = $_POST['customer_id'];
$booking_id = $_POST['booking_id'];
$payment_from_date = $_POST['from_date'];
$payment_to_date = $_POST['to_date'];
$cust_type = $_POST['cust_type'];
$company_name = $_POST['company_name'];
$booker_id = $_POST['booker_id'];
$branch_id = $_POST['branch_id'];

$query = "select * from forex_booking_master where 1 ";
if($booking_id!=""){
	$query .= " and booking_id='$booking_id'";
}
if($customer_id!=""){
	$query .= " and customer_id='$customer_id'";
}
if($payment_from_date!='' && $payment_to_date!=''){
			$payment_from_date = get_date_db($payment_from_date);
			$payment_to_date = get_date_db($payment_to_date);
			$query .=" and date(created_at) between '$payment_from_date' and '$payment_to_date'";
		
}

if($cust_type != ""){
	$query .= " and customer_id in (select customer_id from customer_master where type = '$cust_type')";
}
if($company_name != ""){
	$query .= " and customer_id in (select customer_id from customer_master where company_name = '$company_name')";
}
if($booker_id!=""){
	$query .= " and emp_id='$booker_id'";
}
if($branch_id!=""){
	$query .= " and emp_id in(select emp_id from emp_master where branch_id = '$branch_id')";
}
include "../../../../model/app_settings/branchwise_filteration.php";
$query .= " order by booking_id desc";	
		$total_balance = $total_refund = $count = 0;$array_s = array();
		$temp_arr = array();
		$sq_booking = mysql_query($query);
		while($row_booking = mysql_fetch_assoc($sq_booking)){

			$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
			$contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
			$email_id = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key);
            if($sq_customer['type']=='Corporate'){
                $customer_name = $sq_customer['company_name'];
            }else{
                $customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
            }
            $date = $row_booking['created_at'];
            $yr = explode("-", $date);
           	$year =$yr[0];

			$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_booking[emp_id]'"));
			if($sq_emp['first_name'] == '') { $emp_name='Admin';}
			else{ $emp_name = $sq_emp['first_name'].' '.$sq_emp['last_name']; }

			$sq_branch = mysql_fetch_assoc(mysql_query("select * from branches where branch_id='$sq_emp[branch_id]'"));
			$branch_name = $sq_branch['branch_name']==''?'NA':$sq_branch['branch_name'];

			$sq_paid_amount = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum,sum(credit_charges) as sumc from forex_booking_payment_master where booking_id='$row_booking[booking_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

			$credit_card_charges = $sq_paid_amount['sumc'];
			$total_sale = $row_booking['net_total'] +  $sq_paid_amount['sumc'];
			$balance_amt = $total_sale - $sq_paid_amount['sum']- $sq_paid_amount['sumc'];
			$paid_amount = $sq_paid_amount['sum'];
			if($paid_amount==""){	$paid_amount=0; } 
            $canc_amount = $row_booking['refund_net_total'];
			if($canc_amount=="") { $canc_amount=0;}
			$total_bal = $total_sale - $cancel_amount;	
			$bal = $total_bal - $paid_amount-$sq_paid_amount['sumc'];

			//Footer
			$cancel_total = $cancel_total + $cancel_amount;
			$sale_total = $sale_total + $total_bal;
			$paid_total = $paid_total + $paid_amount+$sq_paid_amount['sumc'];
			$balance_total = $balance_total + $bal;

			/////// Purchase ////////
			$total_purchase = 0;
			$purchase_amt = 0;
			$i=0;
			$p_due_date = '';
			$sq_purchase_count = mysql_num_rows(mysql_query("select * from vendor_estimate where estimate_type='Forex Booking' and estimate_type_id='$row_booking[booking_id]'"));
			if($sq_purchase_count == 0){  $p_due_date = 'NA'; }
			$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Forex Booking' and estimate_type_id='$row_booking[booking_id]'");
			while($row_purchase = mysql_fetch_assoc($sq_purchase)){		
				$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
				$total_purchase = $total_purchase + $purchase_amt;
			}
			$sq_purchase1 = mysql_fetch_assoc(mysql_query("select * from vendor_estimate where estimate_type='Forex Booking' and estimate_type_id='$row_booking[booking_id]'"));		
			$vendor_name = get_vendor_name_report($sq_purchase1['vendor_type'], $sq_purchase1['vendor_type_id']);
			if($vendor_name == ''){ $vendor_name1 = 'NA';  }
			else{ $vendor_name1 = $vendor_name; }

			//Invoice
			$paid_amount = $sq_paid_amount['sum'];
			$paid_amount = ($paid_amount == '')?0:$paid_amount;

			$date = $row_booking['created_at'];
			$yr = explode("-", $date);
			$year =$yr[0];
			
			$invoice_no = get_forex_booking_id($row_booking['booking_id'],$year);
			$booking_id = $row_booking['booking_id'];
			$invoice_date = date('d-m-Y',strtotime($row_booking['created_at']));

			$customer_id = $row_booking['customer_id'];

			$service_name = "Forex Invoice";

			$basic_cost = $row_booking['net_total'] - $row_booking['service_tax_subtotal']- $row_booking['service_charge'];

			$taxation_type = $row_booking['taxation_type'];

			$service_tax_per = $row_booking['service_tax'];

			$service_tax = $row_booking['service_tax_subtotal'];

			$service_charge = $row_booking['service_charge'];

			$net_amount = $row_booking['net_total'];
			$bal_amount = $net_amount - $paid_amount + +$sq_paid_amount['sumc'];

			$sq_sac = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Forex'"));   
			$sac_code = $sq_sac['hsn_sac_code'];

			if($app_invoice_format == 4)
			$url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/tax_invoice_html.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&basic_cost=$basic_cost&taxation_type=$taxation_type&service_tax_per=$service_tax_per&service_tax=$service_tax&net_amount=$net_amount&service_charge=$service_charge&total_paid=$paid_amount&balance_amount=$bal_amount&sac_code=$sac_code&branch_status=$branch_status&booking_id=$booking_id&credit_card_charges=$credit_card_charges";
			else
			$url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/forex_body_html.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&basic_cost=$basic_cost&taxation_type=$taxation_type&service_tax_per=$service_tax_per&service_tax=$service_tax&net_amount=$net_amount&service_charge=$service_charge&total_paid=$paid_amount&balance_amount=$bal_amount&sac_code=$sac_code&branch_status=$branch_status&booking_id=$booking_id&credit_card_charges=$credit_card_charges";
			
			//Service Tax and Markup Tax
			$service_tax_amount = 0;
			if($row_booking['service_tax_subtotal'] !== 0.00 && ($row_booking['service_tax_subtotal']) !== ''){
				$service_tax_subtotal1 = explode(',',$row_booking['service_tax_subtotal']);
				for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
				$service_tax = explode(':',$service_tax_subtotal1[$i]);
				$service_tax_amount +=  $service_tax[2];
				}
			}
			$temp_arr = array( "data" => array(
				(int)(++$count),
				get_forex_booking_id($row_booking['booking_id'],$year),
				$customer_name,
				$contact_no,
				$email_id,
				$row_booking['booking_type'],
				get_date_user($row_booking['created_at']),
				'<button class="btn btn-info btn-sm" onclick="forex_view_modal('. $row_booking['booking_id'] .')" data-toggle="tooltip" title="View Detail"><i class="fa fa-eye" aria-hidden="true"></i></button>',
				($row_booking['currency_code']),
				($row_booking['rate']),
				($row_booking['forex_amount']),
				number_format($row_booking['basic_cost'],2),
				number_format($row_booking['service_charge'],2),
				number_format($service_tax_amount,2),
				$sq_paid_amount['sumc'],
				number_format($total_sale,2),
				number_format($paid_amount+$sq_paid_amount['sumc'], 2),
				'<button class="btn btn-info btn-sm" onclick="payment_view_modal('.$row_booking['booking_id'] .')"  data-toggle="tooltip" title="View Detail"><i class="fa fa-eye" aria-hidden="true"></i></button>',
				number_format($bal, 2),
				number_format($total_purchase,2),
				'<button class="btn btn-info btn-sm" onclick="supplier_view_modal('. $row_booking['booking_id'] .')" data-toggle="tooltip" title="View Detail"><i class="fa fa-eye" aria-hidden="true"></i></button>',
				$branch_name,
				$emp_name,
				'<a onclick="loadOtherPage(\''. $url1 .'\')" class="btn btn-info btn-sm" data-toggle="tooltip" title="Download Invoice"><i class="fa fa-print"></i></a>'
				), "bg" =>$bg);
				array_push($array_s,$temp_arr);
			}
			$footer_data = array("footer_data" => array(
				'total_footers' => 5,
				'foot0' => "",
				'col0' =>12,
				'class0' =>"",
				
				'foot1' => "TOTAL SALE :".number_format($sale_total,2),
				'col1' => 2,
				'class1' =>"info text-right",
			
				'foot2' => "TOTAL PAID : ".number_format($paid_total,2),
				'col2' => 2,
				'class2' =>"success text-right",
			
				'foot3' => "TOTAL BALANCE : ".number_format($balance_total,2),
				'col3' => 2,
				'class3' =>"warning text-right",
			
				'foot4' => "",
				'col4' => 4,
				'class4' =>""
			
				)
			);
			array_push($array_s, $footer_data);
			echo json_encode($array_s);
			?>