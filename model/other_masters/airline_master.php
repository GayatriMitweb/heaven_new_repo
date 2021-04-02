<?php 
$flag = true;
class airline_master{

	public function airline_save()
	{
		$airline_name_arr = $_POST['airline_name_arr'];
		$airline_code_arr = $_POST['airline_code_arr'];
		$airline_status_arr = $_POST['airline_status_arr'];

		begin_t();

		for($i=0; $i<sizeof($airline_code_arr); $i++){
			$airline_name1 = ltrim($airline_name_arr[$i]);
			$airline_code1 = ltrim($airline_code_arr[$i]);

			$sq_count = mysql_num_rows(mysql_query("select airline_id from airline_master where airline_name='$airline_name1' and airline_code='$airline_code1'"));
			if($sq_count>0){
				$GLOBALS['flag'] = false;
				echo "error--".$airline_name1.'('.$airline_code1.')'." already exists!";
				exit;
			}
			$sq_max = mysql_fetch_assoc(mysql_query("select max(airline_id) as max from airline_master"));
			$airline_id = $sq_max['max'] + 1;

			$sq_airline = mysql_query("insert into airline_master (airline_id, airline_code, airline_name, active_flag) values ('$airline_id','$airline_code_arr[$i]', '$airline_name_arr[$i]',  '$airline_status_arr[$i]')");
			if(!$sq_airline){
				$GLOBALS['flag'] = false;
				echo "error--Some entries not saved";
				exit;
			}

		}

		if($GLOBALS['flag']){
			commit_t();
			echo "Airline has been successfully saved.";
			exit;
		}
		else{
			rollback_t();
			exit;
		}
	}

	public function airline_update()
	{
		$airline_id = $_POST['airline_id'];
		$airline_name = $_POST['airline_name'];
		$airline_code = $_POST['airline_code'];
		$airline_status = $_POST['airline_status'];

		$airline_name1 = ltrim($airline_name);
		$airline_code1 = ltrim($airline_code);

		$sq_count = mysql_num_rows(mysql_query("select airline_id from airline_master where airline_name='$airline_name1' and airline_code='$airline_code1' and airline_id!='$airline_id'"));
		if($sq_count>0){
			$GLOBALS['flag'] = false;
			echo "error--".$airline_name1.'('.$airline_code1.')'." already exists!";
			exit;
		}

		$sq_airline = mysql_query("update airline_master set airline_name='$airline_name', airline_code='$airline_code', active_flag='$airline_status' where airline_id='$airline_id'");
		if($sq_airline){
			echo "Airline has been successfully updated.";
			exit;
		}
		else{
			echo "error--Airline not updated";
			exit;
		}

	}

}
?>