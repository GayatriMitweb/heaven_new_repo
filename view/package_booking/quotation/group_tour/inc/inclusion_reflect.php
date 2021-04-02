<?php
include "../../../../../model/model.php";

$tour_id = $_POST['tour_id'];

$includes = '';
$excludes = '';
$sq_inc = mysql_query("select * from tour_master where active_flag='Active' and tour_id='$tour_id'");
while($row_inc = mysql_fetch_assoc($sq_inc)){
	$includes .= $row_inc['inclusions']."<br>";
	$excludes .= $row_inc['exclusions']."<br>";
}
$arr = array(
			'includes' => $includes,
			'excludes' => $excludes
	   );
echo json_encode($arr);
?>