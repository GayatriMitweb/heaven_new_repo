<?php include "../../../model/model.php";
$city_id = $_GET['city_id'];?>
<option value="">Select Excursion</option>
<?php
$sq_exc = mysql_query("select entry_id, excursion_name from excursion_master_tariff where city_id='$city_id' and active_flag='Active'");
while($row_exc = mysql_fetch_assoc($sq_exc)){
?>
	<option value="<?php echo $row_exc['entry_id'] ?>"><?php echo $row_exc['excursion_name']; ?></option>
<?php } ?>