<?php
include "../../../../model/model.php";
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$booking_type = $_POST['booking_type'];
$package_id = $_POST['package_id'];
$quotation_id = $_POST['quotation_id'];
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_status = $_POST['branch_status'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$branch_id = $_POST['branch_id'];

global $app_quot_format;

$query = "select * from package_tour_quotation_master where financial_year_id='$financial_year_id' ";
if($from_date!='' && $to_date!=""){

	$from_date = date('Y-m-d', strtotime($from_date));
	$to_date = date('Y-m-d', strtotime($to_date));

	$query .= " and created_at between '$from_date' and '$to_date' "; 
}
if($booking_type!=''){
	$query .= " and booking_type='$booking_type'";
}
if($package_id!=''){
	$query .= " and package_id in(select package_id from custom_package_master where package_id = '$package_id')";
}
if($quotation_id!=''){
	$query .= " and quotation_id='$quotation_id'";

}
if($branch_status=='yes'){
	if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
	    $query .= " and branch_admin_id = '$branch_admin_id'";
	}
	elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
	    $query .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
	}
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
	$query .= " and emp_id='$emp_id'";
}
if($branch_id!=""){
	$query .= " and branch_admin_id = '$branch_id'";
}
$query .=" order by quotation_id desc ";

$count = 0;
$quotation_cost = 0;
$row_quotation1 = mysql_query($query);
$array_s = array();
$temp_arr = array();
while($row_quotation = mysql_fetch_assoc($row_quotation1)){
	
	$bg = ($row_quotation['clone'] == 'yes') ? 'warning' : '';
	$sq_emp =  mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$row_quotation[emp_id]'"));
	$emp_name = ($row_quotation['emp_id'] != 0) ? $sq_emp['first_name'].' '.$sq_emp['last_name'] : 'Admin';
	$quotation_date = $row_quotation['quotation_date'];
	$yr = explode("-", $quotation_date);
	$year =$yr[0];

	$sq_cost =  mysql_fetch_assoc(mysql_query("select * from package_tour_quotation_costing_entries where quotation_id = '$row_quotation[quotation_id]'"));
	$sq_package_program = mysql_fetch_assoc(mysql_query("select * from custom_package_master where package_id ='$row_quotation[package_id]'"));
	
	$basic_cost = $sq_cost['basic_amount'];
	$service_charge = $sq_cost['service_charge'];
	$tour_cost= $basic_cost + $service_charge;
	$service_tax_amount = 0;
	$tax_show = '';
	$bsmValues = json_decode($sq_cost['bsmValues']);
	
	if($sq_cost['service_tax_subtotal'] !== 0.00 && ($sq_cost['service_tax_subtotal']) !== ''){
	$service_tax_subtotal1 = explode(',',$sq_cost['service_tax_subtotal']);
	for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
		$service_tax = explode(':',$service_tax_subtotal1[$i]);
		$service_tax_amount +=  $service_tax[2];
		$name .= $service_tax[0] . ' ';
		$percent = $service_tax[1];
	}
	}
	if($bsmValues[0]->service != ''){   //inclusive service charge
	$newBasic = $tour_cost + $service_tax_amount;
	$tax_show = '';
	}
	else{
	// $tax_show = $service_tax_amount;
	$tax_show =  $name . $percent. ($service_tax_amount);
	$newBasic = $tour_cost;
	}

	////////////Basic Amount Rules
	if($bsmValues[0]->basic != ''){ //inclusive markup
	$newBasic = $tour_cost + $service_tax_amount;
	$tax_show = '';
	}

	$quotation_cost = $basic_cost +$service_charge+ $service_tax_amount+ $row_quotation['train_cost'] + $row_quotation['cruise_cost']+ $row_quotation['flight_cost'] + $row_quotation['visa_cost'] + $row_quotation['guide_cost'] + $row_quotation['misc_cost'];

	//Proforma Invoice
	$for = 'Package Tour'; 
	$invoice_no = get_quotation_id($row_quotation['quotation_id'],$year);
	$invoice_date = get_date_user($row_quotation['created_at']);
	$customer_id = $row_quotation['customer_name'];
	$customer_email = $row_quotation['email_id'];
	$service_name = "Proforma Invoice";

						//**Basic Cost
	$basic_cost = $sq_cost['tour_cost'] + $sq_cost['markup_subtotal'] + $sq_cost['transport_cost'] + $sq_cost['excursion_cost'];

						//GST
	$service_tax =  $sq_cost['service_tax_subtotal'];

						// Travel + visa
	$travel_cost = $row_quotation['train_cost']+ $row_quotation['flight_cost'] + $row_quotation['cruise_cost'] + $row_quotation['visa_cost'] + $row_quotation['guide_cost'] + $row_quotation['misc_cost'];

						//Net cost
	$net_amount = $sq_cost['total_tour_cost'] + $row_quotation['train_cost']+ $row_quotation['flight_cost'] + $row_quotation['visa_cost'] + $row_quotation['guide_cost'] + $row_quotation['misc_cost'] + $row_quotation['cruise_cost'];

	$quotation_id = $row_quotation['quotation_id'];
	$p_url = BASE_URL."model/app_settings/print_html/invoice_html/body/proforma_invoice_html.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&customer_email=$customer_email&service_name=$service_name&basic_cost=$basic_cost&service_tax=$service_tax&net_amount=$net_amount&travel_cost=$travel_cost&for=$for";

	if($app_quot_format == 2){
		$url1 = BASE_URL."model/app_settings/print_html/quotation_html/quotation_html_2/fit_quotation_html.php?quotation_id=$quotation_id";
	}
	else if($app_quot_format == 3){
		$url1 = BASE_URL."model/app_settings/print_html/quotation_html/quotation_html_3/fit_quotation_html.php?quotation_id=$quotation_id";
	}
	else if($app_quot_format == 4){
		$url1 = BASE_URL."model/app_settings/print_html/quotation_html/quotation_html_4/fit_quotation_html.php?quotation_id=$quotation_id";
	}
	else if($app_quot_format == 5){
		$url1 = BASE_URL."model/app_settings/print_html/quotation_html/quotation_html_5/fit_quotation_html.php?quotation_id=$quotation_id";
	}
	else if($app_quot_format == 6){
		$url1 = BASE_URL."model/app_settings/print_html/quotation_html/quotation_html_6/fit_quotation_html.php?quotation_id=$quotation_id";
	}
	else{
		$url1 = BASE_URL."model/app_settings/print_html/quotation_html/quotation_html_1/fit_quotation_html.php?quotation_id=$quotation_id";
	}
	$whatsapp_tooltip_change = ($whatsapp_switch == "on") ? 'Email and What\'sApp Quotation to Customer' : "Email Quotation to Customer";
	$temp_arr = array( "data" => array(
		(int)(++$count),
		get_quotation_id($row_quotation['quotation_id'],$year),
		$sq_package_program['package_name'],
		$row_quotation['customer_name'],
		get_date_user($row_quotation['quotation_date']),
		number_format($quotation_cost,2),
		$emp_name,
		'<a data-toggle="tooltip" onclick="loadOtherPage(\''.$url1.'\')" class="btn btn-info btn-sm" title="Download Quotation PDF"><i class="fa fa-print"></i></a>

		<a data-toggle="tooltip"  href="javascript:void(0)" id="btn_email_'.$count.'" class="btn btn-info btn-sm" onclick="quotation_email_send(this.id, '.$row_quotation[quotation_id].',\''.$row_quotation['email_id'] .'\',\''.$row_quotation['mobile_no'].'\')" title="'.$whatsapp_tooltip_change.'"><i class="fa fa-envelope-o"></i></a>

		<button data-toggle="tooltip" style="display:inline-block" class="btn btn-warning btn-sm" onclick="quotation_clone('. $row_quotation['quotation_id'] .')" title="Create Copy of this Quotation"><i class="fa fa-files-o"></i></button>

		<a href="javascript:void(0)" id="btn_email1_'.$count.'" title="Mail to Backoffice" class="btn btn-info btn-sm" onclick="quotation_email_send_backoffice_modal('.$row_quotation['quotation_id'].')"><i class="fa fa-paper-plane-o"></i></a>

		<form  style="display:inline-block" action="update/index.php" id="frm_booking_'.$count.'" method="POST">
		<input  style="display:inline-block" type="hidden" id="quotation_id" name="quotation_id" value="'.$row_quotation['quotation_id'].'">
		<input data-toggle="tooltip" style="display:inline-block" type="hidden" id="package_id" name="package_id" value="'.$row_quotation['package_id'].'">

		<button data-toggle="tooltip"  style="display:inline-block" class="btn btn-info btn-sm" title="Edit Details"><i class="fa fa-pencil-square-o"></i></button>
		</form>

		<a data-toggle="tooltip" style="display:inline-block" href="quotation_view.php?quotation_id='.$row_quotation['quotation_id'].'" target="_BLANK" class="btn btn-info btn-sm" title="View Details"><i class="fa fa-eye"></i></a>'
	
	), "bg" =>$bg);
	array_push($array_s,$temp_arr); 
}
echo json_encode($array_s);
?>