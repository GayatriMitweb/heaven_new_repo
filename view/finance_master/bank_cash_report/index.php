<?php
include "../../../model/model.php";
require_once('../../layouts/admin_header.php');
 
?>
<?= begin_panel('Finance Master') ?>
<div class="row mg_bt_20 text-right"> <div class="col-md-12"> 
<button class="btn btn-danger" onclick="empty_data()">Empty Data</button>
</div> </div>

<div class="row"> <div class="col-md-12"> <div class="table-responsive">
	
<table class="table table-bordered" id="finance_table">
	<thead>
		<tr>
			<th></th>
			<th></th>
			<th class="danger text-center" colspan="3">Debit</th>
			<th class="success text-center" colspan="3">Credit</th>
		</tr>
		<tr>
			<th>S_No.</th>
			<th>Transaction_Name</th>

			<th class="danger">GL_Code</th>
			<th class="danger">Particular</th>
			<th class="danger">Amount</th>
			
			<th class="success">GL_Code</th>
			<th class="success">Particular</th>
			<th class="success">Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_finance1 = mysql_query("select DISTINCT(module_name) as module_name from finance_transaction_master order by module_name asc");
		while($row_finance1 = mysql_fetch_assoc($sq_finance1)){

			$sq_finance2 = mysql_query("select DISTINCT(module_entry_id) as module_entry_id from finance_transaction_master where module_name='$row_finance1[module_name]'");
			while($row_finance2 = mysql_fetch_assoc($sq_finance2)){				

				$first_time = true;

				$sq_finance3 = mysql_query("select * from finance_transaction_master where module_name='$row_finance1[module_name]' and module_entry_id='$row_finance2[module_entry_id]'");
				while($row_finance3 = mysql_fetch_assoc($sq_finance3)){

					$sq_gl = mysql_fetch_assoc(mysql_query("select * from gl_master where gl_id='$row_finance3[gl_id]'"));

					if($row_finance3['clearance_status']=="Cancelled" || $row_finance3['clearance_status']=="Pending"){
						$amount = 0;
					}
					else{
						$amount = $row_finance3['payment_amount'];
					}

					if($row_finance3['payment_side']=="Credit"){
						$credit_gl = $sq_gl['gl_name'];
						$credit_par = $row_finance3['payment_particular'];
						$credit_amount = $amount;						
						$debit_gl = "";
						$debit_par = "";
						$debit_amount = "";
					}					
					else{
						$credit_gl = "";
						$credit_par = "";
						$credit_amount = "";
						$debit_gl = $sq_gl['gl_name'];
						$debit_par = $row_finance3['payment_particular'];
						$debit_amount = $amount;
					}

					?>
					<tr>
						<td><?= ++$count ?></td>
						<td><?php if($first_time){ echo $row_finance1['module_name']; }  ?></td>						
						<td class="danger"><?= $debit_gl ?></td>
						<td class="danger"><?= $debit_par ?></td>
						<td class="danger"><?= $debit_amount ?></td>
						<td class="success"><?= $credit_gl ?></td>
						<td class="success"><?= $credit_par ?></td>
						<td class="success"><?= $credit_amount ?></td>
					</tr>
					<?php
					$first_time = false;

				}

				?>
				<tr>
					<td class="active" colspan="8"></td>
				</tr>
				<?php
				

			}

		}
		?>
	</tbody>
</table>

</div> </div> </div>

<script type="text/javascript">/*
$('#finance_table').dataTable({
        "pagingType": "full_numbers"
    });*/
function empty_data()
{
	$.post('comple_finance/empty_data.php', {}, function(data){
		msg_alert(data);
		report_content_reflect();
	});
}
</script>
<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>