<?php
$flag = true;
class employee_salary_master{

public function employee_salary_save()
{
	$emp_id = $_POST['emp_id'];
	$year = $_POST['year'];
	$month = $_POST['month'];
	$basic_pay = $_POST['basic_pay'];
	$dear_allow = $_POST['dear_allow'];
	$hra = $_POST['hra'];
	$travel_allow = $_POST['travel_allow'];
	$medi_allow = $_POST['medi_allow'];
	$special_allow = $_POST['special_allow'];
	$uniform_allowance = $_POST['uniform_allowance'];
	$incentive = $_POST['incentive'];
	$meal_allowance = $_POST['meal_allowance'];
	$phone_allowance = $_POST['phone_allowance'];
	$misc_earning = $_POST['misc_earning'];
	$salary_advance = $_POST['salary_advance'];
	$loan_ded = $_POST['loan_ded'];
	$surcharge_deduction = $_POST['surcharge_deduction'];
	$cess_deduction = $_POST['cess_deduction'];
	$gross_salary = $_POST['gross_salary'];
	$employee_pf = $_POST['employee_pf'];
	$esic =$_POST['esic'];
	$pt = $_POST['pt'];
	$tds = $_POST['tds'];
	$labour_all = $_POST['labour_all'];
	$employer_pf = $_POST['employer_pf'];
	$leave_deduction = $_POST['leave_deduction'];
	$deduction = $_POST['deduction'];
	$net_salary = $_POST['net_salary'];

	$created_at = date('Y-m-d');

	begin_t(); 
	//Validation employee salary for perticular month gets saved only once 
	$sq_count  = mysql_num_rows(mysql_query("select * from employee_salary_master where emp_id='$emp_id' and year='$year' and month='$month'"));
	if($sq_count == '0')
	{
		$sq_max = mysql_fetch_assoc(mysql_query("select max(salary_id) as max from employee_salary_master"));
		$salary_id = $sq_max['max'] + 1;

		$sq_sal = mysql_query("insert into employee_salary_master(salary_id, emp_id, year, month, basic_pay, dear_allow, hra,travel_allow,medi_allow,special_allow,uniform_allowance,incentive,meal_allowance,gross_salary,employee_pf,esic,pt,tds,labour_all,employer_pf,deduction,net_salary,phone_allowance,misc_earning,salary_advance,loan_ded,surcharge_deduction,cess_deduction, leave_deduction, created_at) values ( '$salary_id', '$emp_id', '$year', '$month', '$basic_pay', '$dear_allow', '$hra','$travel_allow','$medi_allow','$special_allow','$uniform_allowance','$incentive','$meal_allowance','$gross_salary','$employee_pf','$esic','$pt','$tds','$labour_all','$employer_pf','$deduction','$net_salary', '$phone_allowance', '$misc_earning', '$salary_advance', '$loan_ded', '$surcharge_deduction' , '$cess_deduction', '$leave_deduction', '$created_at')");
		 
		if($sq_sal){
			 	commit_t();
				echo "User salary saved!";
				exit;	
			}
		 
		else{
			rollback_t();
			echo "error--Sorry, Salary not saved!";
			exit;
		}
	}else{
        rollback_t();
		echo "error--Sorry, User Salary already added for this month!";
		exit;
	}

}
/////////////////////////////////Update ///////////////////////////////
public function employee_salary_update()
{
	$salary_id = $_POST['salary_id'];
	$basic_pay = $_POST['basic_pay'];
   $dear_allow = $_POST['dear_allow'];
   $hra = $_POST['hra'];
   $travel_allow = $_POST['travel_allow'];
   $medi_allow = $_POST['medi_allow'];
   $special_allow = $_POST['special_allow'];
   $uniform_allowance = $_POST['uniform_allowance'];
   $incentive = $_POST['incentive'];
   $meal_allowance = $_POST['meal_allowance'];
   $phone_allowance = $_POST['phone_allowance'];
   $misc_earning = $_POST['misc_earning'];
   $salary_advance = $_POST['salary_advance'];
   $loan_ded = $_POST['loan_ded'];
   $surcharge_deduction = $_POST['surcharge_deduction'];
   $cess_deduction = $_POST['cess_deduction'];
   $gross_salary = $_POST['gross_salary'];
   $employee_pf = $_POST['employee_pf'];
   $esic =$_POST['esic'];
   $pt = $_POST['pt'];
   $tds = $_POST['tds'];
   $labour_all = $_POST['labour_all'];
   $employer_pf = $_POST['employer_pf'];
   $deduction = $_POST['deduction'];
   $net_salary = $_POST['net_salary'];
   $leave_deduction = $_POST['leave_deduction'];
	 
	begin_t();

	$sq_sal = mysql_query("update employee_salary_master set basic_pay='$basic_pay', dear_allow='$dear_allow', hra='$hra',travel_allow='$travel_allow',medi_allow='$medi_allow',special_allow='$special_allow',uniform_allowance='$uniform_allowance',incentive='$incentive',meal_allowance='$meal_allowance',gross_salary='$gross_salary',employee_pf='$employee_pf',esic='$esic',pt='$pt',tds='$tds',labour_all='$labour_all', employer_pf='$employer_pf', deduction='$deduction' , net_salary='$net_salary', phone_allowance='$phone_allowance', misc_earning='$misc_earning', salary_advance='$salary_advance',loan_ded='$loan_ded',surcharge_deduction='$surcharge_deduction',cess_deduction='$cess_deduction', leave_deduction='$leave_deduction' where salary_id='$salary_id'");
	 
	if($sq_sal){
 
		commit_t();
		echo "Employee salary updated!";
		exit;	
		 
		
	}
	else{
		rollback_t();
		echo "error--Sorry, Salary not updated!";
		exit;
	}

}
/*public function finance_save($salary_id)
{
	$login_id = $_POST['login_id'];
	$year = $_POST['year'];
	$month = $_POST['month'];
	$salary_amount = $_POST['salary_amount'];
	$payment_date = $_POST['payment_date'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id1 = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];

	$payment_date = date('Y-m-d', strtotime($payment_date));

	$sq_login = mysql_fetch_assoc(mysql_query("select * from roles where id='$login_id'"));
	$emp_id = $sq_login['emp_id'];

	$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'"));


	global $transaction_master;
	global $cash_in_hand, $bank_account;	

	//Debit side
	$module_name = "Employee Salary";
	$module_entry_id = $salary_id;
	$transaction_id = $transaction_id1;
	$payment_amount = $salary_amount;
	$payment_date = $payment_date;
	$payment_particular = get_salary_paid_particular($login_id, $month, $year, $payment_date);
	$gl_id = ($payment_mode=="Cash") ? $cash_in_hand : $bank_account;
	$payment_side = "Credit";
	$clearance_status = ($payment_mode!="Cash") ? "Pending" : "";
	$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);

	//Credit side
	$module_name = "Employee Salary";
	$module_entry_id = $salary_id;
	$transaction_id = $transaction_id1;
	$payment_amount = $salary_amount;
	$payment_date = $payment_date;
	$payment_particular = get_salary_paid_particular($login_id, $month, $year, $payment_date);
	$gl_id = 96;
	$payment_side = "Debit";
	$clearance_status = ($payment_mode!="Cash") ? "Pending" : "";
	$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);

	
}

public function bank_cash_book_save($salary_id)
{
	global $bank_cash_book_master;

	$login_id = $_POST['login_id'];
	$year = $_POST['year'];
	$month = $_POST['month'];
	$salary_amount = $_POST['salary_amount'];

	$payment_date = $_POST['payment_date'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];
	
	$module_name = "Employee Salary";
	$module_entry_id = $salary_id;
	$payment_date = $payment_date;
	$payment_amount = $salary_amount;
	$payment_mode = $payment_mode;
	$bank_name = $bank_name;
	$transaction_id = $transaction_id;
	$bank_id = $bank_id;
	$particular = get_salary_paid_particular($login_id, $month, $year, $payment_date);
	$clearance_status = ($payment_mode!="Cash") ? "Pending" : "";
	$payment_side = "Debit";
	$payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";

	$bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type);
	
}



public function finance_update($sq_salary_info, $clearance_status1)
{
	$salary_id = $_POST['salary_id'];
	$year = $_POST['year'];
	$month = $_POST['month'];
	$login_id = $_POST['login_id'];
	$salary_amount = $_POST['salary_amount'];

	$payment_date = $_POST['payment_date'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id1 = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];

	$payment_date = date('Y-m-d', strtotime($payment_date));

	$sq_login = mysql_fetch_assoc(mysql_query("select * from roles where id='$login_id'"));
	$emp_id = $sq_login['emp_id'];

	$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'"));

	global $transaction_master;
	global $cash_in_hand, $bank_account;

	//Debit Side
	$module_name = "Employee Salary";
	$module_entry_id = $salary_id;
	$transaction_id = $transaction_id1;
	$payment_amount = $salary_amount;
	$payment_date = $payment_date;
	$payment_particular = get_salary_paid_particular($login_id, $month, $year, $payment_date);
	$old_gl_id = ($sq_salary_info['payment_mode']=="Cash") ? $cash_in_hand : $bank_account;
	$gl_id = ($payment_mode=="Cash") ? $cash_in_hand : $bank_account;
	$payment_side = "Credit";
	$clearance_status = $clearance_status1;
	$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id, $payment_side, $clearance_status);

	//Credit Side
	$module_name = "Employee Salary";
	$module_entry_id = $salary_id;
	$transaction_id = $transaction_id1;
	$payment_amount = $salary_amount;
	$payment_date = $payment_date;
	$payment_particular = get_salary_paid_particular($login_id, $month, $year, $payment_date);
	$old_gl_id = $gl_id = 96;
	$payment_side = "Debit";
	$clearance_status = $clearance_status1;
	$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id, $payment_side, $clearance_status);
}

public function bank_cash_book_update($clearance_status)
{
	global $bank_cash_book_master;

	$salary_id = $_POST['salary_id'];
	$year = $_POST['year'];
	$month = $_POST['month'];
	$login_id = $_POST['login_id'];
	$salary_amount = $_POST['salary_amount'];

	$payment_date = $_POST['payment_date'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];
	
	$module_name = "Employee Salary";
	$module_entry_id = $salary_id;
	$payment_date = $payment_date;
	$payment_amount = $salary_amount;
	$payment_mode = $payment_mode;
	$bank_name = $bank_name;
	$transaction_id = $transaction_id;
	$bank_id = $bank_id;
	$particular = get_salary_paid_particular($login_id, $month, $year, $payment_date);
	$clearance_status = $clearance_status;
	$payment_side = "Debit";
	$payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";

	$bank_cash_book_master->bank_cash_book_master_update($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type);
}*/

}
?>