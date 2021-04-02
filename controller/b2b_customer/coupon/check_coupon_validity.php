<?php include "../../../model/model.php";
$customer_id = $_POST['user_id'];
$coupon_code = $_POST['coupon_code'];

$sq_count = mysql_num_rows(mysql_query("select entry_id from b2b_coupons_applied where customer_id='$customer_id' and coupon_code='$coupon_code' and status='used'"));
if($sq_count>0){
    echo 1;
}else{
    echo 0;
}
?>