<?php 
class tasks_clone
{

public function tasks_master_clone()
{
	$task_id = $_POST['task_id'];
	echo $task_id;

	$cols=array();
	$result = mysql_query("SHOW COLUMNS FROM tasks_master"); 
	 while ($r=mysql_fetch_assoc($result)) {
	   $cols[]= $r["Field"];
	}

	  $result = mysql_query("SELECT * FROM tasks_master WHERE task_id='$task_id'");
	  while($r=mysql_fetch_array($result)) {

		    $insertSQL = "INSERT INTO tasks_master (".implode(", ",$cols).") VALUES (";
		    $count=count($cols);

		    foreach($cols as $counter=>$col) {

		      if($col=='task_id'){
		      	$sq_max = mysql_fetch_assoc(mysql_query("select max(task_id) as max from tasks_master"));
				$task_max = $sq_max['max']+1;
				$insertSQL .= "'".$task_max."'";	
		      }else{
		      	$insertSQL .= "'".$r[$col]."'";	
		      }
		      
			  if ($counter<$count-1) {$insertSQL .= ", ";}
			}
			$insertSQL .= ")";

			mysql_query($insertSQL);

	  }

  echo "Task is cloned successfully!";

}
 
}
?>