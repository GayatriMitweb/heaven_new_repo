<?php
include "../../../../model/model.php";
$visa_type = $_POST['visa_type'];
$visa_country = $_POST['visa_country'];
$sum_visa_amount=0;$sum_visa_markup = 0;

$values = mysql_fetch_assoc(mysql_query("Select fees, markup from visa_crm_master where visa_type='$visa_type' and country_id='$visa_country'"));

echo json_encode(array("amount" => $values['fees'], "service" => $values['markup']));
?>