<?php 
include '../../../../../model/model.php';
$emp_id = $_POST['emp_id'];
$year = $_POST['year'];
$month = $_POST['month'];
$last_month = $month-1;
$financial_year_id = $_POST['financial_year_id'];
$inc_amt = 0;

$last_day_this_month  = date('Y-'.$last_month.'-t');
$first_day_of_month = date('Y-'.$last_month.'-1');

$sql_inc =mysql_query("select * from booker_sales_incentive where emp_id='$emp_id' and financial_year_id='$financial_year_id' and booking_date<='$last_day_this_month' and booking_date>='$first_day_this_month' ");
while($row =mysql_fetch_assoc($sql_inc)){
    $inc_amt = $inc_amt + $row['incentive_amount'];
}

echo $inc_amt;
?>