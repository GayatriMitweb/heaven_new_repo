<div class="row">
	<div class="col-md-4 col-sm-12 col-xs-12 mg_bt_10_xs">
		<div class="profile_box main_block" style="min-height: 192px;">
        	 	<h3>Customer Details</h3>
        		<div class="col-xs-12 right_border_none_sm" style="border-right: 1px solid #ddd">
					<?php 
					$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'")); 

					$contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
					$email_id = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key);
					?>
        		<span>
        			<i class="fa fa-id-card-o" aria-hidden="true"></i>
        			<?php echo get_forex_booking_id($booking_id,$year); ?>
        		</span>
				<span class="main_block"> 
				    <i class="fa fa-user-o" aria-hidden="true"></i>
				    <?php echo $sq_customer['first_name'].' '.$sq_customer['middle_name'].' '.$sq_customer['last_name']; ?>
				</span>
				<?php  
		        	  if($sq_customer['type'] == 'Corporate'){
		        	?>
        	 		<span class="main_block">
		                  <i class="fa fa-building-o" aria-hidden="true"></i>
		                  <?php echo $sq_customer['company_name'] ?>
		            </span>
		            <?php  } ?>
				<span class="main_block">
				    <i class="fa fa-envelope-o" aria-hidden="true"></i>
				    <?php echo $email_id; ?>
				</span>	
				<span class="main_block">
				    <i class="fa fa-phone" aria-hidden="true"></i>
				    <?php echo $contact_no; ?> 
				</span>
        		</div>
				
	        	
	    </div> 
	</div>
	<div class="col-md-8 col-sm-12 col-xs-12">
		 <div class="profile_box main_block">
	        <h3>Costing Details</h3>
	        <?php $sq_booking = mysql_fetch_assoc(mysql_query("select * from forex_booking_master where booking_id='$booking_id'")); ?>
	        <div class="row">
	            <div class="col-sm-6 col-xs-12 right_border_none_sm_xs" style="border-right: 1px solid #ddd">
	                <span class="main_block">
	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	                  <?php echo "<label>Sale/Buy <em>:</em></label> ".$sq_booking['booking_type']; ?>
	                </span>
		        	<span class="main_block">
		        	  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		        	  <?php echo "<label>Currency <em>:</em></label> ".$sq_booking['currency_code']; ?>
		        	</span>
				    <span class="main_block">
				      <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
				      <?php echo "<label>Rate <em>:</em></label> ".$sq_booking['rate'] ?> 
				    </span>
	        	    <span class="main_block">
	        	      <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	        	      <?php echo "<label>Forex Amount <em>:</em></label> ".$sq_booking['forex_amount']; ?> 
	        	    </span>
	        		<span class="main_block">
	        		  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	        		  <?php echo "<label>Total<em>:</em></label> ".$sq_booking['basic_cost'];?> 
	        		</span>
	        		<span class="main_block">
	        		  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	        		  <?php echo "<label>Service Charge <em>:</em></label> ".$sq_booking['service_charge'];?> 
	        		</span>
				 </div>
				 <div class="col-sm-6 col-xs-12">
	        		<span class="main_block">
	        		  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	        		  <?php echo "<label>".$tax_name."  <em>:</em></label> ".$sq_booking['service_tax_subtotal'];?> 
	        		</span>
					<span class="main_block">
	        		  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	        		  <?php echo "<label>Round Off <em>:</em></label> ".$sq_booking['roundoff'];?> 
	        		</span>
	        		<span class="main_block">
	        		  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	        		  <div class="highlighted_cost"><?php echo "<label>Net Total <em>:</em></label> ".$sq_booking['net_total'];?></div>
	        		</span>
					<?php
					$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(`credit_charges`) as sumc from forex_booking_payment_master where booking_id='$sq_booking[booking_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
					$credit_card_charges = $sq_paid_amount['sumc'];
					?>
					<span class="main_block">
	        		  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	        		  <?php echo "<label>Credit card charges <em>:</em></label> ".$credit_card_charges;?> 
	        		</span>
	        		<span class="main_block">
	        		  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	        		  <?php echo "<label>Booking Date <em>:</em></label> ".get_date_user($sq_booking['created_at']) ;?>
	        		</span>
	        	 </div>
	        	</div>
			</div>
    </div>
</div>
<div class="row">    
  	<div class="col-xs-12">
  		<div class="profile_box main_block" style="margin-top: 25px">
           	<h3>Document Details</h3>
            <span class="main_block">
	            <ul style="padding: 0px; margin: 0px; font-weight: 500;">
	              <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		          Mandatory Documents
		          <ol style="font-weight: 300;padding: 0px;margin-left: 15px">
		            <i class="fa fa-circle-o" aria-hidden="true" style="font-size: 8px; width: 10px;"></i>
		        	<?= ($sq_booking['manadatory_docs']=="" ? 'NA' :$sq_booking['manadatory_docs']) ; ?>
		          </ol>
	            </ul>  
	        </span> 
	        <span class="main_block">
	            <ul style="padding: 0px; margin: 0px; font-weight: 500;">
	              <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		          Photo Proof Given
		          <ol style="font-weight: 300;padding: 0px;margin-left: 15px">
		            <i class="fa fa-circle-o" aria-hidden="true" style="font-size: 8px; width: 10px;"></i>
		        	<?php echo ($sq_booking['photo_proof_given']=="" ? 'NA' :$sq_booking['photo_proof_given']) ;?>
		          </ol>
	            </ul>  
	        </span>
	        <span class="main_block">
	            <ul style="padding: 0px; margin: 0px; font-weight: 500;">
	              <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		          Residence Proof
		          <ol style="font-weight: 300;padding: 0px;margin-left: 15px">
		            <i class="fa fa-circle-o" aria-hidden="true" style="font-size: 8px; width: 10px;"></i>
		        	<?php echo ($sq_booking['residence_proof']=="" ? 'NA' :$sq_booking['residence_proof'])?>
		          </ol>
	            </ul>  
	        </span> 
        </div>
                
    </div>  
</div>
