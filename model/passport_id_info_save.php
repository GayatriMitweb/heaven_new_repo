<?php
class passport_info
{
	public function passport_info_save()
	{
		$passport_no = $_POST['passport_no'];
		$issue_date = $_POST['issue_date'];
		$expiry_date = $_POST['expiry_date'];
		$traveler_id = $_POST['traveler_id'];
		
		$expiry_date1 = date('Y-m-d',strtotime($expiry_date));
		$issue_date1 = date('Y-m-d',strtotime($issue_date));

		 $sq = mysql_query("update travelers_details set passport_no='$passport_no', passport_issue_date='$issue_date1', passport_expiry_date='$expiry_date1' where traveler_id='$traveler_id'");
	    if($sq)
		 {
		 	echo "Passport Information Saved!";
		 }
	}
	public function package_passport_info_save1()
	{
		$passport_no = $_POST['passport_no'];
		$issue_date = $_POST['issue_date'];
		$expiry_date = $_POST['expiry_date'];
		$traveler_id = $_POST['traveler_id'];
		
		$expiry_date1 = date('Y-m-d',strtotime($expiry_date));
		$issue_date1 = date('Y-m-d',strtotime($issue_date));

		 $sq = mysql_query("update package_travelers_details set passport_no='$passport_no', passport_issue_date='$issue_date1', passport_expiry_date='$expiry_date1' where traveler_id = '$traveler_id'");
	    if($sq)
		 {
		 	echo "Passport Information Saved!";
		 }
	}
	public function air_passport_info_save1()
	{
		$passport_no = $_POST['passport_no'];
		$issue_date = $_POST['issue_date'];
		$expiry_date = $_POST['expiry_date'];
		$entry_id = $_POST['entry_id'];
		
		$expiry_date1 = date('Y-m-d',strtotime($expiry_date));
		$issue_date1 = date('Y-m-d',strtotime($issue_date));

		 $sq = mysql_query("update ticket_master_entries set passport_no='$passport_no', passport_issue_date='$issue_date1', passport_expiry_date = '$expiry_date1' where entry_id = '$entry_id'");
	    if($sq)
		 {
		 	echo "Passport Information Saved!";
		 }
	}
}
?>