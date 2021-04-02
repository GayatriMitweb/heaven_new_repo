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

$current_dir = '../../../uploads/';
$current_dir = check_dir($current_dir , 'pan_card');
$current_dir = check_dir($current_dir , $year);
$current_dir = check_dir($current_dir , $month);
$current_dir = check_dir($current_dir , $day);
$current_dir = check_dir($current_dir , $timestamp);

$rand_string = uniqid('image_');
$path = $_FILES['uploadfile1']['name'];
$ext = pathinfo($path, PATHINFO_EXTENSION);
$file = $current_dir.$rand_string.'.'.$ext;

$fileinfo = @getimagesize($_FILES["uploadfile1"]["tmp_name"]);
$width = $fileinfo[0];
$height = $fileinfo[1];
if ($width > "640" || $height > "290") {
	echo "error";		
}
else{
	if(move_uploaded_file($_FILES['uploadfile1']['tmp_name'], $file))
	{ 
	    echo $file; 
	} else {
		echo "error";
	}
}
 
 
?>