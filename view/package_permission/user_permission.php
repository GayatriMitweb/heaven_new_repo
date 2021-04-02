<?php
include '../../model/model.php';
$sq_emp_count = mysql_num_rows(mysql_query("select * from emp_master"));
echo $sq_emp_count;
?>