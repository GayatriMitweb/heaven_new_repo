<?php include "../../model/model.php"; ?>
<?php

$city_id = $_POST['city_id'];
?>
<option value="select">Select Hotel Name</option>
<?php
$sq = mysql_query("select hotel_id, hotel_name from hotel_master where city_id='$city_id'");
while($row = mysql_fetch_assoc($sq))
{
?>
<option value="<?php echo $row['hotel_id'] ?>"><?php echo $row['hotel_name'] ?></option>
<?php	
}
 ?>