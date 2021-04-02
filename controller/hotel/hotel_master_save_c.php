<?php
include "../../model/model.php";
include "../../model/hotel/hotel_master.php";
include "../../model/vendor_login/vendor_login_master.php";
include_once('../../model/app_settings/transaction_master.php');

$city_id = $_POST["city_id"];
$hotel_name = $_POST["hotel_name"];
$mobile_no = $_POST["mobile_no"];
$landline_no = $_POST['landline_no'];
$email_id = $_POST["email_id"];
$email_id_1 = $_POST["email_id_1"];
$email_id_2 = $_POST["email_id_2"];
$contact_person_name = $_POST["contact_person_name"];
$immergency_contact_no = $_POST['immergency_contact_no'];
$hotel_address = $_POST["hotel_address"];
$country = $_POST['country'];
$website = $_POST['website'];
$opening_balance = $_POST['opening_balance'];
$rating_star = $_POST['rating_star'];
$bank_name = $_POST['bank_name'];
$account_name = $_POST['account_name'];
$account_no = $_POST['account_no'];
$branch = $_POST['branch'];
$ifsc_code =$_POST['ifsc_code'];
$active_flag = $_POST['active_flag'];
$service_tax_no = $_POST['service_tax_no'];
$state = $_POST['state'];
$side = $_POST['side'];
$supp_pan = $_POST['supp_pan'];
$hotel_image_path = $_POST['hotel_image_path'];
$as_of_date = $_POST['as_of_date'];
$description = $_POST['description'];
$policies = $_POST['policies'];
$amenities = $_POST['amenities'];
$hotel_type = $_POST['hotel_type'];
$meal_plan = $_POST['meal_plan'];
$cwb_from = $_POST['cwb_from'];
$cwb_to = $_POST['cwb_to'];
$cwob_from = $_POST['cwob_from'];
$cwob_to = $_POST['cwob_to'];

$hotel_master = new hotel_master();
$hotel_master->hotel_master_save($city_id, $hotel_name, $mobile_no, $landline_no, $email_id,$email_id_1,$email_id_2, $contact_person_name, $immergency_contact_no, $hotel_address, $country,$website, $opening_balance,$rating_star, $active_flag, $bank_name, $account_name, $account_no, $branch,$ifsc_code,  $service_tax_no, $state,$side,$supp_pan,$hotel_image_path,$as_of_date,$description,$policies,$amenities,$hotel_type,$meal_plan,$cwb_from,$cwb_to,$cwob_from,$cwob_to);
?>