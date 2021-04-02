<?php
include "../../model/model.php";
$customer_id = $_POST['customer_id'];
$info_arr = array();
$total_amount = 0;

//Customer Info
$sq_cust_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));

$contact_no = $encrypt_decrypt->fnDecrypt($sq_cust_info['contact_no'], $secret_key);
$email_id = $encrypt_decrypt->fnDecrypt($sq_cust_info['email_id'], $secret_key);

$birthdate = get_date_user($sq_cust_info['birth_date']);
$info_arr['first_name'] = $sq_cust_info['first_name'];
$info_arr['last_name'] = $sq_cust_info['last_name'];
$info_arr['middle_name'] = $sq_cust_info['middle_name'];
$info_arr['gender'] = $sq_cust_info['gender'];
$info_arr['birth_date'] = $birthdate;
$info_arr['age'] = $sq_cust_info['age'];
$info_arr['contact_no'] = $contact_no;
$info_arr['email_id'] = $email_id;
$info_arr['company_name'] = $sq_cust_info['company_name'];

//Credit Note Info
$sq_credit_note = mysql_query("select * from credit_note_master where customer_id='$customer_id'");
while($row = mysql_fetch_assoc($sq_credit_note)){
	$total_amount += $row['payment_amount'];
}
$info_arr['payment_amount'] = $total_amount;
echo json_encode($info_arr);
?>