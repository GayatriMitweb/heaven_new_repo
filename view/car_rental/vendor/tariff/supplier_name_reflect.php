<?php include "../../../../model/model.php"; ?>
<?php 

$city_id = $_GET['city_id'];
?>
<option value="">Select Hotel</option>
<?php
$sq_hotel = mysql_query("select vendor_id, vendor_name from car_rental_vendor where city_id='$city_id' and active_flag='Active'");
while($row_hotel = mysql_fetch_assoc($sq_hotel))
{
?>
	<option value="<?php echo $row_hotel['vendor_id'] ?>"><?php echo $row_hotel['vendor_name'] ?></option>
<?php	
}

?>