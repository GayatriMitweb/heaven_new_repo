<?php 

class supplier_package_master{

public function package_save()
{

	$city_id = $_POST['city_id'];
	$supplier_id = $_POST['supplier_id'];
	$supplier_name = $_POST['supplier_name'];
    $active_flag = $_POST['active_flag'];
	$photo_upload_url =$_FILES['upload']['name'];
	$tmp_names = $_FILES['upload']['tmp_name'];
	$valid_from = $_POST['valid_from'];
	$valid_to = $_POST['valid_to'];
	
	$created_at = date('Y-m-d H:i:s');
	$valid_from = get_date_db($valid_from);
	$valid_to = get_date_db($valid_to);

	//multi upload
	$year = date("Y");
	$month = date("M");
	$day = date("d");
	$timestamp = date('U');
	$year_status = false;
	$month_status = false;
	$day_status = false;
	function check_dir($current_dir, $type)
	{	 	
		if(!is_dir($current_dir."/".$type)){
			mkdir($current_dir."/".$type);		
		}	
		$current_dir = $current_dir."/".$type."/";
		return $current_dir;	
	}

$current_dir = '../../uploads/';
$current_dir = check_dir($current_dir ,'emp_photo_proof');
$current_dir = check_dir($current_dir , $year);
$current_dir = check_dir($current_dir , $month);
$current_dir = check_dir($current_dir , $day);
$current_dir = check_dir($current_dir , $timestamp);


//$file = $current_dir.basename($_FILES['uploadfile']['name']);
/// end multi file upload
$locs = array();
for($i=0;$i<sizeof($photo_upload_url);$i++){
	$file = basename($photo_upload_url[$i]);
	if (move_uploaded_file($tmp_names[$i], $current_dir.basename($photo_upload_url[$i]))) { 

		$locs[$i] = $file;
		//echo $file; 
	  
	  } else {
	  
		  echo "error";exit;
	  
	  }
}
	$sq_max = mysql_fetch_assoc(mysql_query("select max(package_id) as max from supplier_packages"));

	$id = $sq_max['max'] + 1;

$loc_str = mysql_real_escape_string(implode(";",$locs));

$sq_service = mysql_query("insert into supplier_packages (package_id, city_id, supplier_type, name,active_flag,file_prefix ,image_upload_url,valid_from,valid_to,created_at) values ('$id', '$city_id', '$supplier_id','$supplier_name','$active_flag','$current_dir','$loc_str','$valid_from','$valid_to',  '$created_at')");

	if($sq_service){

		echo "Supplier Packages has been successfully saved.";

		exit;

	}

	else{

		echo "error--Sorry, Package not saved!";

		exit;

	}

}



public function package_update()

{

	$package_id = $_POST['package_id'];
	$city_id = $_POST['city_id'];
	$supplier_id = $_POST['supplier_id'];
	$supplier_name = $_POST['supplier_name'];
    $active_flag = $_POST['active_flag'];
    $valid_from = $_POST['valid_from'];
	$valid_to = $_POST['valid_to'];
	$photo_upload_url =$_FILES['upload1']['name'];
	$tmp_names = $_FILES['upload1']['tmp_name'];

	//multi upload
	$year = date("Y");
	$month = date("M");
	$day = date("d");
	$timestamp = date('U');
	$year_status = false;
	$month_status = false;
	$day_status = false;
	function check_dir($current_dir, $type)
	{	 	
		if(!is_dir($current_dir."/".$type)){
			mkdir($current_dir."/".$type);		
		}	
		$current_dir = $current_dir."/".$type."/";
		return $current_dir;	
	}

$current_dir = '../../uploads/';
$current_dir = check_dir($current_dir ,'emp_photo_proof');
$current_dir = check_dir($current_dir , $year);
$current_dir = check_dir($current_dir , $month);
$current_dir = check_dir($current_dir , $day);
$current_dir = check_dir($current_dir , $timestamp);

$locs = array();
for($i=0;$i<sizeof($photo_upload_url);$i++){
	$file = basename($photo_upload_url[$i]);
	if (move_uploaded_file($tmp_names[$i], $current_dir.basename($photo_upload_url[$i]))) { 

		$locs[$i] = $file;
		//echo $file; 
	  
	  } else {
	  
		  echo "error";exit;
	  
	  }
}
$loc_str = mysql_real_escape_string(implode(";",$locs));
	
	$valid_from = get_date_db($valid_from);
	$valid_to = get_date_db($valid_to);

	$sq_service = mysql_query("update supplier_packages set city_id='$city_id', supplier_type='$supplier_id', name='$supplier_name',valid_from ='$valid_from',valid_to='$valid_to',image_upload_url='$loc_str',active_flag = '$active_flag',file_prefix='$current_dir' where package_id='$package_id'");
	if($sq_service){

		echo "Supplier Packages has been successfully updated.";

		exit;

	}

	else{

		echo "error--Sorry, Package not updated!";

		exit;

	}

}
/*
public function package_img_update()

	{

		$img_upload_url = $_POST['img_upload_url'];

		$package_id = $_POST['package_id'];

		$sq_service = mysql_query("update supplier_packages set image_upload_url='$img_upload_url' where package_id='$package_id'");
	} 
*/
}

?>