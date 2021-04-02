<?php
include "../../../../../model/model.php";

$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$branch_status = $_POST['branch_status'];
$branch_admin_id = $_POST['branch_admin_id'];
$role = $_POST['role'];
$array_s = array();
$temp_arr = array();
$query = "select * from bank_cash_book_master where clearance_status!='Cancelled' and payment_type='Cash'";

if($from_date!="" && $to_date!=""){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);

	$query .=" and payment_date between '$from_date' and '$to_date'";
}
if($branch_status == 'yes'){
	if($role == 'Branch Admin'){
		$query .= " and branch_admin_id='$branch_admin_id'";
	}
}

	 	$closing_bal = 0;
	 	$count = 0;
	 	$sq = mysql_query($query);
	 	while($row = mysql_fetch_assoc($sq)){

	 		if($row['payment_side']=="Credit"){
	 			$credit_amount = $row['payment_amount'];	
	 			$debit_amount = "";
	 			$closing_bal = $closing_bal - $credit_amount;
	 		}
	 		if($row['payment_side']=="Debit"){
	 			$credit_amount = "";	
	 			$debit_amount = $row['payment_amount'];
	 			$closing_bal = $closing_bal + $debit_amount;
	 		}
	 		if($row['payment_amount'] != 0){
	 		$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row[emp_id]'"));
	 		$emp_name = ($row['emp_id'] != 0) ? $sq_emp['first_name'].' '.$sq_emp['last_name']: 'Admin';
			 
			 $temp_arr = array( "data" => array(
				(int)(++$count),
				$row['module_name'],
				$row['module_entry_id'],
				$emp_name ,
				$row['payment_amount'] ,
				get_date_user($row['payment_date']),
				$row['particular'],
				$debit_amount,
				$credit_amount,
				number_format($closing_bal,2)
				), "bg" =>$bg);
				array_push($array_s, $temp_arr);
			
			 }
	 	}
		 $footer_data = array("footer_data" => array(
			'total_footers' => 2,
			
			'foot0' => "Closing Balance",
			'col0' => 9,
			'class0' =>"text-right",
	
			'foot1' =>number_format($closing_bal,2),
			'col1' => 1,
			'class1' =>""
			)
		);
		array_push($array_s, $footer_data);
		echo json_encode($array_s);
	?>