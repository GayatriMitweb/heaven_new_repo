<?php 
include "../../../model/model.php";
$income_type_id = $_POST['income_type_id'];
$sq_income = mysql_fetch_assoc(mysql_query("select * from other_income_master where income_id='$income_type_id'"));
$sq_income1 = mysql_fetch_assoc(mysql_query("select * from other_income_payment_master where income_type_id='$income_type_id'"));
$sq_income_type_info = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$sq_income[income_type_id]'"));
?>
<div class="modal fade" id="display_income_modal" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="myModalLabel">Other Income</h4>
	</div>
	<div class="modal-body"> 
		<div class="row"> 
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="profile_box main_block" style="min-height: 141px;">
				<span class="main_block">
					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
					<?php echo "<label>Income Type <em>:</em></label> ".$sq_income_type_info['ledger_name']; ?>
				</span>
				<span class="main_block">
					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
					<?php echo "<label>Receipt From <em>:</em></label> ".$sq_income['receipt_from']; ?>
				</span>
				<span class="main_block">
					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
					<?php echo "<label>PAN/TAN No. <em>:</em></label> ".$sq_income['pan_no']; ?>
				</span>
				<span class="main_block">
					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
					<?php echo "<label>Basic Amount <em>:</em></label> ".$sq_income['amount']; ?>
				</span>
				<span class="main_block">
					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
					<?php echo "<label>".get_tax_name()." Amount <em>:</em></label> ".$sq_income['service_tax_subtotal']; ?>
				</span>
			</div>
			</div>
			<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="profile_box main_block" style="min-height: 141px;">
				<span class="main_block">
					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
					<?php echo "<label>TDS <em>:</em></label> ".$sq_income['tds']; ?> 
				</span>
				<span class="main_block">
					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
					<?php echo "<label>Net Total <em>:</em></label> ".$sq_income['total_fee']; ?> 
				</span>
				<span class="main_block">
					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
					<?php echo "<label>Receipt Date <em>:</em></label> ".get_date_user($sq_income['receipt_date']); ?> 
				</span>
				<span class="main_block">
					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
					<?php echo "<label>Receipt Amount <em>:</em></label> ".$sq_income1['payment_amount']; ?> 
				</span>
				<span class="main_block">
					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
					<?php echo "<label>Receipt Mode <em>:</em></label> ".$sq_income1['payment_mode']; ?> 
				</span>
			</div>
			</div>
		</div>
	</div>
  </div>
</div></div>

<script>
$('#display_income_modal').modal('show');
</script>