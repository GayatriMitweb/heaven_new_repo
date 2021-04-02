<?php include "../../model/model.php"; ?>
<?php

$city_id = $_GET['city_id']; ?>
 <option value="">*Sector </option>
 <?php 
$sq = mysql_query("select * from airport_master where city_id='$city_id' and flag='Active'");
while($row = mysql_fetch_assoc($sq))
{
?>
<option value="<?php echo $row['airport_name'].'('.$row['airport_code'].')'  ?>"><?php echo $row['airport_name'].'('.$row['airport_code'].')' ?></option>
<?php	
}
 ?>