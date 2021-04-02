<?php
include "../../../model/model.php";

$vendor_id = $_POST['vendor_id'];

$sq_vehicle_entries = mysql_query("select * from car_rental_vendor_vehicle_entries where vendor_id='$vendor_id'");
while($row_veh = mysql_fetch_assoc($sq_vehicle_entries)){
	?>
	<option value="<?= $row_veh['vehicle_id'] ?>"><?= $row_veh['vehicle_name'].'('.$row_veh['vehicle_no'].')' ?></option>
	<?php
}
?>