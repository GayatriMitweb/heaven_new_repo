<?php include "../../../model/model.php";
$customer_id = $_POST['user_id'];
$coupon_code = $_POST['coupon_code'];
$used_at = date("Y-m-d H:i:s");

$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from b2b_coupons_applied"));
$entry_id = $sq_max['max'] + 1;
$sq_ledger = mysql_query("insert into b2b_coupons_applied (entry_id, customer_id, coupon_code, status, used_at) values ('$entry_id', '$customer_id','$coupon_code','used','$used_at')");
?>