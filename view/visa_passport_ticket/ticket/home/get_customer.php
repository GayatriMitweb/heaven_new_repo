<?php include "../../../../model/model.php";
$customer = $_POST['customer'];
$sq = mysql_fetch_assoc(mysql_query("select first_name,last_name,company_name,type from customer_master where customer_id ='$customer'"));
echo ($sq['type'] == 'Corporate' || $sq['type'] == 'B2B') ? $sq['type'].'-'.$sq['company_name'] : $sq['type'].'-'.$sq['first_name'].' '.$sq['last_name'];
?>