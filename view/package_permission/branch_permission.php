<?php
include '../../model/model.php';
$sq_branch_count = mysql_num_rows(mysql_query("select * from branches"));
echo $sq_branch_count;
?>