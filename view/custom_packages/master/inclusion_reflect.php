<?php
include "../../../model/model.php";
$package_id = $_POST['package_id'];
$sq_pckg = mysql_fetch_assoc(mysql_query("select inclusions,exclusions from custom_package_master where package_id = '$package_id'"));
$arr = array(
			'includes' => $sq_pckg['inclusions'],
			'excludes' => $sq_pckg['exclusions']
	   );
echo json_encode($arr);
?>