<?php
include "../../../model/model.php";

$customer_id = $_POST['customer_id'];
$booking_id = $_POST['booking_id'];
$payment_for = $_POST['payment_for'];
$payment_mode = $_POST['payment_mode'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$financial_year_id = $_SESSION['financial_year_id'];
$cust_type = $_POST['cust_type'];
$company_name = $_POST['company_name'];
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];

		$array_s = array();
		$temp_arr = array();
		$footer_data = array();
		$count = $total = $pending = $cancelled = 0;

		$query = "select * from package_payment_master where 1 ";
		if($customer_id!=""){
			$query .=" and booking_id in (select booking_id from package_tour_booking_master where customer_id='$customer_id')";
		}
		if($booking_id!=""){
			$query .=" and booking_id='$booking_id' ";
		}
		if($payment_for!=""){
			$query .= " and payment_for='$payment_for'";
		}
		if($payment_mode!=""){
			$query .= " and payment_mode='$payment_mode'";
		}
		if($from_date!="" && $to_date!=""){
			$from_date = get_date_db($from_date);
			$to_date = get_date_db($to_date);
			$query .= " and date between '$from_date' and '$to_date'";
		}
		if($financial_year_id!=""){
			$query .= " and financial_year_id='$financial_year_id'";
		}
		if($cust_type != ""){
		    $query .= " and booking_id in (select booking_id from package_tour_booking_master where customer_id in ( select customer_id from customer_master where type='$cust_type' ))";
		}
		if($company_name != ""){
		    $query .= " and booking_id in (select booking_id from package_tour_booking_master where customer_id in ( select customer_id from customer_master where company_name='$company_name' ))";
		}
		if($role == "B2b"){
			$query .= " and booking_id in (select booking_id from package_tour_booking_master where emp_id ='$emp_id')";
		}
		include "../../../model/app_settings/branchwise_filteration.php";
		$query .=" order by payment_id desc";
		$sq_payment = mysql_query($query);
		while($row_payment = mysql_fetch_assoc($sq_payment)){
			if($row_payment['amount']!=0){

				$sq_booking = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$row_payment[booking_id]'"));
				$total_sale = $sq_booking['total_travel_expense'] + $sq_booking['actual_tour_expense'];
				$sq_pay = mysql_fetch_assoc(mysql_query("select sum(amount) as sum from package_payment_master where clearance_status!='Cancelled' and booking_id='$row_payment[booking_id]'"));
				$total_pay_amt = $sq_pay['sum'];
				$outstanding =  $total_sale - $total_pay_amt;

				$date = $sq_booking['booking_date'];
				$yr = explode("-", $date);
				$year =$yr[0];

				$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_booking[customer_id]'"));
				if($sq_customer['type'] == 'Corporate'){
					$customer_name = $sq_customer['company_name'];
				}else{
					$customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
				}
				
				$bg = "";
				if($row_payment['clearance_status']=="Pending"){
					$bg = "warning";
					$pending = $pending + $row_payment['amount'];
				}
				else if($row_payment['clearance_status']=="Cancelled"){
					$bg = "danger";
					$cancelled = $cancelled + $row_payment['amount'];
				}

				$total = $total + $row_payment['amount'];

				$payment_id_name = "Package Payment ID";
				$payment_id = get_package_booking_payment_id($row_payment['payment_id'],$year);
				$receipt_date = date('d-m-Y');
				$booking_id = get_package_booking_id($row_payment['booking_id'],$year);
				$customer_id = $sq_booking['customer_id'];
				$booking_name = "Package Booking";
				$travel_date = date('d-m-Y',strtotime($sq_booking['tour_from_date']));
				$tour = $sq_booking['tour_name'];
				$payment_amount = $row_payment['amount'];
				$payment_mode1 = $row_payment['payment_mode'];
				$transaction_id = $row_payment['transaction_id'];
				$payment_date = $row_payment['date'];
				$bank_name = $row_payment['bank_name'];
				$receipt_type = ($row_payment['payment_for']=='Travelling') ? "Travel Receipt" : "Tour Receipt";

				$url1 = BASE_URL."model/app_settings/print_html/receipt_html/receipt_body_html.php?payment_id_name=$payment_id_name&payment_id=$payment_id&receipt_date=$receipt_date&booking_id=$booking_id&customer_id=$customer_id&booking_name=$booking_name&travel_date=$travel_date&payment_amount=$payment_amount&transaction_id=$transaction_id&payment_date=$payment_date&bank_name=$bank_name&confirm_by=$confirm_by&receipt_type=$receipt_type&payment_mode=$payment_mode1&branch_status=$branch_status&outstanding=$outstanding&tour=$tour&table_name=package_payment_master&customer_field=booking_id&in_customer_id=$row_payment[booking_id]";
				
				$checshow = "";
				if($row_payment['payment_mode']=="Cash" || $row_payment['payment_mode']=="Cheque"){
					$checshow = '<input type="checkbox" id="chk_receipt_'. $count .'" name="chk_receipt" value="'. $row_payment['payment_id'] .'">';
				} 
				
				$payshow = "";
				if($payment_mode=="Cheque"){
					$payshow = '<input type="text" id="branch_name_'.$count.'" name="branch_name_d" class="form-control" placeholder="Branch Name" style="width:120px">';
				}
				$temp_arr = array( "data" => array(
					(int)(++$count),
					$checshow,
					get_package_booking_id($row_payment['booking_id'],$year),
					$customer_name,
					$row_payment['payment_for'],
					$payment_mode1,
					get_date_user($row_payment['date']),
					$payshow,
					$row_payment['amount'],
					'<a onclick="loadOtherPage(\''. $url1 .'\')" data-toggle="tooltip" class="btn btn-info btn-sm" title="Download Receipt"><i class="fa fa-print"></i></a>
		
					<button class="btn btn-info btn-sm" data-toggle="tooltip" onclick="update_modal('.$row_payment['payment_id'].')" title="Update Details"><i class="fa fa-pencil-square-o"></i></button>'
				  ), "bg" =>$bg );
				  array_push($array_s,$temp_arr); 
				}}
				$footer_data = array("footer_data" => array(
					'total_footers' => 4,
					'foot0' => "Total Amount: ".number_format($total, 2),
					'col0' => 3,
					'class0' => "info",
					'foot1' => "Pending Clearance : ".number_format($pending, 2),
					'col1' => 2,
					'class1' => "warning",
					'foot2' =>  "Cancelled : ".number_format($cancelled, 2),
					'col2' => 2,
					'class2' => "danger",
					'foot3' => "Total Paid : ".number_format(($total - $pending - $cancelled), 2),
					'col3' => 3,
					'class3' => "success"
					)
				);
				array_push($array_s, $footer_data);	
				echo json_encode($array_s);	
				?>