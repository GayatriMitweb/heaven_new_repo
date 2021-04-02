<?php

include "../../../../../model/model.php";

$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$financial_year_id = $_POST['financial_year_id'];
$branch_admin_id = $_POST['branch_admin_id'];
$sfinancial_year_id = $_SESSION['financial_year_id'];
$sbranch_admin_id = $_SESSION['branch_admin_id'];

$url = BASE_URL."model/app_settings/print_html/finance_reports/balance_sheet_report.php?from_date=$from_date&to_date=$to_date&financial_year_id=$financial_year_id&branch_admin_id=$branch_admin_id&sfinancial_year_id=$sfinancial_year_id&sbranch_admin_id=$sbranch_admin_id";
?>

<script type="text/javascript">
  loadOtherPage('<?= $url ?>');
</script>