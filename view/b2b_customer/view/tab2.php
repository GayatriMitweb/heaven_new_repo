<div class="row">
	<div class="col-md-6">
		<div class="profile_box main_block">
		<h3>Contact Person Details</h3>
        	<div class="row">
        	 	<div class="col-md-12 right_border_none_sm" style="min-height: 105px;">
        	   		<span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Contact Person <em>:</em></label> ".$query['cp_first_name'].' '.$query['cp_last_name']; ?>
		            </span>
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Email Id<em>:</em></label> ".$query['email_id'] ?>
		            </span>
        	 		<span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Mobile No <em>:</em></label> ".$query['mobile_no'] ?>
		            </span>
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Whatsapp No <em>:</em></label> ".$query['whatsapp_no']; ?>
		            </span>
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Designation <em>:</em></label> ".$query['designation']; ?>
		            </span> 
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>PAN Card No. <em>:</em></label>".$query['pan_card'] ?>
		            </span>
					<?php
					if($query['id_proof_url']!=''){
						$newUrl = preg_replace('/(\/+)/','/',$query['id_proof_url']);
						$newUrl = explode('uploads', $newUrl);
						$newUrl1 = BASE_URL.'uploads'.$newUrl[1];
					?>
					<span class="main_block">
					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
					<?php echo "<label>ID Proof <em>:</em></label> "?><a href="<?php echo $newUrl1; ?>" download title="Download"><i class="fa fa-id-card-o"></i></a> 
					</span>
					<?php } ?>   
		        </div>
		    </div> 
	    </div>
    </div>
	<div class="col-md-6">
		<div class="profile_box main_block">
		<h3>Account Details</h3>
        	<div class="row">
        	 	<div class="col-md-12 right_border_none_sm" style="min-height: 105px;">
        	   		<span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Bank Name <em>:</em></label> ".$query['b_bank_name']; ?>
		            </span>
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Account Name<em>:</em></label> ".$query['b_acc_name'] ?>
		            </span>
        	 		<span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Account No <em>:</em></label> ".$query['b_acc_no'] ?>
		            </span>
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Branch Name <em>:</em></label> ".$query['b_branch_name']; ?>
		            </span>
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>IFSC Code <em>:</em></label> ".$query['b_ifsc_code']; ?>
		            </span>  
		        </div>
		    </div> 
	    </div>
    </div>
</div>
<div class="row mg_tp_20">
	<div class="col-md-12">
		<div class="profile_box main_block">
		<h3>Deposit Details</h3>
        	<div class="row">
        	 	<div class="col-md-12 right_border_none_sm" style="min-height: 105px;">
        	   		<span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Deposit Amount <em>:</em></label> ".$query['deposite']; ?>
		            </span>
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Payment Date<em>:</em></label> ".get_date_user($query['payment_date']) ?>
		            </span>
        	 		<span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Payment Mode <em>:</em></label> ".$query['payment_mode'] ?>
		            </span>
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Bank Name <em>:</em></label> ".$query['bank_name']; ?>
		            </span>
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Transaction ID <em>:</em></label> ".$query['transaction_id']; ?>
		            </span> 
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php $sq_bank = mysql_fetch_assoc(mysql_query("select bank_name from bank_master where bank_id='$query[bank_id]'")); echo "<label>Creditor Bank <em>:</em></label>".$sq_bank['bank_name'] ?>
		            </span> 
		        </div>
		    </div> 
	    </div>
    </div>
</div>
