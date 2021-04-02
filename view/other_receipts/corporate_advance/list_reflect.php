<?php
include "../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];

$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$cust_id = $_POST['cust_id'];
$branch_status = $_POST['branch_status'];
$financial_year_id = $_POST['financial_year_id'];

$query = "select * from  corporate_advance_master where payment_amount!='0' ";
if($from_date!="" && $to_date!=""){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);

	$query .= " and payment_date between '$from_date' and '$to_date'";
}
if($cust_id!=""){
	$query .= " and cust_id='$cust_id' ";
}
if($financial_year_id!=""){
	$query .=" and financial_year_id='$financial_year_id'";
}
if($branch_status=='yes' && $role!='Admin'){
	$query .= " and branch_admin_id = '$branch_admin_id'";
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
$query .= " and emp_id='$emp_id'";
}
$query .= " order by advance_id desc";
$array_s = array();
		$temp_arr = array();
		$footer_data = array();
		$count = 0;
		$bg;
		$sq_pending_amount=0;
		$sq_cancel_amount=0;
		$sq_paid_amount=0;
		$Total_payment=0;
		$sq_income = mysql_query($query);
		while($row_income = mysql_fetch_assoc($sq_income)){

			$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_income[cust_id]'"));
			if($sq_cust['type'] == 'Corporate'){
				$customer_name = $sq_cust['company_name'];
			}else{
				$customer_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
			}
			$sq_paid_amount = $sq_paid_amount + $row_income['payment_amount'];
			if($row_income['clearance_status']=="Pending"){ 
				$bg = 'warning';
				$sq_pending_amount = $sq_pending_amount + $row_income['payment_amount'];
			}
			else if($row_income['clearance_status']=="Cancelled"){ 
				$bg = 'danger';
				$sq_cancel_amount = $sq_cancel_amount + $row_income['payment_amount'];
			}
			else{
				$bg = '';
			}
			 
			$temp_arr = array( "data" => array(
				(int)(++$count),
				$customer_name,
				get_date_user($row_income['payment_date']),
				$row_income['payment_mode'],
				$row_income['particular'],
				$row_income['payment_amount']));

				if($role == 'Branch Admin' || $role == 'Admin'){
					array_push($temp_arr['data'], '<button data-toggle="tooltip" title="Edit Details" class="btn btn-info btn-sm" onclick="update_income_modal('.$row_income['advance_id'] .')"><i class="fa fa-pencil-square-o"></i></button>');
				}
			
			  $temp_arr["bg"] = $bg ;
			  array_push($array_s,$temp_arr); 
			}
			  $footer_data = array("footer_data" => array(
				'total_footers' => 4,
				'foot0' => "Total Amount: ".number_format((($sq_paid_amount=="") ? 0 : $sq_paid_amount), 2),
				'col0' => 2,
				'class0' => "info",
				'foot1' => "Pending Clearance : ".number_format((($sq_pending_amount=="") ? 0 : $sq_pending_amount), 2),
				'col1' => 2,
				'class1' => "warning",
				'foot2' =>  "Cancelled : ".number_format((($sq_cancel_amount=="") ? 0 : $sq_cancel_amount), 2),
				'col2' => 1,
				'class2' => "danger",
				'foot3' => "Total Paid : ".number_format(($sq_paid_amount - $sq_pending_amount - $sq_cancel_amount), 2),
				'col3' => 2,
				'class3' => "success"
				)
			);
			  
			  array_push($array_s, $footer_data);	
			  echo json_encode($array_s);	
			?>
