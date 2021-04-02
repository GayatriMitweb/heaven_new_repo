<?php include "../../../../../model/model.php"; 
$booking_id = $_POST['booking_id'];	
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];
$branch_id= $_GET['branch_id_filter'];
$array_s = array();
$temp_arr = array();
$query = "select * from package_tour_booking_master where 1 ";
if($booking_id!=""){
	$query .= " and booking_id='$booking_id'";	
}
if($branch_id!=""){

	$query .=" and  branch_admin_id = '$branch_id'";
}
if($branch_status=='yes' && $role!='Admin'){
    $query .=" and  branch_admin_id = '$branch_admin_id'";
}
	$count = 0;
	$sq = mysql_query($query);
	while($row = mysql_fetch_assoc($sq))
	{
		$count++;

		$tour_group_from = date("d/m/Y", strtotime($row['tour_from_date']));
		$tour_group_to = date("d/m/Y", strtotime($row['tour_to_date']));	
		$link = "NA";
		if($row['train_upload_ticket']!="")
				{
					$newUrl = preg_replace('/(\/+)/','/',$row['train_upload_ticket']);
					$newUrl = str_replace("../","", $newUrl);
					$newUrl = BASE_URL.$newUrl;
			
					$link = '<a href="'.$newUrl .'" class="btn btn-info btn-sm" download><i class="fa fa-download"></i></a>';
			
				}
		$link1 = "NA";
				if($row['plane_upload_ticket']!="")
				{
					$newUrl = preg_replace('/(\/+)/','/',$row['plane_upload_ticket']);      
					$newUrl = str_replace("../","", $newUrl);  
					$newUrl = BASE_URL.$newUrl;        
			
					$link1 = '<a href="'.$newUrl.'" class="btn btn-info btn-sm" download><i class="fa fa-download"></i></a>';
				
				}
		$link2 = "NA";
				if($row['cruise_upload_ticket']!="")
				{
					$newUrl = preg_replace('/(\/+)/','/',$row['cruise_upload_ticket']);      
					$newUrl = str_replace("../","", $newUrl);  
					$newUrl = BASE_URL.$newUrl;        
			
					$link2 = '<a href="'. $newUrl .'" class="btn btn-info btn-sm" download><i class="fa fa-download"></i></a>';
			
				}
				$temp_arr = array( "data" => array(
					(int)($count),
					$row['tour_name'] ,
					$tour_group_from." to ".$tour_group_to,
					get_package_booking_id($row['booking_id']),
					$link,
					$link1,
					$link2
					), "bg" =>$bg);
					array_push($array_s,$temp_arr);
				}
				echo json_encode($array_s);
	?>
