<?php include "../../../../../model/model.php";
$asset_type = $_POST['asset_type'];

$sq_query = mysql_query("select * from fixed_asset_master where asset_type ='$asset_type'"); ?>

<option value="">Select Asset</option>
<?php 
while($row_query = mysql_fetch_assoc($sq_query)){ ?>
  <option value="<?= $row_query['entry_id'] ?>"><?= $row_query['asset_name'] ?></option>
<?php } ?>