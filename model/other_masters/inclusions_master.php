<?php 

class inclusions_master{



public function inclusion_save(){

	$inclusion = $_POST['inclusion'];

	$tour_type = $_POST['tour_type'];

	$active_flag = $_POST['active_flag'];

	$type = $_POST['type'];

	$for_v = $_POST['for_value'];



	$created_at = date("Y-m-d H:i:s");


	$inclusion = addslashes($inclusion);
	$sq_count = mysql_num_rows(mysql_query("select inclusion_id from inclusions_exclusions_master where tour_type='$tour_type' and type='$type' and for_value='$for_v'"));

	if($sq_count>0){

		echo "error--".$type."s already exists!";

		exit;

	}



	$sq_max = mysql_fetch_assoc(mysql_query("select max(inclusion_id) as max from inclusions_exclusions_master"));

	$inclusion_id = $sq_max['max'] + 1;



	$query = "insert into inclusions_exclusions_master ( inclusion_id, inclusion, tour_type, active_flag, created_at, type,for_value) values ('$inclusion_id', '$inclusion', '$tour_type', '$active_flag', '$created_at', '$type','$for_v')";

	$sq_insert = mysql_query($query);



	if($sq_insert){

		echo "Inclusion/Exclusions has been successfully saved.";

		exit;

	}

	else{

		echo "error--Inclusion not saved!".mysql_error();

		exit;

	}

}



public function inclusion_update()

{

	$inclusion_id = $_POST['inclusion_id'];

	$inclusion = $_POST['inclusion'];

	$tour_type = $_POST['tour_type'];

	$active_flag = $_POST['active_flag'];

	$type = $_POST['type'];

	$for = $_POST['for_value'];



	$sq_count = mysql_num_rows(mysql_query("select inclusion_id from inclusions_exclusions_master where tour_type='$tour_type' and for_value='$for' and type='$type' and inclusion_id!='$inclusion_id'"));

	if($sq_count>0){

		echo "error--".$type."s already exists!";

		exit;

	}


	$inclusion = addslashes($inclusion);
	$sq_insert = mysql_query("update inclusions_exclusions_master set inclusion='$inclusion', tour_type='$tour_type', active_flag='$active_flag' , type ='$type',for_value = '$for' where inclusion_id='$inclusion_id'");

	if($sq_insert){

		echo "Inclusion/Exclusions has been successfully updated..";

		exit;

	}

	else{

		echo "error--Inclusion not updated!".$for;

		exit;

	}

}



}

?>