<?php
include "../../../../model/model.php";

echo '<option value="">Hotel</option>';
$sq_hotel = mysql_query("select * from hotel_master");
while($row_hotel = mysql_fetch_assoc($sq_hotel)){
?>
<option value="<?= $row_hotel['hotel_id'] ?>"><?= $row_hotel['hotel_name'] ?></option>
<?php 
}
?>