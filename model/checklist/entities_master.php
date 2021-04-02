<?php 
class entities_master{

public function entity_save()
{
	$entity_name_arr = $_POST['entity_name_arr'];
	$entity_for = $_POST['entity_for'];
	
	// $tour_id = $_POST['tour_id'];
	// $tour_group_id = $_POST['tour_group_id'];
	// $booking_id = $_POST['booking_id'];
	$dest_name = $_POST['dest_name'];
	if($entity_for == 'Group Tour' || $entity_for=='Package Tour'){
		$sq_count = mysql_num_rows(mysql_query("select * from checklist_entities where entity_for = '$entity_for' and destination_name='$dest_name'"));
	}else{
		$sq_count = mysql_num_rows(mysql_query("select * from checklist_entities where entity_for = '$entity_for' "));
	}


	if($sq_count>0){
		rollback_t();
		echo "error--Checklist already exists for ".$entity_for."!";
		exit;
	}else{
		$sq_max = mysql_fetch_assoc(mysql_query("select max(entity_id) as max from checklist_entities"));
		$entity_id = $sq_max['max'] + 1;
	
		$sq_entity= mysql_query("insert into checklist_entities ( entity_id,entity_for,destination_name ) values ( '$entity_id', '$entity_for','$dest_name')");
		
	
		if($sq_entity)
		{
			//to do entries
			for($i=0; $i<sizeof($entity_name_arr); $i++){
				$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from to_do_entries"));
	
					$id = $sq_max['max'] + 1;
	
					$sq="INSERT INTO to_do_entries (id, entity_id, entity_name) VALUES ('$id','$entity_id','$entity_name_arr[$i]')";
					$sq_entry = mysql_query($sq);
			}
			if($sq_entry){
				echo "Checklist has been successfully Saved.";
				exit;
			}
		}
		else{
			echo "error--Checklist not saved successfully!";
			exit;
		}
	
	}

}

///////////////////// Update Start //////////////////////////////
public function entity_update()
{
	 $entity_id=$_POST['entity_id'];
	 $entity_name_arr = $_POST['entity_name_arr'];
	 $entry_id_arr = $_POST['entry_id_arr'];
	 $checked_arr = $_POST['checked_arr'];


	for($i=0; $i<sizeof($entity_name_arr); $i++)
	{
		if($checked_arr[$i]=='true'){
			if($entry_id_arr[$i] != ''){
				$sq_entity = mysql_query("update to_do_entries set entity_name = '$entity_name_arr[$i]' where id = '$entry_id_arr[$i]'");
				if(!$sq_entity){		
					echo "Checklist not Updated!";
				}		
			}
			else
			{
				$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from to_do_entries"));
				$id = $sq_max['max'] + 1;
				$sq="INSERT INTO to_do_entries (id, entity_id, entity_name) VALUES ('$id','$entity_id','$entity_name_arr[$i]')";
				$sq_entry = mysql_query($sq);					
				if($sq_entry){
					echo "Checklist has been successfully updated.";
					exit;
				}	
				if(!$sq_entity){		
					echo "Checklist not Updated!";
				}
			}
		}else{
			$q="DELETE FROM `to_do_entries` WHERE id='$entry_id_arr[$i]'";
			echo $q;
			$sql_delete = mysql_query($q);
			if($sql_delete){
			echo "Checklist is Deleted!";
			}
		}
	}
}
/////////////////////////Update End////////////////////////////////////////////
}
?>