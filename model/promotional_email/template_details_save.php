<?php 
class template{

public function template_details_save()
{
	$offer_amount = $_POST['offer_amount'];
	$description = $_POST['description'];
	$template_type_id = $_POST['template_type_id'];

	$created_at = date('Y-m-d');
	//$sq_template = mysql_fetch_assoc(mysql_query("select * from email_template_master where template_id ='$template_type_id'"));

	$sq_email_id = mysql_query("update email_template_master set  offer_amount = '$offer_amount',description = '$description', created_at = '$created_at' where template_id ='$template_type_id'");

	if($sq_email_id){
		echo "Template has been successfully saved.";
		exit;
	}
	else{
		echo "error--Sorry, Template Details Not Saved!";
		exit;
	}

}

}
?>