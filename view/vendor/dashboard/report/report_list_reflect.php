<?php 
include_once('../../../../model/model.php');

include_once('../../inc/vendor_generic_functions.php');
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status']; 
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$estimate_type = $_POST['estimate_type'];
$vendor_type = $_POST['vendor_type'];
$estimate_type_id = $_POST['estimate_type_id'];
$vendor_type_id = $_POST['vendor_type_id'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$array_s = array();
$temp_arr = array();
$query = "select estimate_type, estimate_type_id, vendor_type, vendor_type_id, created_at as date, net_total as credit, '' as debit from vendor_estimate where 1 ";
if($estimate_type!=""){
	$query .= " and estimate_type='$estimate_type' ";
}
if($vendor_type!=""){
	$query .= " and vendor_type='$vendor_type' ";
}
if($estimate_type_id!=""){
	$query .= " and estimate_type_id='$estimate_type_id' ";
}
if($vendor_type_id!=""){
	$query .= " and vendor_type_id='$vendor_type_id' ";
}
if($vendor_type!="" && $vendor_type_id!=""){
	$data = get_opening_bal($vendor_type , $vendor_type_id);
	$opening_bal = $data['opening_balance'];
	$side = $data['side'];
}
if($from_date!="" && $to_date!=""){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and purchase_date between '$from_date' and '$to_date'";
}

include "../../../../model/app_settings/branchwise_filteration.php";
$query .= " union ";

$query .= "select '' as estimate_type, '' as estimate_type_id, vendor_type, vendor_type_id, payment_date as date1, '' as credit1, payment_amount as debit1 from vendor_payment_master where clearance_status!='Pending' AND clearance_status!='Cancelled' ";
if($vendor_type!=""){
	$query .= " and vendor_type='$vendor_type' ";
}
if($vendor_type_id!=""){
	$query .= " and vendor_type_id='$vendor_type_id' ";
} 
if($estimate_type!=""){
	$query .= " and estimate_type='$estimate_type'";
}
if($estimate_type_id!=""){
	$query .= " and estimate_type_id='$estimate_type_id'";
}
if($from_date!="" && $to_date!=""){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and payment_date between '$from_date' and '$to_date'";
}
include "../../../../model/app_settings/branchwise_filteration.php";

$query .=" order by date desc";
$sq_estimate = mysql_query($query);
?>

		<?php 
		$total_estimate_amt = 0;
		$count = 0;		
		$total_arr = array (0 => array("data" => array("","","","","","","<strong>Opening_Balance(".$side.")</strong>", number_format($opening_bal,2)), "bg" => "warning"));
		while($row_report = mysql_fetch_assoc($sq_estimate)){

			$total_estimate_amt = $total_estimate_amt + $row_report['credit'];
			$vendor_type_val = get_vendor_name($row_report['vendor_type'], $row_report['vendor_type_id']);

			if($side == 'Cr'){
				$total_amount = ($total_estimate_amt);
			}else{
				$total_amount = ($total_estimate_amt);
			}
			if($row_report['debit'] != ''){
				$sq_pay1 = mysql_fetch_assoc(mysql_query("select * from vendor_payment_master where vendor_type='$row_report[vendor_type]' and vendor_type_id = '$row_report[vendor_type_id]'"));
				$estimate_type_val = get_estimate_type_name($sq_pay1['estimate_type'], $sq_pay1['estimate_type_id']);
			    $estimate_type = $sq_pay1['estimate_type']; 
			}
			else{
				$estimate_type_val = get_estimate_type_name($row_report['estimate_type'], $row_report['estimate_type_id']);
				$estimate_type = $row_report['estimate_type'];
			}
			$total_paid_amt += $row_report['debit'];
			if($total_paid_amt==""){ $total_paid_amt = 0; }
			
			$temp_arr = array( "data" => array(
				(int)(++$count),
				($estimate_type == '') ?'NA': $estimate_type,
				($estimate_type_val == '') ? 'NA' : $estimate_type_val,
				$row_report['vendor_type'],
				$vendor_type_val,
				date('d/m/Y', strtotime($row_report['date'])),
				$row_report['credit'],
				$row_report['debit']
				
			
				), "bg" =>$bg);
			array_push($total_arr,$temp_arr); 
		
			
		}
		if($total_estimate_amt >= $total_paid_amt){
			$side1='(Cr)';
		}
		else {	
			$side1='(Dr)';
		}
		if($side == 'Credit'){
			$total_amount = $total_amount + $opening_bal - $total_paid_amt;
		}else{
			$total_amount = $total_amount - $opening_bal - $total_paid_amt;
		}
		if($total_amount <= 0) {
			$total_amount = ($total_amount) - ($total_amount) - ($total_amount);
		}

		$footer_data = array("footer_data" => array(
			'total_footers' => 3,
					
			'foot0' => "Total Costing : ".number_format($total_estimate_amt, 2),
			'col0' => 4,
			'class0' => "text-right info",
			
			'foot1' => "Total Paid : ".number_format($total_paid_amt, 2),
			'col1' => 2,
			'class1' => "text-right success",
		
			'foot2' => "Closing Balance :".number_format($total_amount, 2),
			'col2' => 2,
			'class2' => "text-right warning"
		
			)
		);
		array_push($total_arr, $footer_data);
		echo json_encode($total_arr);
		?>
	
