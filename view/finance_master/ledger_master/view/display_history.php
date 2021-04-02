<?php 
include "../../../../model/model.php";
$module_entry_id = $_POST['module_entry_id'];
$module_name = $_POST['module_name'];
$finance_transaction_id = $_POST['finance_transaction_id'];
$payment_perticular = $_POST['payment_perticular'];
$ledger_name = $_POST['ledger_name'];
?>
<div class="modal fade" id="display_history_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?= $ledger_name ?></h4>
      </div>
      <div class="modal-body">
      	<table class="table table-hover table-bordered" id="tbl_list_ledger_sub1" style="margin: 0 !important;  padding: 0px !important;">
		<?php
		$q = "select * from finance_transaction_master where module_entry_id='$module_entry_id' and module_name = '$module_name' and finance_transaction_id != '$finance_transaction_id' and payment_amount != '0'";
		$sq_ledger = mysql_query($q);
			while($row_ledger1 = mysql_fetch_assoc($sq_ledger))
			{ 
				if($row_ledger1['payment_side'] == 'Debit'){
					$side1='(Dr)';
					$bg_color='success';
				} 
				else{
					$side1='(Cr)';
					$bg_color='warning';
				}
				$sq_le_name = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$row_ledger1[gl_id]'")); ?>
				<tr class="ledger_history<?= $count; ?> <?= $bg_color ?>">
					<td></td>
					<td><?= $sq_le_name['ledger_name'] ?></td>	
					<td class="text-right"><?= $row_ledger1['payment_amount'] ?></td>
					<td class="text-left"><?= $side1 ?></td>												
					<td><?= '' ?></td>
					<td><?= '' ?></td>
				</tr>
		<?php } ?>					
			<tr>
				<td></td>
				<td><i><?= $payment_perticular ?></i></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>
</div>
</div>
</div>
</div>
<script>
	$('#display_history_modal').modal('show');
</script>
