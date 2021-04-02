<?php 

$flag = true;

class gallary_master{



	public function gallary_master_save()

	{

		$gallary_url = $_POST['gallary_url'];

		$description = $_POST['description'];

		$dest_id = $_POST['dest_id'];



		begin_t();



			$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from gallary_master"));

			$entry_id = $sq_max['max'] + 1;


			$description = addslashes($description);
			$sq_airline = mysql_query("insert into gallary_master (entry_id, dest_id, description, image_url) values ('$entry_id','$dest_id', '$description', '$gallary_url')");

			if(!$sq_airline){

				echo "error--Image not saved";

				rollback_t();

			}

			else{

				commit_t();

				echo "Gallery has been successfully saved.";

				exit;

			}

	

}





	public function gallary_master_update()

	{

		$entry_id = $_POST['entry_id'];

		$description = $_POST['description'];


		$description = addslashes($description);
		$sq_airline = mysql_query("update gallary_master set description='$description' where entry_id='$entry_id'");

		if($sq_airline){

			echo "Gallery has been successfully saved.";

			exit;

		}

		else{

			echo "error--Description not updated";

			exit;

		}



	}
	public function gallary_image_delete()
	{
		$image_id = $_POST['image_id'];

	    $sq_delete = mysql_query("delete from gallary_master where entry_id='$image_id'");

	    if($sq_delete){

	      echo "Image Deleted";

	    }
	}
}



