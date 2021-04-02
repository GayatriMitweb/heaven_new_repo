<?php include "../../../model/model.php";
global $secret_key, $encrypt_decrypt;
$password=mysql_real_escape_string($_POST['password']);
$username=mysql_real_escape_string($_POST['username']);
$agent_code=mysql_real_escape_string($_POST['agent_code']);

$username = $encrypt_decrypt->fnEncrypt($username, $secret_key);
$password = $encrypt_decrypt->fnEncrypt($password, $secret_key);

$row_count=mysql_num_rows(mysql_query("select * from b2b_registration where username='$username' and password='$password' and active_flag='Active' and approval_status='Approved' and agent_code='$agent_code'"));
if($row_count>0){

	$sq = mysql_fetch_assoc(mysql_query("select * from b2b_registration where username='$username' and password='$password' and active_flag='Active' and approval_status='Approved' and agent_code='$agent_code'"));
	$register_id = $sq['register_id'];
	$customer_id = $sq['customer_id'];

	$_SESSION['b2b_agent_code'] = $agent_code;
	$_SESSION['b2b_username'] = $username;
	$_SESSION['b2b_password'] = $password;
	$_SESSION['register_id'] = $register_id; 
	$_SESSION['company_name'] = $sq['company_name'];
	$_SESSION['customer_id'] = $customer_id;

	//Get Approved Credit Limit Amount
	$sq_credit = mysql_fetch_assoc(mysql_query("select credit_amount from b2b_creditlimit_master where register_id='$register_id' and approval_status='Approved' order by entry_id desc"));
	//Get Booking + Payment amount to calculate outstanding amount
	$sq_booking = mysql_query("select * from b2b_booking_master where customer_id='$customer_id'");
	$net_total = 0;
	$paid_amount = 0;
	while($row_booking = mysql_fetch_assoc($sq_booking)){
		$cart_checkout_data = json_decode($row_booking['cart_checkout_data']);
		for($i=0;$i<sizeof($cart_checkout_data);$i++){
			$tax_arr = explode(',',$cart_checkout_data[$i]->service->hotel_arr->tax);
			for($j=0;$j<sizeof($cart_checkout_data[$i]->service->item_arr);$j++){
				$room_types = explode('-',$cart_checkout_data[$i]->service->item_arr[$j]);
				$room_cost = $room_types[2];
				
				$tax_amount = ($room_cost * $tax_arr[1] / 100);
				$total_amount = $room_cost + $tax_amount;
			
				$hotel_total += $total_amount;
			}
		}
		if($row_booking['coupon_code'] != ''){
			$sq_coupon = mysql_fetch_assoc(mysql_query("select offer,offer_amount from hotel_offers_tarrif where coupon_code='$row_booking[coupon_code]'"));
			if($sq_coupon['offer']=="Flat"){
			$hotel_total = $hotel_total - $sq_coupon['offer_amount'];
			}else{
				$hotel_total = $hotel_total - ($hotel_total*$sq_coupon['offer_amount']/100);
			}
			
		}
		$net_total += $hotel_total;
        // Paid Amount
        $sq_payment_info = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from b2b_payment_master where booking_id='$row_booking[booking_id]' and (clearance_status!='Pending' or clearance_status!='Cancelled')"));
        $payment_amount = $sq_payment_info['sum'];
        $paid_amount +=$sq_payment_info['sum'];

	}
	$outstanding =  $hotel_total - $paid_amount;
	$available_credit = $sq_credit['credit_amount'] - $outstanding;
	$available_credit = ($available_credit < 0)? 0.00 : $available_credit;
	$_SESSION['credit_amount'] = $available_credit;

	echo "valid--".$sq['cart_data'];
}	
else{
	echo "Invalid Login Credentials!--";
}
?>