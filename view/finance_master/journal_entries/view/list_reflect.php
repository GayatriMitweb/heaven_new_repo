<?php 
include "../../../../model/model.php";
$from_date_filter = $_POST['from_date_filter'];
$to_date_filter = $_POST['to_date_filter'];
$ledger_id = $_POST['ledger_id'];

$sq_q = "select * from finance_transaction_master where gl_id='$ledger_id' and payment_amount != '0' ";
if($from_date_filter != '' && $to_date_filter){
	$from_date_filter = date('Y-m-d', strtotime($from_date_filter));
	$to_date_filter = date('Y-m-d', strtotime($to_date_filter));
	$sq_q .= " and  payment_date between '$from_date_filter' and '$to_date_filter' ";
}

$sq_lq = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$ledger_id' "));

?>
<div class="row"> <div class="col-md-12 mg_tp_20"><div class="table-responsive">
	<table class="table table-hover table-bordered" id="tbl_list_ledger_sub" style="margin: 20px 0 !important;">
		<thead>
			<tr class="table-heading-row">
				<th>SR.NO</th>
				<th>Date</th>
				<th>Particulars</th>				
				<th>Debit</th>
				<th>Credit</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="2"></td>
				<td><?php echo "Opening Balance"; ?></td>
				<td><?php echo ($sq_lq['dr_cr']=='Dr') ? $sq_lq['balance'] : ''; ?></td>
				<td><?php echo ($sq_lq['dr_cr']=='Cr') ? $sq_lq['balance'] : ''; ?></td>
			</tr>
		<?php
			$sq_ledger_info = mysql_query($sq_q);
			$balance = 0;
			$total_debit = ($sq_lq['dr_cr']=='Dr') ? $sq_lq['balance'] : '0';
			$total_credit = ($sq_lq['dr_cr']=='Cr') ? $sq_lq['balance'] : '0';
			$count = 1;
			while($row_ledger = mysql_fetch_assoc($sq_ledger_info)){
				$sq_le_name = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$row_ledger[gl_id]'"));
				$debit_amount = ($row_ledger['payment_side'] == 'Debit') ? $row_ledger['payment_amount'] : '' ;
				$credit_amount = ($row_ledger['payment_side'] == 'Credit') ? $row_ledger['payment_amount'] : '' ;
			?>

				<tr>
					<td><?= $count ?></td>
					<td><?= get_date_user($row_ledger['payment_date']) ?></td>
					<td style="cursor:pointer;text-decoration: underline;" onclick="show_history('<?= $row_ledger[module_entry_id] ?>','<?= $row_ledger[module_name] ?>','<?= $row_ledger[finance_transaction_id] ?>','<?= $row_ledger[payment_particular] ?>','<?= $sq_le_name[ledger_name] ?>')"><?= $sq_le_name['ledger_name'].' ('.$row_ledger['module_entry_id'].'_'.$row_ledger['module_name'].')' ?></td>
					<td><?= $debit_amount ?></td>
					<td><?= $credit_amount ?></td>
				</tr>
			<?php  
				$count++;

				if($row_ledger['payment_side'] == 'Debit'){
					$total_debit += $row_ledger['payment_amount'];
				} 
				else{
					$total_credit += $row_ledger['payment_amount'];
				}
			} //while close

				if($total_debit>$total_credit){
					$balance =  $total_debit - $total_credit;
					$side_t='(Dr)';
				}
				else{
					$balance =  $total_credit - $total_debit;	
					$side_t='(Cr)';
				} ?>
		</tbody>
		<tfoot>		
			<tr class="table-heading-row">
				<td></td>
				<td></td>
				<td class="text-right">Current Total : </td>
				<td><?= number_format($total_debit,2) ?></td>
				<td><?= number_format($total_credit,2) ?></td>
			</tr>
			<tr class="table-heading-row">
				<td></td>
				<td></td>
				<td class="text-right" class="text-right">TOTAL BALANCE : </td>
				<td><?= number_format($balance,2).$side_t ?> </td>
				<td></td>
			</tr>
		</tfoot>
	</table>
	</div></div></div>
<script>

$('#tbl_list_ledger_sub').dataTable({
		"pagingType": "full_numbers"
});

</script>