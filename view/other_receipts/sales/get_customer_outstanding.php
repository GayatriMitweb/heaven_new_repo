<?php
include "../../../model/model.php";
$customer_id = $_POST['cust_id'];
if($customer_id != ''){
?>
<div class="row"> <div class="col-md-12"> <div class="table-responsive">
<table class="table table-bordered cust_table" id="tbl_list_sales" style="padding: 0 !important; background: #fff;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Sale</th>
			<th>Sale ID</th>
			<th class="text-right">Amount</th>
			<th class="text-center">Select</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		//Get Booking rows
		include "get_customer_booking.php"; ?>
	</tbody>
</table>
</div> </div> </div>

<div class="row mg_tp_20">
	<div class="col-md-3 col-md-offset-7">
		<input type="text" placeholder="Total outstanding" title="Total outstanding" value="0.00" class="form-control text-right" id="total_purchase" name="total_purchase" readonly>
	</div>
</div>

<?php 
$sq_ledger_count = mysql_num_rows(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer' and group_sub_id='22'"));
if($sq_ledger_count != '0'){
?>
<div class="panel panel-default panel-body app_panel_style mg_tp_20 feildset-panel">
    <legend>Advance Details</legend>
<div class="row mg_tp_20">
 <div class="col-md-5">
	<?php
	$total_debit = 0;
	$total_credit = 0;
	$sq_ledger = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer' and group_sub_id='22'"));
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
	<input type="text" placeholder="Advances to be nullified" title="Advances to be nullified" class="form-control" id="advance_nullify" name="advance_nullify" onchange="pay_amount_nullify('advance_amount',this.id)">
 </div>
</div>
</div>
<?php } ?>

<!-- ======================================================================================================================== -->
<?php
$sq_credit_count = mysql_num_rows(mysql_query("select * from credit_note_master where customer_id='$customer_id'"));
if($sq_credit_count != '0')
{
	$sq_credit_note = mysql_query("select * from credit_note_master where customer_id='$customer_id'");
	while($row_credit_note = mysql_fetch_assoc($sq_credit_note)){
		$total_credit_amount += $row_credit_note['payment_amount'];
	}
	if($total_credit_amount != '0'){
	?>
	<div class="panel panel-default panel-body app_panel_style mg_tp_20 feildset-panel">
	<legend>Credit Note Details</legend>
		<div class="row mg_tp_20">
			<div class="col-md-3">
				<?php echo "Credit Note Amount : " ?>
			</div>
	 		<div class="col-md-3">
				<input type="text" class="form-control" id="credit_note_amount" name="credit_note_amount" title="Credit Note Amount" value="<?= ($total_credit_amount) ?>" readonly>
			</div>
		</div>
	</div>
<?php } 
} ?>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>
<?php } ?>