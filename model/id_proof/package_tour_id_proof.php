<?php 
class package_tour_id_proof
{

	public function package_tour_id_proof_upload()
	{
		$traveler_id = $_POST['traveler_id'];
		$id_proof_url = $_POST['id_proof_url'];

		$sq = mysql_query("update package_travelers_details set id_proof_url='$id_proof_url' where traveler_id='$traveler_id'");
		if($sq){
			echo "ID proof uploaded successfully!";
			exit;
		}	
		else{
			echo "error--Sorry, ID Proof not uploaded!";
			exit;
		}

	}
	public function package_tour_pan_card_upload()
	{
		$traveler_id = $_POST['traveler_id'];
		$id_proof_url = $_POST['id_proof_url'];

		$sq = mysql_query("update package_travelers_details set pan_card_url='$id_proof_url' where traveler_id='$traveler_id'");
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