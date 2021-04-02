<?php
include "../../model/model.php";
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$emp_id = $_SESSION['emp_id'];

$branch_status = $_POST['branch_status'];
$tour_id = $_POST['tour_id'];
$group_id = $_POST['group_id'];
$customer_id = $_POST['customer_id'];
$booking_id = $_POST['booking_id'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$cust_type = $_POST['cust_type'];
$company_name = $_POST['company_name'];

	$query = "select * from tourwise_traveler_details where financial_year_id='$financial_year_id'";
	if($tour_id!=""){
		$query .=" and tour_id='$tour_id'";
	}
	if($group_id!=""){
		$query .=" and tour_group_id='$group_id'";
	}

	if($customer_id!=""){
		$query .=" and customer_id='$customer_id'";
	}

	if($booking_id!=""){
		$query .=" and id='$booking_id'";
	}

	if($from_date!="" && $to_date!=""){
		$from_date = get_date_db($from_date);
		$to_date = get_date_db($to_date);
		$query .= " and date(form_date) between '$from_date' and '$to_date'";
	}		

	if($cust_type != ""){
		$query .= " and customer_id in (select customer_id from customer_master where type = '$cust_type')";
	}

	if($company_name != ""){
		$query .= " and customer_id in (select customer_id from customer_master where company_name = '$company_name')";
	}

	if($role == "B2b"){
		$query .= " and emp_id='$emp_id' ";
	}
	include "../../model/app_settings/branchwise_filteration.php";
 
		$query .= " order by id desc";
		$sq_booking = mysql_query($query);
		$array_s = array();
		$temp_arr = array();
		while($row_booking = mysql_fetch_assoc($sq_booking)){
			$sq_emp =  mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$row_booking[emp_id]'"));
			$emp_name = ($row_booking['emp_id'] != 0) ? $sq_emp['first_name'].' '.$sq_emp['last_name'] : 'Admin';
			$pass_count = mysql_num_rows(mysql_query("select * from  travelers_details where traveler_group_id='$row_booking[id]'"));
			$cancelpass_count = mysql_num_rows(mysql_query("select * from  travelers_details where traveler_group_id='$row_booking[id]' and status='Cancel'"));
			$bg="";
			if($row_booking['tour_group_status']=="Cancel"){
				$bg="danger";
			}
			else{
				if($pass_count==$cancelpass_count){
					$bg="danger";
				}
			}
			$date = $row_booking['form_date'];
			$yr = explode("-", $date);
			$year =$yr[0];

			$sq_tour = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id='$row_booking[tour_id]'"));
			$sq_group = mysql_fetch_assoc(mysql_query("select * from tour_groups where group_id='$row_booking[tour_group_id]'"));

			$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
			$sq_est_info = mysql_fetch_assoc(mysql_query("select * from refund_traveler_estimate where tourwise_traveler_id='$row_booking[id]'"));

			$sq_train = mysql_num_rows(mysql_query("select * from train_master where tourwise_traveler_id='$row_booking[id]'"));
			$sq_plane = mysql_num_rows(mysql_query("select * from plane_master where tourwise_traveler_id='$row_booking[id]'"));
			$sq_visa = $row_booking['visa_amount'];

			$sq_insurance = $row_booking['insuarance_amount'];

			$total_paid = 0;
			$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(amount) as sum,sum(`credit_charges`) as sumc from payment_master where tourwise_traveler_id='$row_booking[id]'and clearance_status!='Cancelled'"));
			$total_paid = $sq_paid_amount['sum'];  
			$credit_card_charges = $sq_paid_amount['sumc'];
			
			$total_paid = ($total_paid == '') ? '0' : $total_paid ;
			$average = 1;

			if($sq_train > 0){ $average++; }
			if($sq_plane > 0){ $average++; }
			if($sq_visa !=0 && $sq_visa!=""){ $average++; }
			if($sq_insurance !=0 && $sq_insurance!=""){ $average++; }

			$tour = $sq_tour['tour_name'];
			$group = get_date_user($sq_group['from_date']).' to '.get_date_user($sq_group['to_date']);

			$sq_est_count = mysql_num_rows(mysql_query("select * from refund_tour_estimate where tourwise_traveler_id='$row_booking[id]'"));
			if($sq_est_count!='0'){
				$sq_tour_refund = mysql_fetch_assoc(mysql_query("select * from refund_tour_estimate where tourwise_traveler_id='$row_booking[id]'"));
				$cancel_tour_amount=$sq_tour_refund['cancel_amount'];
			}
			else{
				$sq_tour_refund = mysql_fetch_assoc(mysql_query("select * from refund_traveler_estimate where tourwise_traveler_id='$row_booking[id]'"));
				$cancel_tour_amount=$sq_tour_refund['cancel_amount'];
			}

			$invoice_no = get_group_booking_id($row_booking['id'],$year);
			$invoice_date = date('d-m-Y',strtotime($row_booking['form_date']));
			$customer_id = $row_booking['customer_id'];
			$service_name = "Group Invoice";

			//Net amount
			$net_total = 0;
			$tour_total_amount= ($row_booking['total_tour_fee']!="") ? $row_booking['total_tour_fee']: 0;
			$net_total  =$row_booking['net_total'] - $cancel_tour_amount+$credit_card_charges;
			//**Service Tax

			$taxation_type = $row_booking['taxation_type'];

			//basic amount
			$train_expense = $row_booking['train_expense'];
			$plane_expense = $row_booking['plane_expense'];
			$cruise_expense = $row_booking['cruise_expense'];
			$visa_amount = $row_booking['visa_amount'];
			$insuarance_amount = $row_booking['insuarance_amount'];
			$tour_subtotal = $row_booking['tour_fee_subtotal_1'] - $cancel_tour_amount;
			$basic_cost = $train_expense +$plane_expense +$cruise_expense +$visa_amount +$insuarance_amount +$tour_subtotal;

			//Service charge	
			$train_service_charge = $row_booking['train_service_charge'];
			$plane_service_charge = $row_booking['plane_service_charge'];
			$cruise_service_charge = $row_booking['cruise_service_charge'];
			$visa_service_charge = $row_booking['visa_service_charge'];
			$insuarance_service_charge = $row_booking['insuarance_service_charge'];
			$service_charge = $train_service_charge +$plane_service_charge +$cruise_service_charge +$visa_service_charge +$insuarance_service_charge;

			//service tax
			$train_service_tax = $row_booking['train_service_tax'];
			$plane_service_tax = $row_booking['plane_service_tax'];
			$cruise_service_tax = $row_booking['cruise_service_tax'];
			$visa_service_tax = $row_booking['visa_service_tax'];
			$insuarance_service_tax = $row_booking['insuarance_service_tax'];
			$tour_service_tax = $row_booking['service_tax_per'];
			
			//service tax subtotal	
			$train_service_tax_subtotal = $row_booking['train_service_tax_subtotal'];
			$plane_service_tax_subtotal = $row_booking['plane_service_tax_subtotal'];
			$cruise_service_tax_subtotal = $row_booking['cruise_service_tax_subtotal'];
			$visa_service_tax_subtotal = $row_booking['visa_service_tax_subtotal'];
			$insuarance_service_tax_subtotal = $row_booking['insuarance_service_tax_subtotal'];
			$tour_service_tax_subtotal = $row_booking['service_tax'];
			$service_tax_subtotal = $train_service_tax_subtotal +$plane_service_tax_subtotal +$cruise_service_tax_subtotal +$visa_service_tax_subtotal +$insuarance_service_tax_subtotal+$tour_service_tax_subtotal;	
			
			$sq_sac = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Group Tour'"));   
			$sac_code = $sq_sac['hsn_sac_code'];
			$tour_date = get_date_user($sq_group['from_date']);
			$booking_id = $row_booking['id'];
			if($app_invoice_format == 4)			
			$url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/git_fit_tax_invoice.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&basic_cost=$basic_cost&taxation_type=$taxation_type&train_expense=$train_expense&plane_expense=$plane_expense&cruise_expense=$cruise_expense&visa_amount=$visa_amount&insuarance_amount=$insuarance_amount&tour_subtotal=$tour_subtotal&train_service_charge=$train_service_charge&plane_service_charge=$plane_service_charge&cruise_service_charge=$cruise_service_charge&visa_service_charge=$visa_service_charge&insuarance_service_charge=$insuarance_service_charge&train_service_tax=$train_service_tax&plane_service_tax=$plane_service_tax&cruise_service_tax=$cruise_service_tax&visa_service_tax=$visa_service_tax&insuarance_service_tax=$insuarance_service_tax&tour_service_tax=$tour_service_tax&train_service_tax_subtotal=$train_service_tax_subtotal&plane_service_tax_subtotal=$plane_service_tax_subtotal&cruise_service_tax_subtotal=$cruise_service_tax_subtotal&visa_service_tax_subtotal=$visa_service_tax_subtotal&insuarance_service_tax_subtotal=$insuarance_service_tax_subtotal&tour_service_tax_subtotal=$tour_service_tax_subtotal&total_paid=$total_paid&net_total=$net_total&sac_code=$sac_code&branch_status=$branch_status&pass_count=$pass_count&tour_date=$tour_date&tour_name=$tour&booking_id=$booking_id&credit_card_charges=$credit_card_charges";
			else
			$url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/git_fit_body_html.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&basic_cost=$basic_cost&taxation_type=$taxation_type&train_expense=$train_expense&plane_expense=$plane_expense&cruise_expense=$cruise_expense&visa_amount=$visa_amount&insuarance_amount=$insuarance_amount&tour_subtotal=$tour_subtotal&train_service_charge=$train_service_charge&plane_service_charge=$plane_service_charge&cruise_service_charge=$cruise_service_charge&visa_service_charge=$visa_service_charge&insuarance_service_charge=$insuarance_service_charge&train_service_tax=$train_service_tax&plane_service_tax=$plane_service_tax&cruise_service_tax=$cruise_service_tax&visa_service_tax=$visa_service_tax&insuarance_service_tax=$insuarance_service_tax&tour_service_tax=$tour_service_tax&train_service_tax_subtotal=$train_service_tax_subtotal&plane_service_tax_subtotal=$plane_service_tax_subtotal&cruise_service_tax_subtotal=$cruise_service_tax_subtotal&visa_service_tax_subtotal=$visa_service_tax_subtotal&insuarance_service_tax_subtotal=$insuarance_service_tax_subtotal&tour_service_tax_subtotal=$tour_service_tax_subtotal&total_paid=$total_paid&net_total=$net_total&sac_code=$sac_code&branch_status=$branch_status&tour_name=$tour&booking_id=$booking_id&credit_card_charges=$credit_card_charges";

			// Booking Form
			$b_url = BASE_URL."model/app_settings/print_html/booking_form_html/group_tour.php?booking_id=$row_booking[id]&branch_status=$branch_status&year=$year&credit_card_charges=$credit_card_charges";


			$temp_arr = array( "data" => array(
				(int)(++$count),
				get_group_booking_id($row_booking['id'],$year),
				($sq_customer['type'] == 'Corporate') ? $sq_customer['company_name'] : $sq_customer['first_name'].' '.$sq_customer['last_name'],
				$tour,
				$emp_name,
				'<a onclick="loadOtherPage(\''. $b_url .'\')" data-toggle="tooltip" class="btn btn-info btn-sm" title="Download Confirmation Form"><i class="fa fa-print"></i></a>

				<a onclick="loadOtherPage(\''.$url1 .'\')" class="btn btn-info btn-sm" data-toggle="tooltip" title="Download Invoice"><i class="fa fa-print"></i></a>

				<form style="display:inline-block" action="booking_update/booking_update.php" id="frm_booking_'.$count.'" method="POST">
					<input type="hidden" id="booking_id" style="display:inline-block" name="booking_id" value="'.$row_booking['id'].'">
                    <input type="hidden" id="branch_status" name="branch_status" style="display:inline-block" value="'.$branch_status .'" >
					<button data-toggle="tooltip" class="btn btn-info btn-sm" style="display:inline-block" title="Update Details"><i class="fa fa-pencil-square-o"></i></button>
				</form>

				<button  data-toggle="tooltip" class="btn btn-info btn-sm" style="display:inline-block" onclick="display_modal(\''.$row_booking['id'] .'\')" title="View Details"><i class="fa fa-eye"></i></button>'), "bg" => $bg
			  );
  			array_push($array_s,$temp_arr); 

		}
		echo json_encode($array_s);
?>

