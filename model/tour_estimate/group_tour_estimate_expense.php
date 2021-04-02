<?php 
class group_tour_estimate_expense{

public function group_tour_estimate_expense_save()
{
	$tour_id = $_POST['tour_id'];
	$tour_group_id = $_POST['tour_group_id'];	
	$purchase_amount = $_POST['purchase_amount'];	
	$purchase_name = $_POST['purchase_name'];	

	$expense_id = mysql_fetch_assoc(mysql_query("select max(expense_id) as max from group_tour_estimate_expense"));
	$expense_id = $expense_id['max']+1;

	$sq_insert = mysql_query("insert into group_tour_estimate_expense ( expense_id,expense_name, tour_id,tour_group_id,amount ) values ('$expense_id','$purchase_name', '$tour_id','$tour_group_id','$purchase_amount')");
	
	if($sq_insert){
		echo "Expense successfully saved!";
		exit;
	}
	else{
		echo "error--Sorry, Expense not saved.";
		exit;
	}
}
}
?>