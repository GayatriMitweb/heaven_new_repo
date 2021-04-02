<?php 
include_once('../../../model/model.php');

$location_id = $_POST['location_id'];

echo '<option value="">Select Branch</option>';
$sq_branch = mysql_query("select * from branches where location_id='$location_id'and active_flag!='Inactive'order by branch_name ");
while($row_branch = mysql_fetch_assoc($sq_branch)){
	echo '<option value="'.$row_branch['branch_id'].'">'.$row_branch['branch_name'].'</option>';
}
?>