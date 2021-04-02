<?php

include "../../../../model/model.php";

$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$ledger_id = $_POST['ledger_id'];
$financial_year_id = $_POST['financial_year_id'];
$branch_admin_id = $_POST['branch_admin_id'];
$chk_opnbalance = $_POST['chk_opnbalance'];
$chk_trans = $_POST['chk_trans'];
$dateChunk = $_POST['dateChunk'];

$url = BASE_URL."model/app_settings/print_html/finance_reports/ledger_report.php?from_date=$from_date&to_date=$to_date&financial_year_id=$financial_year_id&branch_admin_id=$branch_admin_id&ledger_id=$ledger_id&chk_opnbalance=$chk_opnbalance&chk_trans=$chk_trans&dateChunk=$dateChunk";
?>
<script type="text/javascript">
  loadOtherPage('<?= $url ?>');
</script>