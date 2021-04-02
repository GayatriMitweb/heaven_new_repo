<?php
include "../../model/model.php"; 
$financial_year_id = $_SESSION['financial_year_id'];
$check_date = $_POST['check_date'];

$check_date = get_date_db($check_date);
$sq_finance = mysql_fetch_assoc(mysql_query("select from_date,to_date from financial_year where financial_year_id='$financial_year_id'"));
$financial_from_date = $sq_finance['from_date'];
$financial_to_date = $sq_finance['to_date'];
if($check_date != "1970-01-01" && $check_date != ""){
  if($check_date >= $financial_from_date && $check_date <= $financial_to_date){
    echo 'valid';
  }
  else{
    echo 'The date does not match between selected Financial year.';
  }
}
else{
  echo '';
}
?>