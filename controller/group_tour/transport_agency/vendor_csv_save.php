<?php 
include "../../../model/model.php"; 
include "../../../model/group_tour/transport_agency/transport_agency.php";
include "../../../model/vendor_login/vendor_login_master.php";
include_once('../../../model/app_settings/transaction_master.php');

$transport_agency = new transport_agency();
$transport_agency->vendor_csv_save();
?>