<?php 

include "../../../model/model.php"; 

include "../../../model/group_tour/transport_agency/transport_agency.php"; 

include "../../../model/vendor_login/vendor_login_master.php";
include_once('../../../model/app_settings/transaction_master.php');

$city_id = $_POST["city_id"];
$transport_agency_name = $_POST["transport_agency_name"];
$mobile_no = $_POST["mobile_no"];
$landline_no = $_POST["landline_no"];
$email_id = $_POST["email_id"];
$contact_person_name = $_POST["contact_person_name"];
$immergency_contact_no = $_POST['immergency_contact_no'];
$country = $_POST['country'];
$website = $_POST['website'];
$transport_agency_address = $_POST["transport_agency_address"];
$opening_balance = $_POST['opening_balance'];
$active_flag = $_POST['active_flag'];
$service_tax_no = $_POST['service_tax_no'];
$bank_name = $_POST['bank_name'];
$account_name = $_POST['account_name'];
$account_no = $_POST['account_no'];
$branch = $_POST['branch'];
$ifsc_code = $_POST['ifsc_code'];
$state = $_POST['state'];
$side = $_POST['side'];
$supp_pan = $_POST['supp_pan'];
$as_of_date = $_POST['as_of_date'];
$transport_agency = new transport_agency();
$transport_agency->transport_agency_master_save( $city_id, $transport_agency_name, $mobile_no, $landline_no, $email_id, $contact_person_name, $immergency_contact_no, $transport_agency_address, $country, $website, $opening_balance, $active_flag, $service_tax_no, $bank_name,$account_name, $account_no, $branch, $ifsc_code, $state,$side,$supp_pan,$as_of_date);

?>