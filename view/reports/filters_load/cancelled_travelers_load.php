<?php include "../../../model/model.php"; ?>
<?php
  $tour_id = $_GET['tour_id'];
  $tour_group_id = $_GET['tour_group_id'];
  $branch_status = $_GET['branch_status'];
  $role = $_SESSION['role'];
  $branch_admin_id = $_SESSION['branch_admin_id'];
  $tourwise_id_arr =array();
  $traveler_group_id_arr =array();
  $sq = mysql_query("select id, traveler_group_id from tourwise_traveler_details where tour_id = '$tour_id' and tour_group_id = '$tour_group_id' and tour_group_status = 'Cancel' ");
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
  echo "<option value=''> Select Booking ID </option>";
  
  for($i=0; $i<sizeof($traveler_group_id_arr) ; $i++)
  {
    $query = "select * from travelers_details where 1";
    $query .=" and traveler_group_id = '$traveler_group_id_arr[$i]'";
    $query .=" and status='Active'";
    if($branch_status=='yes' && $role=='Branch Admin'){
      $query .=" and traveler_group_id in (select traveler_group_id from tourwise_traveler_details where branch_admin_id = '$branch_admin_id')";
    }
    
  	$sq = mysql_query($query);
  	while($row = mysql_fetch_assoc($sq))
  	{
  		$first_name =  $row['first_name'];
  		$last_name = $row['last_name'];
  		echo "<option value='$traveler_group_id_arr[$i]'>".get_group_booking_id($tourwise_id_arr[$i])." : $first_name $last_name </option>";
  	}	
  }	

?>