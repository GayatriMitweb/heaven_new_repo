<?php 
include_once('../../../../model/model.php');
$city_id = $_POST['city_id'];
?>

<?php
$sq_excursion = mysql_query("select * from excursion_master_tariff where city_id='$city_id'");
?>
<option value="">Select Excursion</option>
<?php
while($row_excursion = mysql_fetch_assoc($sq_excursion))
{
?>
	<option value="<?php echo $row_excursion['entry_id'] ?>"><?php echo $row_excursion['excursion_name'] ?></option>
<?php	
}
?>