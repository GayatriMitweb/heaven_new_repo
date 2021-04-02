<?php 
include "../../../model/model.php";
$group_id = $_POST['group_id'];
$sq_side = mysql_fetch_assoc(mysql_query("select * from subgroup_master where subgroup_id='$group_id'"));
$side = $sq_side['dr_cr']; 
?>
<option value="<?= $side ?>"><?= $side ?></option>
<?php
if($side == 'Dr'){ ?>
<option value="Cr">Cr</option>
<?php 	} else {
?>
<option value="Dr">Dr</option>
<?php } ?>