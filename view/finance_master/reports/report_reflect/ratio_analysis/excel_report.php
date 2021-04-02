<?php

include "../../../../../model/model.php";

$from_date = $_POST['from_date'];
$financial_year_id = $_POST['financial_year_id'];
$branch_admin_id = $_POST['branch_admin_id'];

$url = BASE_URL."model/app_settings/print_html/finance_reports/ratio_analysis.php?from_date=$from_date&financial_year_id=$financial_year_id&branch_admin_id=$branch_admin_id";
?>

<script type="text/javascript">
  loadOtherPage('<?= $url ?>');
</script>