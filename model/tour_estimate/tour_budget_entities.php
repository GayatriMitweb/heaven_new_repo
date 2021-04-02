<?php 
class tour_budget_entities{

public function tour_budget_entities_save()
{
	$budget_type_id = $_POST['budget_type_id'];
	$entity_name_arr = $_POST['entity_name_arr'];

	//Validating
	for($i=0; $i<sizeof($entity_name_arr); $i++){

		$sq_count = mysql_num_rows( mysql_query("select * from tour_budget_entities where budget_type_id='$budget_type_id' and entity_name='$entity_name_arr[$i]'") );
		if($sq_count>0){
			echo "error--$entity_name_arr[$i] already exits in this tour type.";
			exit;
		}

	}

	for($i=0; $i<sizeof($entity_name_arr); $i++){

		$entity_id = mysql_fetch_assoc(mysql_query("select max(entity_id) as max from tour_budget_entities"));
		$entity_id = $entity_id['max']+1;

		$sq = mysql_query("insert into tour_budget_entities ( entity_id, budget_type_id, entity_name ) values ( '$entity_id', '$budget_type_id', '$entity_name_arr[$i]' )");
		if(!$sq){
			echo "error--Sorry, Some entries are not stored.";
			exit;
		}

	}

	echo "Tour entities saved !";
}

}
?>