<?php 
include "../../../../../../model/model.php";
$booking_id = $_POST['booking_id'];
$branch_status = $_POST['branch_status'];

$total_sale = 0; $total_purchase = 0;
//Sale
$tourwise_details = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$booking_id'"));
$sq_sum = mysql_fetch_assoc(mysql_query("select sum(basic_amount) as incentive_amount from booker_incentive_package_tour where booking_id='$tourwise_details[booking_id]'"));
$incentive_amount = $sq_sum['incentive_amount'];
//Cancel consideration
$sq_tr_refund = mysql_num_rows(mysql_query("select * from package_refund_traveler_cancalation_entries where tourwise_traveler_id='$tourwise_details[booking_id]'"));
$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(credit_charges) as sumc from package_payment_master where booking_id='$tourwise_details[booking_id]' and clearance_status!='Cancelled'"));
$credit_charges = $sq_paid_amount['sumc'];
$tax_amount1 = 0;
if($sq_tr_refund == ''){
	$actual_travel_expense = $tourwise_details['total_travel_expense'];
	$actual_tour_expense = $tourwise_details['actual_tour_expense'];
	$total_sale = $tourwise_details['net_total'] - $incentive_amount;
	$tax_amount = $tourwise_details['tour_service_tax_subtotal'];
	$tax_amount = explode(":",$tax_amount);
	$tax_amount1 = $tax_amount1 + $tax_amount[2];

	$total_sale -= $tax_amount1;
}
$total_sale += $credit_charges;

// Purchase
$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Package Tour' and estimate_type_id ='$booking_id' and status!='Cancel'");
while($row_purchase = mysql_fetch_assoc($sq_purchase)){
	$total_purchase += $row_purchase['net_total'];
	$total_purchase -= $row_purchase['service_tax_subtotal'];
}

//Other Expense
$sq_other_purchase = mysql_fetch_assoc(mysql_query("select sum(amount) as amount_total from package_tour_estimate_expense where booking_id='$booking_id' "));
$total_purchase += $sq_other_purchase['amount_total'];

//Revenue & Expenses
$result = $total_sale - $total_purchase;

if($total_sale > $total_purchase){
	$var = 'Total Profit';
}else{
	$var = 'Total Loss';
}
$profit_loss = $total_sale - $total_purchase;
?>

<div class="main_block mg_bt_30">
	<div class="col-sm-4 mg_bt_10 no-pad-sm">
		<div class="widget_parent-bg-img bg-green mg_bt_10_sm_xs">
			<div class="widget_parent">
				<div class="row">
			         <div class="widget col-sm-12">
			            <div class="title success-col">
			               <span class="succes_name">Total Sale</span> : <span class="succes_count"><?= number_format($total_sale,2) ?></span>
			            </div>
			        </div>    
			    </div>
			    <div class="row"> <div class="col-md-12">
			        <div class="progress mg_bt_0">
			          <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?= 100 ?>%"></div>
			        </div>
			    </div> </div>
			</div>
		</div>		
	</div>
	<div class="col-sm-4 mg_bt_10 no-pad-sm">
	    <div class="widget_parent-bg-img bg-red mg_bt_10_sm_xs">
	    	<div class="widget_parent">
				<div class="row">
			         <div class="widget col-sm-12">
			            <div class="title success-col">
			            	<span class="succes_name">Total Purchase</span> : <span class="succes_count"><?= number_format($total_purchase,2) ?></span>
			            </div>
			        </div>    
			    </div>
			    <div class="row"> <div class="col-md-12">
			        <div class="progress mg_bt_0">
			          <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?= 100 ?>%"></div>
			        </div>
			    </div> </div>
			</div>
	    </div>
	</div>
	<div class="col-sm-4 mg_bt_10 no-pad-sm">
		<?php
		    $profit_loss_per = 0;
			$profit_amount = $total_sale - $total_purchase;
			$profit_loss_per = ($profit_amount / $total_sale) * 100;
	        $profit_loss_per = round($profit_loss_per, 2);
	    ?>
	    <div class="widget_parent-bg-img bg-purple mg_bt_10_sm_xs">
	    	<div class="widget_parent">
				<div class="row">
			         <div class="widget col-sm-12">
			            <div class="title success-col">
			            	<span class="succes_name"><?= $var ?></span> : <span class="succes_count"><?= number_format($profit_loss,2) ?></span>
			            </div>
			        </div>    
			    </div>
			    <div class="row"><div class="col-md-12">
			       <div class="widget-badge">
			            <div class="label label-warning">+ <?= $profit_loss_per ?> %</div>&nbsp;&nbsp;
			        </div> 
			    </div></div>
			    <div class="row"> <div class="col-md-12">
			        <div class="progress mg_bt_0">
			          <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?= $profit_loss_per ?>%"></div>
			        </div>
			    </div> </div>
			</div>
	    </div>
	</div>
</div>
<div class="row mg_tp_30"> <div class="col-md-12"> <div class="table-responsive">
<h3 class="editor_title">Sale/Purchase History</h3>
	<table class="table table-bordered no-marg">
		<thead>
			<tr class="active table-heading-row">
				<th>S_No.</th>
				<th>Booking_date</th>
				<th>Tour_name</th>
				<th>User_name</th>
				<th>Purchase/Expenses</th>
				<th>Other Expense</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$tourwise_details[emp_id]'"));
		$emp = ($tourwise_details['emp_id'] == 0)?'Admin': $sq_emp['first_name'].' '.$sq_emp['last_name']; ?>
			<tr>
				<td><?= 1 ?></td>
				<td><?= get_date_user($tourwise_details['booking_date']) ?></td>
				<td><?= $tourwise_details['tour_name'] ?></td>
				<td><?= $emp ?></td>
				<td><button class="btn btn-info btn-sm" onclick="view_purchase_modal('<?= $tourwise_details['booking_id'] ?>')" title="View Purchase"><i class="fa fa-eye"></i></button></td>
                <td><button class="btn btn-info btn-sm" onclick="package_other_expnse_modal('<?= $booking_id ?>')" title="Add Other Miscellaneous amount"><i class="fa fa-plus"></i></button></td>
			</tr>
		</tbody>	
	</table>
	<!-- <table class="table table-bordered no-marg">
		<thead>
			<tr class="active table-heading-row">
				<th>S_No.</th>
				<th>Purchase_For</th>
				<th>Purchase_amount</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		$count = 1;
		$sq_query = mysql_query("select * from vendor_estimate where estimate_type='Package Tour' and estimate_type_id ='$booking_id' and status!='Cancel'");
		while($row_query = mysql_fetch_assoc($sq_query)){	
			if($row_query['net_total'] != '0'){
			?>
				<tr>
					<td><?= $count++ ?></td>
					<td><?= $row_query['vendor_type'] ?></td>
					<td><?= $row_query['net_total']-$row_query['service_tax_subtotal'] ?></td>
				</tr>
			<?php } 
		} ?>
			<tr>
				<td><?= $count++ ?></td>
				<td><?= 'Other Expenses'  ?></td>
				<?php if($sq_other_purchase['amount'] == ''){ ?>
					<td><button class="btn btn-info btn-sm" onclick="package_other_expnse_modal('<?= $booking_id ?>')" title="Add Purchase Amount"><i class="fa fa-plus"></i></button></td>
				<?php } else{ ?>
					<td><?= $sq_other_purchase['expense_name'].'('.$sq_other_purchase['amount'].')' ?></td>
				<?php } ?>				
			</tr>
		</tbody>
	</table> -->

</div></div></div>

<div id="other_package_expnse_display"></div>

<script>
function view_purchase_modal(booking_id)
{
	var base_url = $('#base_url').val();
	$.post(base_url+'view/reports/business_reports/report_reflect/revenue_expenses/package_tour/view_purchase_modal.php', { booking_id : booking_id }, function(data){
		$('#other_package_expnse_display').html(data);
	});
}
function package_other_expnse_modal(booking_id,tour_group_id)
{
	var base_url = $('#base_url').val();
	$.post(base_url+'view/reports/business_reports/report_reflect/revenue_expenses/package_tour/other_expnse_modal.php', { booking_id : booking_id }, function(data){
		$('#other_package_expnse_display').html(data);
	});
}
</script>