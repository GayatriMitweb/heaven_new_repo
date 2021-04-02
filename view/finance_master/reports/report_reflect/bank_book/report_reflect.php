<?php
include "../../../../../model/model.php";

$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$bank_id = $_POST['bank_id'];
$branch_status = $_POST['branch_status'];
$branch_admin_id = $_POST['branch_admin_id'];
$role = $_POST['role'];
$array_s = array();
$temp_arr = array();
$total_arr = array();
$query = "select * from bank_cash_book_master where  clearance_status!='Cancelled' and payment_type='Bank' ";
if($bank_id!=""){
	$query .=" and bank_id='$bank_id'";	
}
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

//Opening Balance Get
$opening_bal = get_bank_book_opening_balance($bank_id);

$transaction_bal = 0;
if(($from_date!="" && $to_date!="")){
	$sq_credit = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from bank_cash_book_master where payment_date<'$from_date' and payment_type='Bank' and payment_side='Credit' and  clearance_status!='Cancelled'"));
	$sq_debit = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from bank_cash_book_master where payment_date<'$from_date' and payment_type='Bank' and payment_side='Debit' and  clearance_status!='Cancelled'"));

	$transaction_bal = $sq_credit['sum'] - $sq_debit['sum'];
}
$opening_bal = $opening_bal+$transaction_bal;
	 	$closing_bal = $opening_bal;
	 	$count = 0;
		 $sq = mysql_query($query);
		 $total_arr = array (0 => array("data" => array("","","","","","","","","","","<strong>Opening_Balance</strong>", number_format($opening_bal,2)), "bg" => "warning"));
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

	 		$sq_bank_info = mysql_fetch_assoc(mysql_query("select * from bank_master where bank_id='$row[bank_id]'"));
	 		
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
					$row['transaction_id'],
					$sq_bank_info['bank_name'].'('.$sq_bank_info['branch_name'].')',
					$row['particular'],
					$debit_amount,
					$credit_amount,
					number_format($closing_bal,2)
					), "bg" =>$bg);
					array_push($total_arr, $temp_arr);
	 		
			 }
		 }
		 $footer_data = array("footer_data" => array(
			'total_footers' => 2,
			
			'foot0' => "Closing Balance",
			'col0' => 11,
			'class0' =>"text-right",
	
			'foot1' =>number_format($closing_bal,2),
			'col1' => 1,
			'class1' =>""
			)
		);
		array_push($total_arr, $footer_data);
		echo json_encode($total_arr);
	 ?>