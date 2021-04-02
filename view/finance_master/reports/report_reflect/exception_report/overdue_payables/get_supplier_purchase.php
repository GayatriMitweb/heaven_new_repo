<?php
include "../../../../../../model/model.php";
$vendor_type = $_POST['party_name'];
$role = $_POST['role'];
$branch_admin_id = $_POST['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$till_date = date('Y-m-d');
$till_date1 = get_date_user($till_date);
$array_s = array();
$temp_arr = array();
$count=1;
$q = "select * from vendor_estimate where 1 ";
if($vendor_type != ''){
	$q .= " and vendor_type = '$vendor_type' ";
}
if($vendor_type_id != ''){
	$q .= " and vendor_type_id='$vendor_type_id'";
}
if($branch_status=='yes'){
	if($role=='Branch Admin'){
	$q .= " and branch_admin_id = '$branch_admin_id'";
	}	
	elseif($role!='Admin' && $role!='Branch Admin'){
    $q .= " and emp_id='$emp_id'";
    }
} 	

$q .= " group by vendor_type, vendor_type_id";
$sq_supplier = mysql_query($q);
while($row_supplier = mysql_fetch_assoc($sq_supplier))
{	
	$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_due = 0;
	$due_date_arr = array();

	$sq_pacakge = mysql_query("select * from vendor_estimate where vendor_type='$row_supplier[vendor_type]' and vendor_type_id ='$row_supplier[vendor_type_id]' ");
	while($row_package = mysql_fetch_assoc($sq_pacakge))
	{
		$booking_amt =0; $total_paid = 0; $cancel_est = 0; $total_outstanding = 0;
		$booking_amt = $row_package['net_total'];
		$total_pay=mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from vendor_payment_master where vendor_type='$row_package[vendor_type]' and vendor_type_id ='$row_package[vendor_type_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
		$total_paid = $total_pay['sum'];
		$cancel_est = $row_package['cancel_amount'];

		//Consider sale cancel amount
		if($cancel_est != '0'){ 			
			if($cancel_est <= $total_paid){
				$pending_amt  = 0;
			}
			else{
				$pending_amt =  $cancel_est - $total_paid;
			}
		}
		else{
			$pending_amt = $booking_amt-$total_paid;
		}

		
		if($pending_amt>'0'){		
			$due_date = get_date_user($row_package['due_date']);
			array_push($due_date_arr, $due_date);
			if(strtotime($till_date1) >= strtotime($due_date)) {
				$total_due += $pending_amt;
			}
		}

	}
	$supplier_name = get_vendor_name_report($row_supplier['vendor_type'], $row_supplier['vendor_type_id']);

	if($total_due>'0'){
		$temp_arr = array( "data" => array(
			(int)($count++),
			$row_supplier['vendor_type'],
			$supplier_name ,
			number_format($total_due,2) ,
			max($due_date_arr)
			
		), "bg" =>$bg);
	array_push($array_s,$temp_arr);
	
	}
} 
echo json_encode($array_s);
?>