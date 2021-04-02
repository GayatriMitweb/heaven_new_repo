<?php 
class group_tour_checklist{

public function group_tour_checklist_save()
{
	$tour_id = $_POST['tour_id'];
	$tour_group_id = $_POST['tour_group_id'];
	$entity_id_arr = $_POST['entity_id_arr'];

	$sq_del_checklist = mysql_query("delete from checklist_group_tour where tour_id='$tour_id' and tour_group_id='$tour_group_id'");
	if(!$sq_del_checklist){
		echo "error--Sorry, Old Checklist not removed!";
		exit;
	}

	for($i=0; $i<sizeof($entity_id_arr); $i++){

		$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from checklist_group_tour"));
		$id = $sq_max['max'] + 1;

		$sq_checklist = mysql_query("insert into checklist_group_tour( id, tour_id, tour_group_id, entity_id ) values ( '$id', '$tour_id', '$tour_group_id', '$entity_id_arr[$i]' )");
		if(!$sq_checklist){
			echo "error--Sorry, Some status are not marked!";
			exit;
		}

	}

	echo "Checklist updated successfully!";
	exit;
}

}
?>