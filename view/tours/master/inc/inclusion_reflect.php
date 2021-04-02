<?php
include "../../../../model/model.php";

$tour_type = $_POST['tour_type'];
$type = $_POST['type'];

$includes = '';
if($type == 'package'){
	$sq_inc = mysql_query("select * from inclusions_exclusions_master where active_flag='Active' and for_value in('package','Both') and type='Inclusion' and tour_type in ('$tour_type', 'Both')");
}
else{
	$sq_inc = mysql_query("select * from inclusions_exclusions_master where active_flag='Active' and for_value in('Group','Both') and type='Inclusion' and tour_type in ('$tour_type', 'Both')");
}
while($row_inc = mysql_fetch_assoc($sq_inc)){
	$includes .= $row_inc['inclusion']."<br>";
}


$excludes = '';
if($type == 'package'){
	$sq_exc = mysql_query("select * from inclusions_exclusions_master where active_flag='Active' and for_value in('package','Both') and type='Exclusion' and tour_type in ('$tour_type', 'Both')");
}
else{
	$sq_exc = mysql_query("select * from inclusions_exclusions_master where active_flag='Active' and for_value in('Group','Both') and type='Exclusion' and tour_type in ('$tour_type', 'Both')");
}
while($row_exc = mysql_fetch_assoc($sq_exc)){
	$count++;
	$excludes .= $row_exc['inclusion']."<br>";
}

$arr = array(
			'includes' => $includes,
			'excludes' => $excludes
	   );
echo json_encode($arr);
?>