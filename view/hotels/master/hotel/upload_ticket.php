<?php
 $year = date("Y");
 $month = date("M");
 $day = date("d");
 $timestamp = date('U');
 $year_status = false;
 $month_status = false;
 $day_status = false;
 
 function check_dir($current_dir, $type)
{	 	
	if(!is_dir($current_dir."/".$type))
	{
		mkdir($current_dir."/".$type);		
	}	
	$current_dir = $current_dir."/".$type."/";
		return $current_dir;	
}

$current_dir = '../../../../uploads/';
$current_dir = check_dir($current_dir ,'hotel_vendor_images');
$current_dir = check_dir($current_dir , $year);
$current_dir = check_dir($current_dir , $month);
$current_dir = check_dir($current_dir , $day);
$current_dir = check_dir($current_dir , $timestamp);

$rand_string = uniqid('image_');
$path = $_FILES['uploadfile']['name'];
$ext = pathinfo($path, PATHINFO_EXTENSION);
$file = $current_dir.$rand_string.'.'.$ext;


if($_FILES['uploadfile']['size']<100000){
	if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
 		 echo $file; 
	} 
	else {
		echo "error";
	}
}
else
{
	echo "error1";
}
/*if($_FILES['uploadfile']['size'] > 1*1048576)
{
	echo "error1";
	exit;
}
 
if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
  echo $file; 
} else {
	echo "error";
}*/
?>