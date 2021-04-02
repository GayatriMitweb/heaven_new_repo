<?php 
class package_tour_checklist{

public function package_tour_checklist_save()
{
	$booking_id = $_POST['booking_id'];
	$entity_id_arr = $_POST['entity_id_arr'];
    $branch_admin_id = $_POST['branch_admin_id'];
	$tour_type = $_POST['tour_type'];
	
	$sq_del_checklist = mysql_query("delete from checklist_package_tour where booking_id='$booking_id'");
	if(!$sq_del_checklist){
		echo "error--Sorry, Old Checklist not removed!";
		exit;
	}

	for($i=0; $i<sizeof($entity_id_arr); $i++){

		$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from checklist_package_tour"));
		$id = $sq_max['max'] + 1;

		$sq_checklist = mysql_query("insert into checklist_package_tour( id, branch_admin_id, booking_id, tour_type,entity_id ) values ( '$id', '$branch_admin_id', '$booking_id','$tour_type' ,'$entity_id_arr[$i]' )");
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