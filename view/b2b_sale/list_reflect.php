<?php
include "../../model/model.php";
$customer_id = $_POST['customer_id'];
$b2b_booking_master = $_POST['b2b_booking_master'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];

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
//Get default currency rate
global $currency;
$sq_to = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$currency'"));
$to_currency_rate = $sq_to['currency_rate'];

$count = 0;
$outstanding = 0;
$net_total = 0;
$array_s = array();
$temp_arr = array();
$footer_data = array();
$sq_customer = mysql_query($query);
while($row_customer = mysql_fetch_assoc($sq_customer)){
	$hotel_total = 0;
	$transfer_total = 0;
	$activity_total = 0;
	$tours_total = 0;
	$servie_total = 0;
	$hotel_flag = 0;
	$activity_flag = 0;
	$yr = explode("-", get_datetime_db($row_customer['created_at']));
	$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_customer[customer_id]'"));
	$cart_checkout_data = json_decode($row_customer['cart_checkout_data']);
	
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
			for($j=0;$j<sizeof($cart_checkout_data[$i]->service);$j++){
				$tax_amount = 0;
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
	
	$url = BASE_URL."model/app_settings/print_html/receipt_html/b2b_receipt_html.php?booking_id=$booking_id&customer_id=$customer_id&branch_status=$branch_status&confirm_by=$confirm_by&receipt_type=$receipt_type";
	
	$booking_id1 = $row_customer['booking_id'];
	$service_url = BASE_URL."model/app_settings/print_html/voucher_html/b2b_voucher.php?booking_id=$booking_id1";

	if($hotel_flag || $activity_flag){
		$service_voucher = '<a data-toggle="tooltip" onclick="voucher_modal('.$booking_id1.','.$hotel_flag.','.$activity_flag.')" class="btn btn-info btn-sm" title="Generate Service Voucher"><i class="fa fa-print"></i></a>';
	}
	else{
		$service_voucher = '<a data-toggle="tooltip" onclick="loadOtherPage(\''. $service_url .'\')" class="btn btn-info btn-sm" title="Generate Service Voucher"><i class="fa fa-print"></i></a>';
	}
	
	$temp_arr = array( "data" => array(
		(int)(++$count),
		$invoice_no,
		$sq_cust['company_name'],
		get_date_user($row_customer['created_at']),
		number_format($servie_total,2),
		number_format(0,2),
		number_format($servie_total,2),
		number_format($payment_amount,2),
		'<a data-toggle="tooltip" onclick="loadOtherPage(\''.$url .'\')" class="btn btn-info btn-sm" title="Download Receipt"><i class="fa fa-print"></i></a><a data-toggle="tooltip" onclick="loadOtherPage(\''. $url1 .'\')" class="btn btn-info btn-sm" title="Download Invoice"><i class="fa fa-print"></i></a>
		'.$service_voucher.'
		<button data-toggle="tooltip" class="btn btn-info btn-sm" style="display:inline-block" onclick="customer_display_modal('. $row_customer['booking_id'] .')" title="View Details"><i class="fa fa-eye"></i></button>
		'
		), "bg" =>$bg );
		array_push($array_s,$temp_arr); 
	}
	$footer_data = array("footer_data" => array(
		'total_footers' => 6,
		'foot0' => "Total",
		'col0' => 4,
		'class0' => "",				
		'foot1' => number_format($net_total,2),
		'col1' => 0,
		'class1' => "warning",				
		'foot2' =>  "Cancel",
		'col2' => 0,
		'class2' => "danger",			
		'foot3' => number_format($net_total,2),
		'col3' => 0,
		'class3' => "info",
		'foot4' =>  number_format($paid_amount,2),
		'col4' => 0,
		'class4' => "success",
		'foot5' => 'Balance : '.number_format($outstanding,2),
		'col5' => 3,
		'class5' => "danger",
		)
	);
	array_push($array_s, $footer_data);	
	echo json_encode($array_s);	
?>