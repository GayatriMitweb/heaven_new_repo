<?php
class exc_inventory_master{

public function exc_inventory_save()
{
 	$city_id = $_POST['city_id'];	
	$exc_name = $_POST['exc_name'];
	$purchase_date = $_POST['purchase_date'];
	$total_tickets = $_POST['total_tickets'];
	$rate = $_POST['rate'];
	$from_date = $_POST['from_date'];
	$to_date = $_POST['to_date'];
	$cancel_date = $_POST['cancel_date'];
	$reminder1 = $_POST['reminder1'];
	$reminder2 = $_POST['reminder2'];
	$note = $_POST['note'];

	$emp_id = $_SESSION['emp_id'];
	$branch_admin_id = $_SESSION['branch_admin_id'];
	$financial_year_id = $_SESSION['financial_year_id'];

	$purchase_date = date("Y-m-d", strtotime($purchase_date));
	$from_date = date("Y-m-d", strtotime($from_date));
	$to_date = date("Y-m-d", strtotime($to_date));
	$cancel_date = date("Y-m-d", strtotime($cancel_date));
	$reminder1 = date("Y-m-d", strtotime($reminder1));
	$reminder2 = date("Y-m-d", strtotime($reminder2));
	$created_at = date('Y-m-d H:i:s');

	$sq_count = mysql_num_rows(mysql_query("select * from excursion_inventory_master where city_id='$city_id' and exc_id='$exc_name' and valid_from_date='$from_date' and valid_to_date='$to_date'"));
	if($sq_count != 0){
		echo "error--Sorry, Inventory already added!";
		exit;
	}
	$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from excursion_inventory_master"));
	$service_id = $sq_max['max'] + 1;

	$sq_service = mysql_query("insert into excursion_inventory_master (entry_id,emp_id,branch_admin_id,financial_year_id, city_id, exc_id,purchase_date,total_tickets,valid_from_date, valid_to_date,rate,cancel_date, reminder1 , reminder2,note,created_at,active_flag) values ('$service_id','$emp_id','$branch_admin_id','$financial_year_id' , '$city_id', '$exc_name','$purchase_date','$total_tickets','$from_date','$to_date','$rate','$cancel_date','$reminder1' , '$reminder2','$note','$created_at','Active')");

	if($sq_service){
		echo "Inventory has been successfully saved.";
		exit;
	}
	else{
		echo "error--Sorry, Inventory not saved!";
		exit;
	}
}

public function exc_inventory_update(){
	$entry_id = $_POST['entry_id'];
	$city_id = $_POST['city_id'];	
   	$exc_name = $_POST['exc_name'];
	$purchase_date = $_POST['purchase_date'];
	$total_tickets = $_POST['total_tickets'];
	$rate = $_POST['rate'];
	$from_date = $_POST['from_date'];
	$to_date = $_POST['to_date'];
	$cancel_date = $_POST['cancel_date'];
	$reminder1 = $_POST['reminder1'];
	$reminder2 = $_POST['reminder2'];
	$note = $_POST['note'];
	$active_flag = $_POST['active_flag'];

	$purchase_date = date("Y-m-d", strtotime($purchase_date));
	$from_date = date("Y-m-d", strtotime($from_date));
	$to_date = date("Y-m-d", strtotime($to_date));
	$cancel_date = date("Y-m-d", strtotime($cancel_date));
	$reminder1 = date("Y-m-d", strtotime($reminder1));
	$reminder2 = date("Y-m-d", strtotime($reminder2));
	$q = "select * from excursion_inventory_master where city_id='$city_id' and exc_id='$exc_name' and valid_from_date='$from_date' and valid_to_date='$to_date' and entry_id!='$entry_id'";
	$sq_count = mysql_num_rows(mysql_query($q));
	if($sq_count != 0){
		echo "error--Sorry, Inventory already added!";
		exit;
	}
	$sq_service = mysql_query("update excursion_inventory_master set purchase_date='$purchase_date', total_tickets='$total_tickets',valid_from_date='$from_date', valid_to_date='$to_date',rate='$rate',cancel_date='$cancel_date', reminder1='$reminder1' , reminder2='$reminder2',note='$note',active_flag='$active_flag' where entry_id='$entry_id'");

	if($sq_service){
		echo "Inventory has been successfully updated.";
		exit;
	}
	else{
		echo "error--Sorry, Inventory not updated!";
		exit;
	}
}
}
?>