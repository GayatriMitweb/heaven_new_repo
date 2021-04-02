<?php 
include "../../../../../../model/model.php";
$tour_id = $_POST['tour_id'];
$tour_group_id = $_POST['tour_group_id'];

$total_sale = 0; $total_purchase = 0;
$array_s = array();
$temp_arr = array();
//Sale
$q1 = mysql_query("select *  from tourwise_traveler_details where tour_id='$tour_id' and tour_group_id ='$tour_group_id' ");
while($tourwise_details = mysql_fetch_assoc($q1)){
	$sq_sum = mysql_fetch_assoc(mysql_query("select sum(basic_amount) as incentive_amount from booker_incentive_group_tour where tourwise_traveler_id='$tourwise_details[id]'"));
	$incentive_amount = $sq_sum['incentive_amount'];
	//Cancel consideration
	$sq_tr_refund = mysql_num_rows(mysql_query("select * from refund_traveler_estimate where tourwise_traveler_id='$tourwise_details[id]'"));
	$sq_tour_refund = mysql_num_rows(mysql_query("select * from refund_tour_estimate where tourwise_traveler_id='$tourwise_details[id]'"));
	$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(credit_charges) as sumc from package_payment_master where booking_id='$tourwise_details[booking_id]' and clearance_status!='Cancelled'"));
	$credit_charges = $sq_paid_amount['sumc'];
	if($sq_tour_refund == '0' || $sq_tr_refund == '0'){
		$actual_travel_expense = $tourwise_details['total_travel_expense'];
		$actual_tour_expense = $tourwise_details['total_tour_fee'];
		$sale_amount = $tourwise_details['net_total'] - $incentive_amount;
		$tax_amount = $tourwise_details['train_service_tax_subtotal'] + $tourwise_details['plane_service_tax_subtotal'] + $tourwise_details['cruise_service_tax_subtotal'] + $tourwise_details['visa_service_tax_subtotal'] + $tourwise_details['insuarance_service_tax_subtotal'] + $tourwise_details['service_tax'];
		$sale_amount -= $tax_amount;
		$total_sale += $sale_amount;
		$total_sale += $credit_charges;
	}
}

// Purchase
$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Group Tour' and estimate_type_id ='$tour_group_id' and status!='Cancel'");
while($row_purchase = mysql_fetch_assoc($sq_purchase)){
	$total_purchase += $row_purchase['net_total'] ;
	$total_purchase -= $row_purchase['service_tax_subtotal'];
}

//Other Expense
$sq_other_purchase = mysql_fetch_assoc(mysql_query("select sum(amount) as amount_total from group_tour_estimate_expense where tour_id='$tour_id' and tour_group_id ='$tour_group_id'"));
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
		<?php
	        $percent = ($closed_count/$enquirty_count)*100;
	        $percent = round($percent, 2);
	    ?>
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
			    </div></div>
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
	    <div class="widget_parent-bg-img bg-img-purp mg_bt_10_sm_xs">
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