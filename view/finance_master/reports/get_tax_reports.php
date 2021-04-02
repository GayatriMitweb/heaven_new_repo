<?php
include '../../../model/model.php';
$report_id = $_POST['report_id'];
?>
<select id="tax_report_list" width="100%" class="form-control" onchange="tax_report_reflect(this.id);get_sale_purchase_cancel(this.id);">
	<?php if($report_id == 'GST Reports'){
	?>
		<option value="ITC Report">ITC Report</option>
		<option value="GST on Sales">GST on Sales</option>
		<option value="GST on Cancellation">GST on Cancellation</option>
	<?php
	}
    if($report_id == 'TDS Reports'){
	?>
		<option value="TDS Receivable">TDS Receivable</option>
		<option value="TDS Payable">TDS Payable</option>
	<?php 
	}
	if($report_id == 'Labour Law Taxes'){ ?>
		<option value="Provident Fund Payable">Provident Fund Payable</option>
		<option value="ESIC Payable">ESIC Payable</option>
		<option value="PT Payable">PT Payable</option>
		<option value="Other Compliances">Other Compliances</option>
	<?php }
	?>
</select>
<script type="text/javascript">
	tax_report_reflect('tax_report_list');
</script>