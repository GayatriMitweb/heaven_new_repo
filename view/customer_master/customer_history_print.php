<?php
include "../../model/model.php";

$customer_id = $_POST['customer_id'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];

$b_url = BASE_URL."model/app_settings/print_html/customer_ledger/report_reflect.php?customer_id=$customer_id&from_date=$from_date&to_date=$to_date";
echo $b_url;
?>