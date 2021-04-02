<div class="row">
	<div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12 mg_bt_10_xs">
	    <div class="profile_stat_wrap-bg-img bg-green">
	    	<div class="profile_stat_wrap info main_block">
				<div class="stat_content main_block">
					<span class="content_span main_block">
					  	<span class="pull-left">&nbsp;&nbsp;&nbsp;Total Sale </span>
						<span class="pull-right"> <?php echo number_format($sale_total_amount,2); ?></span>
					</span>
					<span class="content_span main_block">
						<span class="pull-left">&nbsp;&nbsp;&nbsp;Paid Amount</span>
						<span class="pull-right"><?php echo number_format($paid_amount,2); ?></span>
					</span>
					<span class="content_span main_block">
					 	<span class="pull-left">&nbsp;&nbsp;&nbsp;Cancellation Amount </span>
					 	<span class="pull-right"><?php echo $cancel_amount;?></span>
					</span>
					<span class="content_span main_block">
					 	<span class="pull-left">&nbsp;&nbsp;&nbsp;Balance Amount </span>
					 	<span class="pull-right"><?php echo number_format($balance_amount,2) ;?></span>
					</span>
				</div>
	    	</div>
		</div>
	</div>
</div>