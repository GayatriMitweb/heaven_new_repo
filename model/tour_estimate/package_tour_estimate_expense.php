<?php 
class package_tour_estimate_expense{

public function package_tour_estimate_expense_save()
{
	$booking_id = $_POST['booking_id'];
	$purchase_amount = $_POST['purchase_amount'];	
	$purchase_name = $_POST['purchase_name'];	

	$expense_id = mysql_fetch_assoc(mysql_query("select max(expense_id) as max from package_tour_estimate_expense"));
	$expense_id = $expense_id['max']+1;

	$sq_insert = mysql_query("insert into package_tour_estimate_expense ( expense_id,expense_name, booking_id,amount ) values ('$expense_id','$purchase_name', '$booking_id','$purchase_amount')");
	
	if($sq_insert){
		echo "Expense successfully saved!";
		exit;
	}
	else{
		echo "error--Sorry, Expense not saved.";
		exit;
	}
}
//Other sale save
public function other_tour_estimate_expense_save()
{
	$booking_type = $_POST['booking_type'];
	$purchase_amount = $_POST['purchase_amount'];	

	$expense_id = mysql_fetch_assoc(mysql_query("select max(expense_id) as max from all_tour_other_expense"));
	$expense_id = $expense_id['max']+1;

	$sq_insert = mysql_query("insert into all_tour_other_expense ( expense_id,booking_type,amount ) values ('$expense_id','$booking_type','$purchase_amount')");
	
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