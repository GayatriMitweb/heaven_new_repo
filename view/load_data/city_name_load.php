<?php include "../../model/model.php"; ?>
<?php 

$tour_id = $_POST['tour_id'];
?>
<option value="">Select City Name</option>
<?php
$sq = mysql_query(" select * from tour_city_names where tour_id='$tour_id'");
while($row = mysql_fetch_assoc($sq))
{
	$city_name = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$row[city_id]'")); 
?>
	<option value="<?php echo $row['city_id'] ?>"><?php echo $city_name['city_name'] ?></option>
<?php	
}

?>