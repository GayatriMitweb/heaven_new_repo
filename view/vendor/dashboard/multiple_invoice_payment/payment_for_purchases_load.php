<?php
include "../../../../model/model.php";
$vendor_type = $_POST['vendor_type'];
$vendor_type_id = $_POST['vendor_type_id'];

$sq_ledger_count = mysql_num_rows(mysql_query("select * from ledger_master where customer_id='$vendor_type_id' and user_type='$vendor_type' and group_sub_id='23'"));
if($sq_ledger_count != '0'){
?>
<!-- ===============================================PrePurchase Advance========================================================================= -->
<div class="panel panel-default panel-body app_panel_style mg_tp_20 feildset-panel">
    <legend>Advance Details</legend>
		<div class="row mg_tp_20">
			<div class="col-md-5">
				<?php
				$total_debit = 0;
				$total_credit = 0;
				$balance = 0;
				$sq_ledger = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$vendor_type_id' and user_type='$vendor_type' and group_sub_id='23'"));
				if($sq_ledger['ledger_id'] != '')
				{
					$sq_advance1 = mysql_query("select * from finance_transaction_master where gl_id='$sq_ledger[ledger_id]'");

					while($sq_advance = mysql_fetch_assoc($sq_advance1)){
						if($sq_advance['payment_side'] == 'Debit'){
							$total_debit += $sq_advance['payment_amount'];
						} 
						else{
							$total_credit += $sq_advance['payment_amount'];
						}

						if($sq_ledger['dr_cr'] == 'Dr'){
							$balance =  $total_debit - $total_credit;
						}
						else{
							$balance = $total_credit - $total_debit;
						}
					}
					echo $sq_ledger['ledger_name'].' : '.'('.$sq_ledger['dr_cr'].')';
				}
				?>
			</div>
			<div class="col-md-2">
				<input type="text" class="form-control" id="advance_amount" title="Advance Amount" name="advance_amount" value="<?= ($balance) ?>" readonly>
			</div>
			<div class="col-md-5">
				<input type="text" placeholder="Advances to be nullify" title="Advances to be nullify" class="form-control" id="advance_nullify" name="advance_nullify" onchange="pay_amount_nullify('advance_amount',this.id)">
			</div>
		</div>
</div>
<?php } ?>
<!-- ===============================================Debit Note========================================================================= -->
<?php
$sq_debit_count = mysql_num_rows(mysql_query("select * from debit_note_master where vendor_type='$vendor_type' and vendor_type_id='$vendor_type_id'"));
if($sq_debit_count != '0')
{
	$sq_debit_note = mysql_query("select * from debit_note_master where vendor_type='$vendor_type' and vendor_type_id='$vendor_type_id'");
	while($row_debit_note = mysql_fetch_assoc($sq_debit_note)){
		$total_debit_amount += $row_debit_note['payment_amount'];
	}
	if($total_debit_amount != '0')
	{
	?>
	<div class="panel panel-default panel-body app_panel_style mg_tp_20 feildset-panel">
	<legend>Debit Note Details</legend>
		<div class="row mg_tp_20">
			<div class="col-md-3">
				<?php echo "Debit Note Amount : " ?>
			</div>
	 		<div class="col-md-3">
				<input type="text" class="form-control" id="debit_note_amount" name="debit_note_amount" title="Debit Note Amount" value="<?= ($total_debit_amount) ?>" readonly>
			</div>
		</div>
	</div>
<?php } } ?>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>