<?php 
include_once('../../../model/model.php');

$group_id = $_POST['group_id'];
$chk_date = $_POST['chk_date'];

$sq_group = mysql_fetch_assoc(mysql_query("select * from tour_groups where group_id='$group_id'"));

		$from_date = date('d-m-Y', strtotime($sq_group['from_date']));
		$to_date = date('d-m-Y', strtotime($sq_group['to_date']));
		$check_date = date('d-m-Y', strtotime($chk_date));
		if($from_date <= $check_date && $check_date <= $to_date)
		{
			echo 'Success';
		}
		else{
			echo 'Error';
		}
?>