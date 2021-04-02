<?php 
class quotation_clone
{

public function quotation_master_clone()
{
	$branch_admin_id = $_SESSION['branch_admin_id'];
	$quotation_id = $_POST['quotation_id'];

	$cols=array();
	$result = mysql_query("SHOW COLUMNS FROM group_tour_quotation_master"); 
	 while ($r=mysql_fetch_assoc($result)) {
	   $cols[]= $r["Field"];
	}

	  $result = mysql_query("SELECT * FROM group_tour_quotation_master WHERE quotation_id='$quotation_id'");
	  while($r=mysql_fetch_array($result)) {

		    $insertSQL = "INSERT INTO group_tour_quotation_master (".implode(", ",$cols).") VALUES (";
		    $count=count($cols);

		    foreach($cols as $counter=>$col) {

		      if($col=='quotation_id'){
		      	$sq_max = mysql_fetch_assoc(mysql_query("select max(quotation_id) as max from group_tour_quotation_master"));
				$quotation_max = $sq_max['max']+1;
				$insertSQL .= "'".$quotation_max."'";	
		      }
			  else if($col=='incl' || $col=='excl'){
				  $incl_excl = addslashes($r[$col]);
				  $insertSQL .= "'".$incl_excl."'";
			  }
		      elseif($col=='branch_admin_id'){

				$insertSQL .= "'".$branch_admin_id."'";	

		      }else{
		      	$insertSQL .= "'".$r[$col]."'";	
		      }
		      
			  if ($counter<$count-1) {$insertSQL .= ", ";}
			}
			$insertSQL .= ")";

			mysql_query($insertSQL);

	  }

  $this->clone_train_entries($quotation_id, $quotation_max);
  $this->clone_plane_entries($quotation_id, $quotation_max);
  $this->clone_cruise_entries($quotation_id, $quotation_max);
  $sq_update  = mysql_query("update group_tour_quotation_master set clone='yes' where quotation_id='$quotation_max'");
  echo "Quotation has been successfully copied.";

}


public function clone_train_entries($quotation_id, $quotation_max){

	$cols=array();

	$result = mysql_query("SHOW COLUMNS FROM group_tour_quotation_train_entries"); 
	 while ($r=mysql_fetch_assoc($result)) {
	   $cols[]= $r["Field"];
	}


	  $result = mysql_query("SELECT * FROM group_tour_quotation_train_entries WHERE quotation_id='$quotation_id'");
	  while($r=mysql_fetch_array($result)) {

		    $insertSQL = "INSERT INTO group_tour_quotation_train_entries (".implode(", ",$cols).") VALUES (";
		    $count=count($cols);

		    foreach($cols as $counter=>$col) {

		      if($col=='id'){
		      	$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from group_tour_quotation_train_entries"));
				$id = $sq_max['max']+1;
				$insertSQL .= "'".$id."'";	
		      }
 			  elseif($col=='quotation_id'){
 			  	$insertSQL .= "'".$quotation_max."'";		
 			  }
		      else{
		      	$insertSQL .= "'".$r[$col]."'";	
		      }
		      
			  if ($counter<$count - 1) {$insertSQL .= ", ";}

			}
			  $insertSQL .= ")";
			  mysql_query($insertSQL);

	  }
}

public function clone_plane_entries($quotation_id, $quotation_max){


	$cols=array();
	$result = mysql_query("SHOW COLUMNS FROM group_tour_quotation_plane_entries"); 
	 while ($r=mysql_fetch_assoc($result)) {
	   $cols[]= $r["Field"];
	}

	  $result = mysql_query("SELECT * FROM group_tour_quotation_plane_entries WHERE quotation_id='$quotation_id'");
	  while($r=mysql_fetch_array($result)) {

		    $insertSQL = "INSERT INTO group_tour_quotation_plane_entries (".implode(", ",$cols).") VALUES (";
		    $count=count($cols);

		    foreach($cols as $counter=>$col) {

		      if($col=='id'){
		      	$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from group_tour_quotation_plane_entries"));
				$id = $sq_max['max']+1;
				$insertSQL .= "'".$id."'";	
		      }
		      elseif($col=='quotation_id'){
 			  	$insertSQL .= "'".$quotation_max."'";		
 			  }
		      else{
		      	$insertSQL .= "'".$r[$col]."'";	
		      }
		      
			  if ($counter<$count-1) {$insertSQL .= ", ";}

			 }

			  $insertSQL .= ")";
			  mysql_query($insertSQL);

	  }

}


public function clone_cruise_entries($quotation_id, $quotation_max){

	$cols=array();

	$result = mysql_query("SHOW COLUMNS FROM group_tour_quotation_cruise_entries"); 
	 while ($r=mysql_fetch_assoc($result)) {
	   $cols[]= $r["Field"];
	}


	  $result = mysql_query("SELECT * FROM group_tour_quotation_cruise_entries WHERE quotation_id='$quotation_id'");
	  while($r=mysql_fetch_array($result)) {

		    $insertSQL = "INSERT INTO group_tour_quotation_cruise_entries (".implode(", ",$cols).") VALUES (";
		    $count=count($cols);

		    foreach($cols as $counter=>$col) {

		      if($col=='id'){
		      	$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from group_tour_quotation_cruise_entries"));
				$id = $sq_max['max']+1;
				$insertSQL .= "'".$id."'";	
		      }
 			  elseif($col=='quotation_id'){
 			  	$insertSQL .= "'".$quotation_max."'";		
 			  }
		      else{
		      	$insertSQL .= "'".$r[$col]."'";	
		      }
		      
			  if ($counter<$count - 1) {$insertSQL .= ", ";}

			}
			  $insertSQL .= ")";
			  mysql_query($insertSQL);

	  }
}
}
?>