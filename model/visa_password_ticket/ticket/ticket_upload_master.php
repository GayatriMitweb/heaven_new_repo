<?php 
class ticket_upload_master{

public function ticket_upload_save()
{
	$ticket_id = $_POST['ticket_id'];
	$ticket_url = $_POST['ticket_url'];

	$created_at = date('Y-m-d H:i:s');

	$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from ticket_master_upload_entries"));
	$entry_id = $sq_max['max'] + 1;

	$sq_ticket = mysql_query("insert into ticket_master_upload_entries (entry_id, ticket_id, ticket_url, created_at) values ('$entry_id', '$ticket_id', '$ticket_url', '$created_at')");
	if($sq_ticket){
		echo "Ticket Uploaded successfully!";
		exit;
	}
	else{
		echo "error--Ticket not uploaded!";
		exit;
	}
}

}
?>