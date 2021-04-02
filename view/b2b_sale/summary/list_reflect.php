<?php 
include "../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$customer_id = $_POST['customer_id'];
$b2b_booking_master = $_POST['b2b_booking_master'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];

$branch_id = $_POST['branch_id'];
$array_s = array();
$temp_arr = array();

$query = "select * from b2b_booking_master where 1 ";
if($customer_id!=""){
	$query .=" and customer_id='$customer_id' ";
}
if($b2b_booking_master!=""){
	$query .=" and booking_id='$b2b_booking_master' ";
}
if($from_date!="" && $to_date !=""){
	$from_date = get_datetime_db($from_date);
	$to_date = get_datetime_db($to_date);
	$query .=" and (created_at>='$from_date' and created_at<='$to_date') ";
}
$query .= " order by booking_id desc";
global $currency;
$sq_to = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$currency'"));
$to_currency_rate = $sq_to['currency_rate'];
$count = 0;
$cancel_total =0;
$outstanding = 0;
$net_total = 0;
$sq_customer = mysql_query($query);
while($row_customer = mysql_fetch_assoc($sq_customer)){
	$hotel_total = 0;
	$transfer_total = 0;
	$activity_total = 0;
	$tours_total = 0;
	$servie_total = 0;

    $yr = explode("-", get_datetime_db($row_customer['created_at']));
	$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_customer[customer_id]'"));
	$cart_checkout_data = json_decode($row_customer['cart_checkout_data']);

	$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_customer[emp_id]'"));
	if($sq_emp['first_name'] == '') { $emp_name='Admin';}
	else{ $emp_name = $sq_emp['first_name'].' '.$sq_emp['last_name']; }

	$sq_branch = mysql_fetch_assoc(mysql_query("select * from branches where branch_id='$sq_emp[branch_id]'"));
	$branch_name = $sq_branch['branch_name']==''?'NA':$sq_branch['branch_name'];
	
	for($i=0;$i<sizeof($cart_checkout_data);$i++){
		
		if($cart_checkout_data[$i]->service->name == 'Hotel'){
			$hotel_flag = 1;
			$tax_arr = explode(',',$cart_checkout_data[$i]->service->hotel_arr->tax);
			$tax_amount = 0;
			for($j=0;$j<sizeof($cart_checkout_data[$i]->service->item_arr);$j++){
				$room_types = explode('-',$cart_checkout_data[$i]->service->item_arr[$j]);
				$room_cost = $room_types[2];
				$h_currency_id = $room_types[3];
				
				$tax_arr1 = explode('+',$tax_arr[0]);
				for($t=0;$t<sizeof($tax_arr1);$t++){
				  if($tax_arr1[$t]!=''){
					$tax_arr2 = explode(':',$tax_arr1[$t]);
					if($tax_arr2[2] == "Percentage"){
					  $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
					}else{
					  $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
					}
				  }
				}
				$total_amount = $room_cost + $tax_amount;

				//Convert into default currency
				$sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
				$from_currency_rate = $sq_from['currency_rate'];
				$total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
			
				$hotel_total += $total_amount;
			}
		}
		if($cart_checkout_data[$i]->service->name == 'Transfer'){
			$tax_amount = 0;
			for($j=0;$j<sizeof($cart_checkout_data[$i]->service);$j++){
			$tax_arr = explode(',',$cart_checkout_data[$i]->service->service_arr[$j]->taxation);
			$transfer_cost = explode('-',$cart_checkout_data[$i]->service->service_arr[$j]->transfer_cost);
				$room_cost = $transfer_cost[0];
				$h_currency_id = $transfer_cost[1];
				
				$tax_arr1 = explode('+',$tax_arr[0]);
				for($t=0;$t<sizeof($tax_arr1);$t++){
					if($tax_arr1[$t]!=''){
						$tax_arr2 = explode(':',$tax_arr1[$t]);
						if($tax_arr2[2] == "Percentage"){
							$tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
						}else{
							$tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
						}
					}
				}
				$total_amount = $room_cost + $tax_amount;

				//Convert into default currency
				$sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
				$from_currency_rate = $sq_from['currency_rate'];
				$total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
			
				$transfer_total += $total_amount;
			}
		}
		if($cart_checkout_data[$i]->service->name == 'Activity'){
			$activity_flag = 1;
			for($j=0;$j<sizeof($cart_checkout_data[$i]->service);$j++){
			
				$tax_amount = 0;
				$tax_arr = explode(',',$cart_checkout_data[$i]->service->service_arr[$j]->taxation);
				$transfer_cost = explode('-',$cart_checkout_data[$i]->service->service_arr[$j]->transfer_type);
				$room_cost = $transfer_cost[1];
				$h_currency_id = $transfer_cost[2];
				
				$tax_arr1 = explode('+',$tax_arr[0]);
				for($t=0;$t<sizeof($tax_arr1);$t++){
				  if($tax_arr1[$t]!=''){
					$tax_arr2 = explode(':',$tax_arr1[$t]);
					if($tax_arr2[2] === "Percentage"){
					  $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
					}else{
					  $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
					}
				  }
				}
				$total_amount = $room_cost + $tax_amount;

				//Convert into default currency
				$sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
				$from_currency_rate = $sq_from['currency_rate'];
				$total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
			
				$activity_total += $total_amount;
			}
		}
		if($cart_checkout_data[$i]->service->name == 'Combo Tours'){
			for($j=0;$j<sizeof($cart_checkout_data[$i]->service);$j++){
			
				$tax_amount = 0;
			    $tax_arr = explode(',',$cart_checkout_data[$i]->service->service_arr[$j]->taxation);
				$room_cost = $cart_checkout_data[$i]->service->service_arr[$j]->total_cost;
				$h_currency_id = $cart_checkout_data[$i]->service->service_arr[$j]->currency_id;
				
				$tax_arr1 = explode('+',$tax_arr[0]);
				for($t=0;$t<sizeof($tax_arr1);$t++){
				  if($tax_arr1[$t]!=''){
					$tax_arr2 = explode(':',$tax_arr1[$t]);
					if($tax_arr2[2] == "Percentage"){
					  $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
					}else{
					  $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
					}
				  }
				}
				$total_amount = $room_cost + $tax_amount;

				//Convert into default currency
				$sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
				$from_currency_rate = $sq_from['currency_rate'];
				$total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
			
				$tours_total += $total_amount;
			}
		}
	}

	$servie_total = $servie_total + $hotel_total + $transfer_total + $activity_total + $tours_total;
	
	if($row_customer['coupon_code'] != ''){
		$sq_hotel_count = mysql_num_rows(mysql_query("select offer,offer_amount from hotel_offers_tarrif where coupon_code='$query[coupon_code]'"));
		if($sq_hotel_count > 0){
			$sq_coupon = mysql_fetch_assoc(mysql_query("select offer as offer,offer_amount from hotel_offers_tarrif where coupon_code='$row_customer[coupon_code]'"));
		}else{
			$sq_coupon = mysql_fetch_assoc(mysql_query("select offer_in as offer,offer_amount from excursion_master_offers where coupon_code='$row_customer[coupon_code]'"));
		}

		if($sq_coupon['offer']=="Flat"){
			$servie_total = $servie_total - $sq_coupon['offer_amount'];
		}else{
			$servie_total = $servie_total - ($servie_total*$sq_coupon['offer_amount']/100);
		}
	}
	
	$net_total += $servie_total;
	
	$sq_payment_info = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from b2b_payment_master where booking_id='$row_customer[booking_id]' and (clearance_status!='Pending' or clearance_status!='Cancelled')"));
	$payment_amount = $sq_payment_info['sum'];
	$paid_amount +=$sq_payment_info['sum'];
	$outstanding = $net_total - $paid_amount;

	//Invoice
	$invoice_no = get_b2b_booking_id($row_customer['booking_id'],$yr[0]);
	$booking_id = $row_customer['booking_id'];
	$invoice_date = date('d-m-Y',strtotime($row_customer['created_at']));
	$customer_id = $row_customer['customer_id'];
	$service_name = "B2B Invoice";
	$sq_sac = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Package Tour'"));
	$sac_code = $sq_sac['hsn_sac_code'];

	if($app_invoice_format == 4)
	$url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/b2b_tax_invoice.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&booking_id=$booking_id&sac_code=$sac_code";
	else
	$url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/b2b_body_html.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&booking_id=$booking_id&sac_code=$sac_code";

	//Receipt
	$payment_id_name = "Receipt ID";
	$booking_id = $row_customer['booking_id'];
	$customer_id = $row_customer['customer_id'];
	$receipt_type = "B2B Sale Receipt";

	/////// Purchase ////////
	$total_purchase = 0;
	$purchase_amt = 0;
	$i=0;
	$p_due_date = '';
	$sq_purchase_count = mysql_num_rows(mysql_query("select * from vendor_estimate where estimate_type='B2B Booking' and estimate_type_id='$row_customer[booking_id]'"));
	if($sq_purchase_count == 0){  $p_due_date = 'NA'; }
	$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='B2B Booking' and estimate_type_id='$row_customer[booking_id]'");
	while($row_purchase = mysql_fetch_assoc($sq_purchase)){			
		$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
		$total_purchase = $total_purchase + $purchase_amt;
	}
	$sq_purchase1 = mysql_fetch_assoc(mysql_query("select * from vendor_estimate where estimate_type='B2B Booking' and estimate_type_id='$row_customer[booking_id]'"));		
	$vendor_name = get_vendor_name_report($sq_purchase1['vendor_type'], $sq_purchase1['vendor_type_id']);
	if($vendor_name == ''){ $vendor_name1 = 'NA';  }
	else{ $vendor_name1 = $vendor_name; }



	/////// Incetive ////////
	$sq_incentive = mysql_fetch_assoc(mysql_query("select * from booker_sales_incentive where booking_id='$row_customer[booking_id]'"));
	
	//////////Invoice//////////////
	$invoice_no = get_b2b_booking_id($row_customer['booking_id'],$yr[0]);
	$invoice_date = date('d-m-Y',strtotime($row_customer['booking_date']));
	$customer_id = $row_customer['customer_id'];
	$quotation_id = $row_customer['quotation_id'];
	$service_name = "Package Invoice";			
	
	//**Service Tax
	$taxation_type = $row_customer['taxation_type'];
	
	//basic amount
	$train_expense = $row_customer['train_expense'];
	$plane_expense = $row_customer['plane_expense'];
	$cruise_expense = $row_customer['cruise_expense'];
	$visa_amount = $row_customer['visa_amount'];
	$insuarance_amount = $row_customer['insuarance_amount'];
	$tour_subtotal = $row_customer['subtotal'] - $cancel_tour_amount;
	$basic_cost = $train_expense +$plane_expense +$cruise_expense +$visa_amount +$insuarance_amount +$tour_subtotal;

	//Service charge	
	$train_service_charge = $row_customer['train_service_charge'];
	$plane_service_charge = $row_customer['plane_service_charge'];
	$cruise_service_charge = $row_customer['cruise_service_charge'];
	$visa_service_charge = $row_customer['visa_service_charge'];
	$insuarance_service_charge = $row_customer['insuarance_service_charge'];
	$service_charge = $train_service_charge +$plane_service_charge +$cruise_service_charge +$visa_service_charge +$insuarance_service_charge +$tour_subtotal;

	//service tax
	$train_service_tax = $row_customer['train_service_tax'];
	$plane_service_tax = $row_customer['plane_service_tax'];
	$cruise_service_tax = $row_customer['cruise_service_tax'];
	$visa_service_tax = $row_customer['visa_service_tax'];
	$insuarance_service_tax = $row_customer['insuarance_service_tax'];
	$tour_service_tax = $row_customer['tour_service_tax'];
	
	//service tax subtotal	
	$train_service_tax_subtotal = $row_customer['train_service_tax_subtotal'];
	$plane_service_tax_subtotal = $row_customer['plane_service_tax_subtotal'];
	$cruise_service_tax_subtotal = $row_customer['cruise_service_tax_subtotal'];
	$visa_service_tax_subtotal = $row_customer['visa_service_tax_subtotal'];
	$insuarance_service_tax_subtotal = $row_customer['insuarance_service_tax_subtotal'];
	$tour_service_tax_subtotal = $row_customer['tour_service_tax_subtotal'];
	$service_tax_subtotal = $train_service_tax_subtotal +$plane_service_tax_subtotal +$cruise_service_tax_subtotal +$visa_service_tax_subtotal +$insuarance_service_tax_subtotal+$tour_service_tax_subtotal;

	// Net amount
	$net_amount = 0;
	$tour_total_amount= ($row_customer['actual_tour_expense']!="") ? $row_customer['actual_tour_expense']: 0;
	$net_amount  =  $tour_total_amount + $row_customer['total_travel_expense'] - $cancel_tour_amount;
	
	$sq_sac = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Package Tour'"));   
	$sac_code = $sq_sac['hsn_sac_code'];
	$tour_date = get_date_user($row_customer['tour_from_date']);
	$destination_city = $row_customer['tour_name'];


	$temp_arr = array( "data" => array(
		
		(int)(++$count),
		$invoice_no,
		$sq_cust['company_name'],
		$row_customer['contact_no'],
		$row_customer['email_id'],
		get_date_user($row_customer['created_at']),
		number_format($servie_total,2),
		number_format(0,2),
		number_format($servie_total,2),
		number_format($payment_amount,2),
		'<button class="btn btn-info btn-sm" onclick="payment_view_modal('.$row_customer['booking_id'] .')"  data-toggle="tooltip" title="View Detail"><i class="fa fa-eye" aria-hidden="true"></i></button>',
		number_format($outstanding, 2),
		number_format($total_purchase,2),
		$vendor_name1,
		'<button class="btn btn-info btn-sm" onclick="supplier_view_modal('. $row_customer['booking_id'] .')" data-toggle="tooltip" title="View Detail"><i class="fa fa-eye" aria-hidden="true"></i></button>',
		$emp_name,
		number_format($sq_incentive['incentive_amount'],2),
		'<a onclick="loadOtherPage(\''. $url1 .'\')" class="btn btn-info btn-sm" data-toggle="tooltip" title="Print Invoice"><i class="fa fa-print"></i></a>'
		


		), "bg" =>$bg);
	array_push($array_s,$temp_arr);
	
}
$footer_data = array("footer_data" => array(
	'total_footers' => 6,
	'foot0' => "",
	'col0' =>6,
	'class0' =>"success : ",

	'foot1' => "TOTAL SALE : ".number_format($net_total,2),
	'col1' => 2,
	'class1' =>"info text-right",
	
	'foot2' => "TOTAL CANCEL : ".number_format($cancel_total,2),
	'col2' => 2,
	'class2' =>"danger text-right",

	'foot3' => "TOTAL PAID : ".number_format($paid_amount,2),
	'col3' => 2,
	'class3' =>"success text-right",

	'foot4' => "TOTAL BALANCE : ".number_format($outstanding,2),
	'col4' => 2,
	'class4' =>"warning text-right",

	'foot5' => "",
	'col5' => 4,
	'class5' =>""

	)
);
array_push($array_s, $footer_data);
echo json_encode($array_s);
?>
	