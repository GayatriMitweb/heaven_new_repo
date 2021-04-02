<?php 
class air_ticket_id_proof
{

	public function air_ticket_id_proof_upload()
	{
		$entry_id = $_POST['entry_id'];
		$id_proof_url = $_POST['id_proof_url'];

		$sq = mysql_query("update ticket_master_entries set id_proof_url='$id_proof_url' where entry_id='$entry_id'");
		if($sq){
			echo "ID proof uploaded successfully!";
			exit;
		}	
		else{
			echo "error--Sorry, ID Proof not uploaded!";
			exit;
		}

	}
	public function air_ticket_pan_card_upload()
	{
		$entry_id = $_POST['entry_id'];
		$id_proof_url = $_POST['id_proof_url'];

		$sq = mysql_query("update ticket_master_entries set pan_card_url='$id_proof_url' where entry_id='$entry_id'");
		if($sq){
			echo "PAN Card uploaded successfully!";
			exit;
		}	
		else{
			echo "error--Sorry, PAN Card not uploaded!";
			exit;
		}

	}

}
?>