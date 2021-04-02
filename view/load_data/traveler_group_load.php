<?php include "../../model/model.php"; ?>
<?php
  $tour_id = $_GET['tour_id'];
  $tour_group_id = $_GET['tour_group_id'];  


  $tourwise_id_arr =array();
  $traveler_group_id_arr =array();
  $sq = mysql_query("select id,traveler_group_id from tourwise_traveler_details where tour_id = '$tour_id' and tour_group_id = '$tour_group_id' and tour_group_status != 'Cancel' ");
  while($row = mysql_fetch_assoc($sq))
  {
    $tourwise_id = $row['id'];
  	$traveler_group = $row['traveler_group_id'];
  	
  	if(!in_array($traveler_group,$traveler_group_id_arr))
  	{
      array_push($tourwise_id_arr, $tourwise_id);
  		array_push($traveler_group_id_arr, $traveler_group);
  	}	
  }	
  echo "<option value='select'> Select Traveler File No </option>";
  
  for($i=0; $i<sizeof($traveler_group_id_arr) ; $i++)
  {
  	$sq = mysql_query("select * from travelers_details where traveler_group_id = '$traveler_group_id_arr[$i]' and status='Active' ");
  	while($row = mysql_fetch_assoc($sq))
  	{
  		$first_name =  $row['first_name'];
  		$last_name = $row['last_name'];
  		echo "<option value='$traveler_group_id_arr[$i]'>File No-$tourwise_id_arr[$i] : $first_name $last_name </option>";
  	}	
  }	

?>