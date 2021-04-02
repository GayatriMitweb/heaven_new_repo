<?php 
include "../../../../../model/model.php"; 

$emp_id = $_POST['emp_id'];

$emp_info_arr = array();

$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'"));

$emp_info_arr['basic_pay'] = $sq_emp['basic_pay'];

$emp_info_arr['dear_allow'] = $sq_emp['dear_allow'];

$emp_info_arr['hra'] = $sq_emp['hra'];

$emp_info_arr['travel_allow'] = $sq_emp['travel_allow'];

$emp_info_arr['medi_allow'] = $sq_emp['medi_allow'];

$emp_info_arr['special_allow'] =  $sq_emp['special_allow'];

$emp_info_arr['uniform_allowance'] = $sq_emp['uniform_allowance'];

$emp_info_arr['incentive_per'] = $sq_emp['incentive_per'];

$emp_info_arr['meal_allowance'] = $sq_emp['meal_allowance'];

$emp_info_arr['gross_salary'] = $sq_emp['gross_salary'];

$emp_info_arr['employee_pf'] = $sq_emp['employee_pf'];

$emp_info_arr['esic'] = $sq_emp['esic'];

$emp_info_arr['pt'] = $sq_emp['pt'];
 
$emp_info_arr['tds'] = $sq_emp['tds'];

$emp_info_arr['labour_all'] =  $sq_emp['labour_all'];

$emp_info_arr['employer_pf'] = $sq_emp['employer_pf'];
$emp_info_arr['deduction'] = $sq_emp['deduction'];
$emp_info_arr['net_salary'] = $sq_emp['net_salary'];

echo json_encode($emp_info_arr)

?>