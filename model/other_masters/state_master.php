<?php 

$flag = true;

class state_master{



	public function state_save()

	{

		$state_name = $_POST['state_name'];

		$active_flag_arr = $_POST['active_flag_arr'];

		begin_t();



		for($i=0; $i<sizeof($state_name); $i++){
			$state_name_temp = ltrim($state_name[$i]);
			$sq_count = mysql_num_rows(mysql_query("select id from state_master where state_name='$state_name_temp'"));
			 
			if($sq_count>0){

				$GLOBALS['flag'] = false;

				echo "error--".$state_name_temp." State already exists!";
				exit;

			}

			$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from state_master"));

			$state_id = $sq_max['max'] + 1;



			$sq_state = mysql_query("insert into state_master (id, state_name, active_flag) values ('$state_id','$state_name[$i]', '$active_flag_arr[$i]')");

			if(!$sq_state){

				$GLOBALS['flag'] = false;

				echo "error--Some entries not saved";
				exit;

			}



		}



		if($GLOBALS['flag']){

			commit_t();

			echo "State has been successfully saved.";

			exit;

		}

		else{

			rollback_t();

			exit;

		}

	}



	public function state_update()

	{

		$state_id = $_POST['state_id'];

		$state_name = $_POST['state_name'];

		$active_flag = $_POST['active_flag'];


		$state_name_t = ltrim($state_name);
		$sq_count = mysql_num_rows(mysql_query("select id from state_master where state_name='$state_name_t'"));

		if($sq_count>0){

			$GLOBALS['flag'] = false;

			echo "error--".$state_name_t." State already exists!";
			exit;

		}
		



		$sq_airline = mysql_query("update state_master set state_name='$state_name', active_flag='$active_flag' where id='$state_id'");

		if($sq_airline){

			echo "State has been successfully updated.";

			exit;

		}

		else{

			echo "error--State not updated";

			exit;

		}



	}



}

?>