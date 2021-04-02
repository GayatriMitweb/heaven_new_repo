<?php
include "../../model/model.php";
$supplier_id = $_POST['supplier_id'];
?>
<div class="row"> <div class="col-md-12">
<div class="table-responsive">
<table class="table table-bordered table-hover" id="tbl_supplier_expense" style="margin: 0 !important; padding-bottom: 0 !important;">
	<thead>
		<tr  class="table-heading-row">
			<th>S_No.</th>
			<th>Expense_ID</th>
			<th>Expense_Type</th>
			<th class="text-right">Amount</th>
			<th class="text-center">Select</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$count=1;
	$sq_supplier = mysql_query("select * from other_expense_master where supplier_id='$supplier_id'");
	while($row_supplier = mysql_fetch_assoc($sq_supplier)){					

		$sq_supplier_p = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as payment_amount from other_expense_payment_master where supplier_id='$supplier_id' and expense_type_id='$row_supplier[expense_type_id]' and expense_id='$row_supplier[expense_id]'  and clearance_status!='Cancelled'"));

		$sq_ledger = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$row_supplier[expense_type_id]'"));		
		$balance_amount = $row_supplier['total_fee'] - $sq_supplier_p['payment_amount'];
		if($balance_amount != '0'){
		?>
		<tr>
			<td class="col-md-2"><?= $count ?></td>
			<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id"  value="<?= $row_supplier['expense_id'] ?>" readonly></td>
			<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= $sq_ledger['ledger_name'] ?>" readonly></td>
			<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= $balance_amount ?>" class="text-right" readonly></td>
			<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>	
			<td class="col-md-1"><input type="hidden" id="pr_expense_type<?= $count ?>" name="pr_expense_type"  value="<?= $row_supplier['expense_type_id'] ?>" readonly></td>
		</tr>	
		<?php  $count++; } ?>
		<?php } ?>
	</tbody>
</table>
</div>
</div> </div>
<div class="row mg_tp_20">
	<div class="col-md-3 col-md-offset-7">
		<input type="text" placeholder="Total Purchase" title="Total Purchase" value="0.00" class="form-control text-right" id="total_purchase" name="total_purchase" readonly>
	</div>
</div>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>