<?php
include "../../../model/model.php";
$type = $_POST['type'];
$sq_query = mysql_query("select * FROM cms_master where type_id='$type'");
?>
<option value="">Select Email For</option>
<?php
while($row_query = mysql_fetch_assoc($sq_query)){
?>
<option value="<?= $row_query['id'] ?>"><?= $row_query['draft_for']?></option>
<?php } ?>
