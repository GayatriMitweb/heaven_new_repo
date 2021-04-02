<?php 
include "../../../../model/model.php";
$entry_id = $_POST['entry_id'];
?>
<form id="frm_save1">
<div class="modal fade" id="journal_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Journal Entry</h4>
      </div>
      <div class="modal-body"> 
		<div class="row"> <div class="col-md-12 mg_tp_20"><div class="table-responsive">
			<table class="table table-hover table-bordered" id="tbl_list_journal_sub" style="margin: 20px 0 !important;  padding: 0px !important;">
				<thead>
					<tr class="table-heading-row">
						<th>SR.NO</th>
						<th>Particulars</th>				
						<th>Debit</th>
						<th>Credit</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$sq_q = "select * from journal_entry_accounts where entry_id='$entry_id' and amount != '0' ";
					$sq_journal_info = mysql_query($sq_q);
					$count = 1;
					while($row_journal = mysql_fetch_assoc($sq_journal_info)){
						$sq_le_name = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$row_journal[ledger_id]'"));
						$debit_amount = ($row_journal['type'] == 'Debit') ? $row_journal['amount'] : '' ;
						$credit_amount = ($row_journal['type'] == 'Credit') ? $row_journal['amount'] : '' ;
					?>
						<tr>
							<td><?= $count ?></td>
							<td><?= $sq_le_name['ledger_name'] ?></td>
							<td><?= $debit_amount ?></td>
							<td><?= $credit_amount ?></td>
						</tr>
					<?php  
						$count++;

						if($row_journal['type'] == 'Debit'){
							$total_debit += $row_journal['amount'];
						} 
						else{
							$total_credit += $row_journal['amount'];
						}
					} //while close ?>
				</tbody>
				<tfoot>		
					<tr class="table-heading-row">
						<td></td>
						<td class="text-right"><b>Current Total : </b></td>
						<td><b><?= number_format($total_debit,2) ?></b></td>
						<td><b><?= number_format($total_credit,2) ?></b></td>
					</tr>
				</tfoot>
			</table>
			</div></div></div>
	</div>
  </div>
</div></div></form>

<script>
$('#journal_modal').modal('show');

$('#tbl_list_journal_sub').dataTable({
		"pagingType": "full_numbers"
});

</script>