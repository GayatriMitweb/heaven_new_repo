<?php
include "../../../model/model.php";

$vendor_type = $_POST['vendor_type'];
$vendor_type_id = $_POST['vendor_type_id'];
?>


<div class="panel panel-default panel-body app_panel_style mg_tp_30 feildset-panel">
  <legend>Payment Details</legend>
	<div class="row"> <div class="col-md-12 no-pad">
	<div class="table-responsive">
	<table class="table table-bordered table-hover" id="tbl_pr_payment_list" style="margin: 0 !important; padding-bottom: 0 !important;">
		<thead>
			<tr  class="table-heading-row">
				<th>S_No.</th>
				<th>Purchase</th>
				<th>Purchase ID</th>
				<th class="text-right">Amount</th>
				<th class="text-center">Select</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$count=1;
		$sq_supplier = mysql_query("select * from vendor_estimate where vendor_type='$vendor_type' and vendor_type_id='$vendor_type_id'");
		while($row_supplier = mysql_fetch_assoc($sq_supplier)){	
				$total_payment = 0;
				$sq_supplier_p = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as payment_amount from vendor_payment_master where vendor_type='$vendor_type' and vendor_type_id='$vendor_type_id' and estimate_type='$row_supplier[estimate_type]' and estimate_type_id='$row_supplier[estimate_type_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));

				//Consider purchase cancel amount
				if($row_supplier['status'] == 'Cancel'){
					if($row_supplier['cancel_amount'] <= $sq_supplier_p['payment_amount']){
						$balance_amount = 0;
					}
					else{
						$balance_amount =  $row_supplier['cancel_amount'] - $sq_supplier_p['payment_amount'];
					}
				}
				else{
					$balance_amount = $row_supplier['net_total'] - $sq_supplier_p['payment_amount'];
				}

			if($balance_amount > '0'){
				if($row_supplier['estimate_type']=='Group Tour'){
					$sq_tour_group = mysql_fetch_assoc(mysql_query("select * from tour_groups where group_id='$row_supplier[estimate_type_id]'"));
					$tour_group = date('d-m-Y', strtotime($sq_tour_group['from_date'])).' to '.date('d-m-Y', strtotime($sq_tour_group['to_date']));
			
					$sq_tour = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id='$sq_tour_group[tour_id]'"));
					$tour_name = $sq_tour['tour_name'];
					$estimate_type_val = $tour_name."( ".$tour_group." )";
					$title=$estimate_type_val;
				} ?>
			<tr>
				<td class="col-md-2"><?= $count ?></td>
				<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type" value="<?= $row_supplier['estimate_type'] ?>" readonly></td>
				<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id" title="<?= $title ?>" value="<?= $row_supplier['estimate_type_id'] ?>" readonly></td>
				<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= $balance_amount ?>" class="text-right" readonly></td>
				<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>	
			</tr>
				<?php  $count++; }
			} ?>
		</tbody>
	</table>
	</div>
	</div> </div>
</div>
<div class="row mg_tp_20">
	<div class="col-md-3 col-md-offset-7">
		<input type="text" placeholder="Total Purchase" title="Total Purchase" value="0.00" class="form-control text-right" id="total_purchase" name="total_purchase" readonly>
	</div>
</div>

<?php 
$sq_ledger_count = mysql_num_rows(mysql_query("select * from ledger_master where customer_id='$vendor_type_id' and user_type='$vendor_type' and group_sub_id='23'"));
if($sq_ledger_count != '0'){
?>
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
<!-- ======================================================================================================================== -->
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