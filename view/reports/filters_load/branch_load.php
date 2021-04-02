<?php
include "../../../model/model.php"; ?>
<option value="">Select Branch Name</option>
<?php 
$location_id=$_GET['location_id'];

$query = "select distinct(branch_id) from emp_master where 1 ";

if($location_id != ''){
 $query .= " and location_id = '$location_id'";
}
$sq = mysql_query($query);
while($row=mysql_fetch_assoc($sq))
{
     $sq_branch = mysql_fetch_assoc(mysql_query("select * from branches where branch_id = '$row[branch_id]'")); 	

     echo "<option value='$sq_branch[branch_id]'>".$sq_branch['branch_name']."</option>";
}