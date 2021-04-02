<?php 
include "../../../../model/model.php"; 

$country_name = $_POST['country_name'];
?>
<option value="">State</option>
<?php
$sq_state = mysql_query("select state_name from country_state_list where country_name='$country_name' and state_name!=''");
while($row_state = mysql_fetch_assoc($sq_state)){
	?>
	<option value="<?= $row_state['state_name'] ?>"><?= $row_state['state_name'] ?></option>
	<?php
}
?>