<?php include "../../../model/model.php";
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$login_id = $_SESSION['login_id'];
$emp_id = $_SESSION['emp_id'];
$array_s = array();
$temp_arr = array();
$enquiry_type = $_POST['enquiry_type'];
$enquiry = $_POST['enquiry'];
$enquiry_status_filter = $_POST['enquiry_status'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$emp_id_filter = $_POST['emp_id_filter'];
$branch_status = $_POST['branch_status'];
$branch_filter = $_POST['branch_filter'];
$reference_id_filter=$_POST['reference_id_filter'];

//////////Calculate no.of .enquiries Start///////////////////
$enq_count = "SELECT * FROM `enquiry_master` left join enquiry_master_entries as ef on enquiry_master.entry_id=ef.entry_id where enquiry_master.status!='Disabled'";

if($financial_year_id!=""){
	$enq_count .=" and financial_year_id='$financial_year_id'";
}
if($emp_id_filter!=""){
	$enq_count .=" and assigned_emp_id='$emp_id_filter'";
}
elseif($branch_status=='yes' && $role=='Branch Admin'){
  $enq_count .= " and branch_admin_id='$branch_admin_id'";
}
if($enquiry!="" && $enquiry!=='undefined'){
	$enq_count .=" and enquiry='$enquiry' ";
}
if($branch_filter!=""){
	$enq_count .=" and branch_admin_id='$branch_filter' ";
}
if($enquiry_type!=""){
	$enq_count .=" and enquiry_type='$enquiry_type' ";
}
if($reference_id_filter!=""){
	$enq_count .=" and reference_id='$reference_id_filter' ";
}
if($from_date!='' && $from_date!='undefined' && $to_date!="" && $to_date!='undefined'){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$enq_count .=" and (enquiry_date between '$from_date' and '$to_date')";
}
if($branch_status=='yes' && $role!='Admin'){
		$enq_count .= " and branch_admin_id = '$branch_admin_id'";
}
if($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
	if($role !='Admin' && $role!='Branch Admin')
	{
		$enq_count .= " and assigned_emp_id='$emp_id' and enquiry_master.status!='Disabled' ";  
		if($enquiry_type!=""){
			$enq_count .=" and enquiry_type='$enquiry_type' ";
		}
		if($reference_id_filter!=""){
			$enq_count .=" and reference_id='$reference_id_filter' ";
		}
		if($from_date!='' && $from_date!='undefined' && $to_date!="" && $to_date!='undefined'){
			$from_date = get_date_db($from_date);
			$to_date = get_date_db($to_date);
			$enq_count .=" and (enquiry_date between '$from_date' and '$to_date')";
		}
		if($enquiry!=""){
			$enq_count .=" and enquiry='$enquiry' ";
		}
	}   
}
if($enquiry_status_filter!='')
{
	if($enquiry_status_filter=='Active')	{
		$enq_count .= " and ef.followup_status='Active'";
	}
	if($enquiry_status_filter=='In-Followup'){
		$enq_count .= " and ef.followup_status='In-Followup' ";
	}
	if($enquiry_status_filter=='Converted')	{
		$enq_count .= " and ef.followup_status='$enquiry_status_filter'";
	}
	if($enquiry_status_filter=='Dropped'){
		$enq_count .= " and ef.followup_status='$enquiry_status_filter'";
	}
}
$enq_count .= " ORDER BY enquiry_master.enquiry_id DESC ";
$enquiry_count=mysql_num_rows(mysql_query($enq_count));
//////////Calculate no.of .enquiries End///////////////////

///////////////////Enquiry table data start////////////////////////////////
$query = "SELECT * FROM `enquiry_master` left join enquiry_master_entries as ef on enquiry_master.entry_id=ef.entry_id where enquiry_master.status!='Disabled'";

if($financial_year_id!=""){
	$query .=" and financial_year_id='$financial_year_id'";
}
if($emp_id_filter!=""){
	$query .=" and assigned_emp_id='$emp_id_filter'";
}
if($branch_status=='yes' && $role=='Branch Admin'){
	$query .=" and branch_admin_id = '$branch_admin_id'";
}	
if($enquiry!="" && $enquiry!=='undefined'){
    $query .=" and enquiry='$enquiry' ";
}		
if($enquiry_type!=""){
	$query .=" and enquiry_type='$enquiry_type' ";
}
if($branch_filter!=""){
	$query .=" and branch_admin_id='$branch_filter' ";
}
if($reference_id_filter!=""){
	$query .=" and reference_id='$reference_id_filter' ";
}
if($branch_status=='yes' && $role!='Admin'){
		$query .= " and branch_admin_id = '$branch_admin_id'";
}
if($login_id != "1"){	//2019 is temp admin's employee id
	$query .= " and assigned_emp_id <> '0' ";
}
if($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
	$query .=" and assigned_emp_id='$emp_id' ";
	if($enquiry_type!=""){
		$query .=" and enquiry_type='$enquiry_type' ";
	}
	if($reference_id_filter!=""){
					$query .=" and reference_id='$reference_id_filter' ";
	}
	if($from_date!='' && $from_date!='undefined' && $to_date!="" && $to_date!='undefined'){
		$from_date = get_date_db($from_date);
		$to_date = get_date_db($to_date);
		$query .=" and (enquiry_date between '$from_date' and '$to_date')";
	}
	if($enquiry!=""){
			$query .=" and enquiry='$enquiry' ";
	}
}
if($from_date!='' && $to_date!=""){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .=" and (enquiry_date between '$from_date' and '$to_date')";
}
if($enquiry_status_filter!=''){
	if($enquiry_status_filter=='Active'){
		$query .= " and ef.followup_status='Active' ";
	}
	if($enquiry_status_filter=='Converted'){
		$query .= " and ef.followup_status='$enquiry_status_filter'";
	}
	if($enquiry_status_filter=='Dropped'){
		$query .= " and ef.followup_status='$enquiry_status_filter'";
	}
	if($enquiry_status_filter=='In-Followup'){
		$query .= " and ef.followup_status='In-Followup' ";
	}
}
$query .= " ORDER BY enquiry_master.enquiry_id DESC";
///////////////////Enquiry table data End////////////////////////////////

$count = 0;
$sq_enquiries=mysql_query($query);

while($row = mysql_fetch_assoc($sq_enquiries)){
	$actions_string = "";
	$enquiry_id = $row['enquiry_id'];
	$assigned_emp_id = $row['assigned_emp_id'];
	$sq_emp = mysql_fetch_assoc(mysql_query("select first_name,last_name from emp_master where emp_id='$assigned_emp_id'"));
	$allocated_to = ($assigned_emp_id != 0)?$sq_emp['first_name'].' '.$sq_emp['last_name'] : 'Admin';

	$enquiry_content = $row['enquiry_content'];
	$enquiry_content_arr1 = json_decode($enquiry_content, true);

	$enquiry_status1 = mysql_fetch_assoc(mysql_query("select followup_date,followup_reply,followup_status from enquiry_master_entries where enquiry_id='$row[enquiry_id]' order by entry_id DESC"));
	$followup_date1 = $enquiry_status1['followup_date'];
	if($enquiry_status1['followup_status']=='Active'){
		$followup_status='Active';
	}
	elseif($followup_status == 'In-Followup'){
		$followup_status = 'In-Followup';
	}
	else{
		$followup_status=$enquiry_status1['followup_status'];
	}

	if($followup_status == 'Converted'){
		$bg = 'success';
	}
	elseif($followup_status == 'Dropped'){
		$bg = 'danger';
	}
	else{
		$bg = '';
	}
	
	if($enquiry_status_filter!=''){
		if($enquiry_status_filter=='Active' || $enquiry_status_filter=='In-Followup' && $enquiry_status1['followup_reply']==''){
				continue;
		}
		elseif($enquiry_status_filter!="Open" ){
			if($enquiry_status1['followup_status']!=$enquiry_status_filter){
				continue;
			}
		}
	}
	$date = $row['enquiry_date'];
	$yr = explode("-", $date);
	$year =$yr[0];


	$temp_arr = array ( "data" => array( 
		(int)(++$count),
		get_enquiry_id($enquiry_id,$year),
		$row['name'],
		$row['enquiry_type'],
		get_date_user($row['enquiry_date']),
		get_datetime_user($followup_date1)
		)
	);
	if($row['enquiry_type'] == "Package Booking" || $row['enquiry_type'] == "Group Booking"){
		$link = ($row['enquiry_type'] == "Package Booking") ? "home/save" : "group_tour";
		$form_add = '<form style="display:inline-block" action="'. BASE_URL.'view/package_booking/quotation/'.$link.'/index.php" target="_blank" id="frm_booking_1" method="GET">
			<input type="hidden" id="enquiry_id" name="enquiry_id" value="'.$row['enquiry_id'].'">
			<button style="display:inline-block" data-toggle="tooltip" class="btn btn-info btn-sm" title="Create Quick Quotation"><i class="fa fa-plus"></i></button>
		</form>';
		$actions_string .= $form_add;
	}
	
	$temp_arr1 = '<button style="display:inline-block" data-toggle="tooltip" class="btn btn-info btn-sm" onclick="followup_modal('.$row['enquiry_id'].')" title="Add New Followup Details"><i class="fa fa-reply-all"></i></button>';
	//array_push($temp_arr['data'],$temp_arr1);
	$actions_string .= $temp_arr1;

	if($role=='Admin' || $role=='Branch Admin'){
		array_push($temp_arr['data'],$allocated_to);
	 }
	$temp_arr2=array(
		'<button data-toggle="tooltip" style="display:inline-block" class="btn btn-info btn-sm" onclick="update_modal('.$row['enquiry_id'].')" title="Update Details"><i class="fa fa-pencil-square-o"></i></button>',   //////////////LEFT HERE
		'<button data-toggle="tooltip" style="display:inline-block" class="btn btn-info btn-sm" onclick="view_modal('.$row['enquiry_id'] .')" title="View Details"><i class="fa fa-eye"></i></button>'
		
	);
	foreach($temp_arr2 as $vals) $actions_string .= $vals;
	if($role=="Admin" || $role=='Branch Admin'){ 
		
		$temp_arr3= '<button data-toggle="tooltip" style="display:inline-block" class="btn btn-danger btn-sm" onclick="enquiry_status_disable('.$row['enquiry_id'] .')" title="Delete Enquiry"><i class="fa fa-times"></i></button>';
		//array_push($temp_arr['data'],$temp_arr3);
		$actions_string .= $temp_arr3;
	 } 	
	 array_push($temp_arr['data'] , $actions_string);
	 $temp_arr['bg'] = $bg;
	 array_push($array_s,$temp_arr); 
	}
	echo json_encode($array_s);
?>