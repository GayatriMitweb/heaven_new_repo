<?php
include'../../model/model.php';
$taxation_id=$_POST['taxation_id'];

$sq_taxation = mysql_fetch_assoc(mysql_query("select * from taxation_master where taxation_id='$taxation_id'"));
?>
<input type="hidden" name="tax_amount" id="tax_amount" value="<?= ($sq_taxation['tax_in_percentage']=='')? 0:$sq_taxation['tax_in_percentage']?>">