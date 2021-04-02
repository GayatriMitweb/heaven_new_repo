<div class="row mg_bt_20">
	<div class="col-md-4 col-sm-12 col-xs-12 mg_bt_20_xs">
		<div class="profile_box main_block" style="min-height: 141px;">
	        <h3>Train Amount</h3>
			<span class="main_block">
				<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
				<?php echo "<label>Total Amount <em>:</em></label> ".$sq_package_info['total_train_expense']; ?> 
			</span>
		</div>	
	</div>	
	<div class="col-md-4 col-sm-12 col-xs-12 mg_bt_20_xs">
		<div class="profile_box main_block" style="min-height: 141px;">
	        <h3>Flight Amount</h3>
			<span class="main_block">
				<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
				<?php echo "<label>Total Amount <em>:</em></label> ".$sq_package_info['total_plane_expense']; ?> 
			</span>
		</div>	
	</div>
	<div class="col-md-4 col-sm-12 col-xs-12 mg_bt_20_xs">
		<div class="profile_box main_block" style="min-height: 141px;">
	        <h3>Cruise Amount</h3>
				<span class="main_block">
					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
					<?php echo "<label>Total Amount <em>:</em></label> ".$sq_package_info['total_cruise_expense']; ?> 
				</span>
		</div>	
	</div>
</div>

<div class="row mg_bt_20">
	<div class="col-md-4 col-sm-12 col-xs-12 mg_bt_20_xs">
		<div class="profile_box main_block" style="min-height: 141px;">
	        <h3>Tour Amount</h3>
			<span class="main_block">
				<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
				<?php echo "<label>Total Amount <em>:</em></label> ".$sq_package_info['total_hotel_expense']; ?> 
			</span>
		</div>	
	</div>	
	<div class="col-md-4 col-sm-12 col-xs-12 mg_bt_20_xs">
		<div class="profile_box main_block" style="min-height: 141px;">
	        <h3>Travel Amount</h3>
			<span class="main_block">
				<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
				<?php echo "<label>Total Amount <em>:</em></label> ".$sq_package_info['total_travel_expense']; ?> 
			</span>
		</div>	
	</div>
</div>

<div class="row">
	<div class="col-md-6 col-sm-12 col-xs-12 mg_bt_20_xs">
		<div class="profile_box main_block" style="min-height: 141px;">
			<h3>Costing details</h3>
			<div class="row">
				<div class="col-sm-6 col-xs-12 right_border_none_sm_xs" style="border-right: 1px solid #ddd">
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Basic Amount <em>:</em></label> ".$sq_package_info['basic_amount']; ?>
					</span>
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Service Charge  <em>:</em></label> ".$sq_package_info['service_charge']; ?>
					</span>
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Subtotal  <em>:</em></label> ".($sq_package_info['basic_amount']+$sq_package_info['service_charge']); ?>
					</span>
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>".$tax_name." <em>:</em></label> ".$sq_package_info['tour_service_tax_subtotal']; ?>
					</span>
				</div>
				<div class="col-sm-6 col-xs-12 right_border_none_sm_xs">
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Roundoff<em>:</em></label> ".$sq_package_info['roundoff']; ?>
					</span>
					<?php
					$query = mysql_fetch_assoc(mysql_query("SELECT sum(amount) as sum,sum(`credit_charges`) as sumc from package_payment_master where booking_id='$booking_id' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
					$paid_amount = $query['sum'];
					$credit_card_amount = $query['sumc'];
					?>
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Credit Card Charges<em>:</em></label> ".$credit_card_amount; ?>
					</span>
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Total Amount <em>:</em></label>" .number_format($sq_package_info['net_total']+$credit_card_amount,2) ?> 
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
