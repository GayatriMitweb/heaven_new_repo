<?php include "../../model/model.php"; ?>
<?php

$city_id = $_POST['city_id'];
?>
<option value="select">Select Transport Agency Name</option>
<?php
$sq = mysql_query("select transport_agency_id, transport_agency_name from transport_agency_master where city_id='$city_id'");
while($row = mysql_fetch_assoc($sq))
{
?>
<option value="<?php echo $row['transport_agency_id'] ?>"><?php echo $row['transport_agency_name'] ?></option>
<?php	
}
 ?>