<?php
include "../../../../model/model.php";
global $app_quot_format;

$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$booking_type = $_POST['booking_type'];
$tour_name = $_POST['tour_name'];
$quotation_id = $_POST['quotation_id'];
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_status = $_POST['branch_status'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$branch_id = $_POST['branch_id'];

$query = "select * from group_tour_quotation_master where financial_year_id='$financial_year_id'";
if($from_date!='' && $to_date!=""){

	$from_date = date('Y-m-d', strtotime($from_date));
	$to_date = date('Y-m-d', strtotime($to_date));

	$query .= " and created_at between '$from_date' and '$to_date' "; 
}
if($booking_type!=''){
	$query .= " and booking_type='$booking_type'";
}
if($tour_name!=''){
	$query .= " and tour_name='$tour_name'";
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
	$array_s = array();
	$temp_arr = array();
	$sq_quotation = mysql_query($query);
	while($row_quotation = mysql_fetch_assoc($sq_quotation)){
		$bg = ($row_quotation['clone'] == 'yes') ? 'warning' : '';

		$sq_cost =  mysql_fetch_assoc(mysql_query("select * from package_tour_quotation_costing_entries where quotation_id = '$row_quotation[quotation_id]'"));
		$sq_emp =  mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$row_quotation[emp_id]'"));
		$emp_name = ($row_quotation['emp_id'] != 0) ? $sq_emp['first_name'].' '.$sq_emp['last_name'] : 'Admin';
		
		$quotation_date = $row_quotation['quotation_date'];
		$yr = explode("-", $quotation_date);
		$year =$yr[0];
		//Proforma Invoice
		$for = 'Group Tour'; 
		$invoice_no = get_quotation_id($row_quotation['quotation_id'],$year);
		$invoice_date = get_date_user($row_quotation['created_at']);
		$customer_id = $row_quotation['customer_name'];
		$customer_email = $row_quotation['email_id'];
		$service_name = "Proforma Invoice";

							//**Basic Cost
		$basic_cost = $row_quotation['tour_cost'] + $row_quotation['service_charge'];
		//GST
		$service_tax =  $row_quotation['service_tax_subtotal'];
	// 	var service_tax_amount = 0;
	// if ($service_tax_subtotal !== 0.0 && $service_tax_subtotal !== '') {
	// 	$service_tax_subtotal1 = $service_tax_subtotal.split(',');
	// 	for ($i = 0; i < $service_tax_subtotal1.length; i++) {
	// 		var service_tax = service_tax_subtotal1[i].split(':');
	// 		service_tax_amount = parseFloat(service_tax_amount) + parseFloat(service_tax[2]);
	// 	}
	// }
		
		// Travel + visa
		$travel_cost = 0;
		//Net cost
		$net_amount = $row_quotation['quotation_cost'];

		$p_url = BASE_URL."model/app_settings/print_html/invoice_html/body/proforma_invoice_html.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&customer_email=$customer_email&service_name=$service_name&basic_cost=$basic_cost&service_tax=$service_tax&net_amount=$net_amount&travel_cost=$travel_cost&for=$for";
							
		$quotation_id = $row_quotation['quotation_id'];
		if($app_quot_format == 2){
			$url1 = BASE_URL."model/app_settings/print_html/quotation_html/quotation_html_2/git_quotation_html.php?quotation_id=$quotation_id";
		}
		else if($app_quot_format == 3){
			$url1 = BASE_URL."model/app_settings/print_html/quotation_html/quotation_html_3/git_quotation_html.php?quotation_id=$quotation_id";
		}
		else if($app_quot_format == 4){
			$url1 = BASE_URL."model/app_settings/print_html/quotation_html/quotation_html_4/git_quotation_html.php?quotation_id=$quotation_id";
		}
		else if($app_quot_format == 5){
			$url1 = BASE_URL."model/app_settings/print_html/quotation_html/quotation_html_5/git_quotation_html.php?quotation_id=$quotation_id";
		}
		else if($app_quot_format == 6){
			$url1 = BASE_URL."model/app_settings/print_html/quotation_html/quotation_html_6/git_quotation_html.php?quotation_id=$quotation_id";
		}
		else{
			$url1 = BASE_URL."model/app_settings/print_html/quotation_html/quotation_html_1/git_quotation_html.php?quotation_id=$quotation_id";
		} 
		$whatsapp_tooltip_change = ($whatsapp_switch == "on") ? 'Email and What\'sApp Quotation to Customer' : "Email Quotation to Customer";
		$temp_arr = array( "data" => array(
			(int)(++$count),
			get_quotation_id($row_quotation['quotation_id'],$year),
			$row_quotation['tour_name'],
			$row_quotation['customer_name'],
			get_date_user($row_quotation['quotation_date']),
			number_format($row_quotation['quotation_cost'],2),
			$emp_name,
			'<a onclick="loadOtherPage(\''.$url1.'\')" data-toggle="tooltip" class="btn btn-info btn-sm" title="Download Quotation PDF"><i class="fa fa-print"></i></a>

			<a onclick="loadOtherPage(\''. $p_url .'\')" data-toggle="tooltip"  class="btn btn-info btn-sm" title="Download Proforma PDF"><i class="fa fa-print"></i></a>

			<a href="javascript:void(0)" id="btn_email_'.$count.'" class="btn btn-info btn-sm" onclick="quotation_email_send(this.id, '.$row_quotation['quotation_id'].')" title="'.$whatsapp_tooltip_change.'"><i class="fa fa-envelope-o"></i></a>

			<button class="btn btn-warning btn-sm" data-toggle="tooltip" onclick="quotation_clone('.$row_quotation['quotation_id'].')" title="Create copy of this quotation"><i class="fa fa-files-o"></i></button>

			<a href="javascript:void(0)" title="Email Quotation to Backoffice" id="btn_email1_'.$count.'" class="btn btn-info btn-sm" onclick="quotation_email_send_backoffice_modal('.$row_quotation['quotation_id'].')"><i class="fa fa-paper-plane-o"></i></a>
			
			<button class="btn btn-info btn-sm" data-toggle="tooltip" onclick="update_modal(\''.$row_quotation['quotation_id'].'\',\''.$row_quotation['package_id'].'\')" title="Update Details"><i class="fa fa-pencil-square-o"></i></button>

			<a href="quotation_view.php?quotation_id='.$row_quotation['quotation_id'].'" target="_BLANK" class="btn btn-info btn-sm" title="View Details"><i class="fa fa-eye"></i></a>',

		  ), "bg" =>$bg);
		array_push($array_s,$temp_arr); 
		}
echo json_encode($array_s);
?>