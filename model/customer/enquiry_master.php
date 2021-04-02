<?php 
class enquiry_master{

public function enquiry_save()
{

	$customer_id = $_POST['customer_id'];
	$service_name = $_POST['service_name'];
	$enquiry_specification = $_POST['enquiry_specification'];

	$created_at = date('Y-m-d H:i:s');

	$sq_max = mysql_fetch_assoc(mysql_query("select max(enquiry_id) as max from customer_enquiry_master"));
	$enquiry_id = $sq_max['max'] + 1;

	$sq_enq = mysql_query("insert into customer_enquiry_master (enquiry_id, customer_id, service_name, enquiry_specification, created_at) values ('$enquiry_id', '$customer_id', '$service_name', '$enquiry_specification', '$created_at')");
	if($sq_enq){
		echo "Enquiry saved!";
		exit;
	}
	else{
		echo "error--Enquiry not saved!";
		exit;
	}

}

public function enquiry_update()
{

	$enquiry_id = $_POST['enquiry_id'];
	$service_name = $_POST['service_name'];
	$enquiry_specification = $_POST['enquiry_specification'];


	$sq_enq = mysql_query("update customer_enquiry_master set service_name='$service_name', enquiry_specification='$enquiry_specification' where enquiry_id='$enquiry_id'");
	if($sq_enq){
		echo "Enquiry updated!";
		exit;
	}
	else{
		echo "error--Enquiry not updated!";
		exit;
	}

}

}
?>