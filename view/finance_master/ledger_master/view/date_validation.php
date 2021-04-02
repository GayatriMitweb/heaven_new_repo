<?php 
include "../../../../model/model.php";
$from_date = $_POST['from_date'];
$from_date = get_date_db($from_date);
$financial_year_id = $_POST['financial_year_id'];

$sq_finance = mysql_fetch_assoc(mysql_query("select * from financial_year where financial_year_id='$financial_year_id'"));
if($from_date >= $sq_finance['from_date']){
	echo $from_date;
	exit;
}
else{
	echo '0';
	exit;
}

?>