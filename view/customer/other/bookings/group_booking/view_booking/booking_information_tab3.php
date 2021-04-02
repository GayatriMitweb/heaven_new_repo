<!--*********Section-9 start***************-->
<div class="panel panel-default panel-body pad_8 mg_bt_10 customer_pan">
	<div class="customer_badge">Tour Fee Distribution</div>
	<div class="row"> <div class="col-md-12"> <div class="table-responsive">
		<table class="table table-bordered table-hover mg_bt_10 text-center">
			<tr class="active">
				<td><label>Adult Expense</label></td>
				<td><label>Children Expense</label></td>
				<td><label>Infant Expense</label></td>
				<td><label>Tour Fee</label></td>
			</tr>
			<tr>
				<td><?php echo $sq_tourwise_det['adult_expense']; ?></td>
				<td><?php echo $sq_tourwise_det['children_expense']; ?></td>
				<td><?php echo $sq_tourwise_det['infant_expense']; ?></td>
				<td><?php echo $sq_tourwise_det['tour_fee']; ?></td>
			</tr>
		</table>
	</div> </div> </div>
</div>

<!--*********Section-10 start***************-->
<div class="panel panel-default panel-body pad_8 mg_bt_10 customer_pan">
	<div class="customer_badge">Visa Information</div>
	<div class="row"> <div class="col-md-12"> <div class="table-responsive">
		<table class="table table-bordered table-hover mg_bt_10 text-center">
			<tr class="active">
				<td><label>Country Name</label></td>
				<td><label>Amount</label></td>
				<td><label>Service Tax</label></td>
				<td><label>Total Amount</label></td>
			</tr>
			<tr>
				<td><?php echo $sq_tourwise_det['visa_country_name']; ?></td>
				<td><?php echo $sq_tourwise_det['visa_amount']; ?></td>
				<td><?php echo $sq_tourwise_det['visa_service_tax']; ?></td>
				<td><?php echo $sq_tourwise_det['visa_total_amount']; ?></td>
			</tr>
		</table>
	</div> </div> </div>
</div>

<!--*********Section-10 start***************-->
<div class="panel panel-default panel-body pad_8 mg_bt_10 customer_pan">
	<div class="customer_badge">Tour Discount</div>
	<div class="row"> <div class="col-md-12"> <div class="table-responsive">
		<table class="table table-bordered table-hover mg_bt_10 text-center">
			<tr class="active">
				<td><label>Repeater Discount</label></td>
				<td><label>Other/ Adjustment Discount</label></td>
				<td><label>Total Discount</label></td>
				<td><label>Tour Fee</label></td>
			</tr>
			<tr>
				<td><?php echo $sq_tourwise_det['repeater_discount']; ?></td>
				<td><?php echo $sq_tourwise_det['adjustment_discount']; ?></td>
				<td><?php echo number_format(($sq_tourwise_det['repeater_discount']+$sq_tourwise_det['adjustment_discount']),2); ?></td>
				<td><?php echo number_format(($sq_tourwise_det['tour_fee']-($sq_tourwise_det['repeater_discount']+$sq_tourwise_det['adjustment_discount'])),2); ?></td>
			</tr>
		</table>
	</div> </div> </div>
</div>

<!--*********Section-11 start***************-->
<div class="panel panel-default panel-body pad_8 mg_bt_10 customer_pan">
	<div class="customer_badge">Tour costing</div>
	<div class="row"> <div class="col-md-12"> <div class="table-responsive">
		<table class="table table-bordered table-hover mg_bt_10 text-center">
			<tr class="active">
				<td><label>Tour Fee</label></td>
				<td><label>Service Tax</label></td>
				<td><label>Total</label></td>
			</tr>
			<tr>
				<td><?php echo number_format(($sq_tourwise_det['tour_fee']-($sq_tourwise_det['repeater_discount']+$sq_tourwise_det['adjustment_discount'])),2); ?></td>
				<td><?php echo $sq_tourwise_det['service_tax']; ?></td>
				<td><?php echo $sq_tourwise_det['tour_fee']-($sq_tourwise_det['repeater_discount']+$sq_tourwise_det['adjustment_discount']) + $sq_tourwise_det['service_tax'] ?></td>
			</tr>
		</table>
	</div> </div> </div>
</div>

<!--*********Section-11 start***************-->
<div class="panel panel-default panel-body pad_8 mg_bt_10 customer_pan">
	<div class="customer_badge">Total Tour costing</div>
	<div class="row"> <div class="col-md-12"> <div class="table-responsive">
		<table class="table table-bordered table-hover mg_bt_10 text-center">
			<tr class="active">
				<td><label>Total Fee</label></td>
				<td><label>Total Visa Amount</label></td>
				<td><label>Total</label></td>
			</tr>
			<tr>
				<td><?php echo $sq_tourwise_det['tour_fee']-($sq_tourwise_det['repeater_discount']+$sq_tourwise_det['adjustment_discount']) + $sq_tourwise_det['service_tax'] ?></td>
				<td><?php echo $sq_tourwise_det['visa_total_amount']; ?></td>
				<td><?php echo $sq_tourwise_det['total_tour_fee']; ?></td>
			</tr>
		</table>
	</div> </div> </div>
</div>

