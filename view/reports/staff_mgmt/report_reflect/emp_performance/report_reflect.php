<?php
include "../../../../../model/model.php";
$year = $_POST['year'];
$month= $_POST['month'];
$emp_id = $_POST['emp_id'];

$array_s = array();
$temp_arr = array();

$query = "select * from employee_performance_master where 1 ";
if($year!=''){
  $query .= " and year = '$year'";
}
if($month!=''){
  $query .= " and month = '$month'";
}
if($emp_id!=''){
  $query .= " and emp_id = '$emp_id'";
}

  $sq_a = mysql_query($query);
    while($row_emp = mysql_fetch_assoc($sq_a)){
      $sq_p =mysql_fetch_assoc(mysql_query( "select emp_id,first_name,last_name from emp_master where emp_id='$row_emp[emp_id]'"));
			if($row_emp['month'] == '1')
				$month = 'January';
			else if($row_emp['month'] == '2')
				$month = 'February';
			else if($row_emp['month'] == '3')
				$month = 'March';
			else if($row_emp['month'] == '4')
				$month = 'April';
			else if($row_emp['month'] == '5')
				$month = 'May';
			else if($row_emp['month'] == '6')
				$month = 'June';
			else if($row_emp['month'] == '7')
				$month = 'July';
			else if($row_emp['month'] == '8')
				$month = 'August';
			else if($row_emp['month'] == '9')
				$month = 'September';
			else if($row_emp['month'] == '10')
				$month = 'October';
			else if($row_emp['month'] == '11')
				$month = 'November';
			else if($row_emp['month'] == '12')
				$month = 'December';
			else
				$month = '';
      $temp_arr = array( "data" => array(
        $sq_p['emp_id'],
        $sq_p['first_name'].' '.$sq_p['last_name'],
        $month,
        ($row_emp['teamwork']!="") ? $row_emp['teamwork'] : '-',
        ($row_emp['leadership']!="") ? $row_emp['leadership'] : '-',
        ($row_emp['communication']!="") ? $row_emp['communication'] : '-',
        ($row_emp['analytical_skills']!="") ? $row_emp['analytical_skills'] : '-',
        ($row_emp['ethics']) ? $row_emp['ethics'] : '-',
        ($row_emp['conceptual_thinking']) ? $row_emp['conceptual_thinking'] : '-',
        ($row_emp['ave_ratings']!="") ? $row_emp['ave_ratings'] : '-'
        

        ), "bg" =>$bg);
      array_push($array_s,$temp_arr);
  
  }
  echo json_encode($array_s);
  ?>