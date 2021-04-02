	<div class="row">
		<div class="col-md-4 col-sm-12 col-xs-12 mg_bt_10_xs">
				<div class="profile_box main_block">
		        	 <h3>Customer Details</h3>
		        		<?php
							$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_booking[customer_id]'"));
							$contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
							$email_id = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key);
		        		?>
		        		<span class="main_block"> 
        				    <i class="fa fa-id-card-o" aria-hidden="true"></i>  
        				    <?php echo get_train_ticket_booking_id($train_ticket_id,$year); ?>
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
        				    <i class="fa fa-phone" aria-hidden="true"></i>
        				    <?php echo $contact_no ; ?> 
        				</span>
        				<span class="main_block">
        				    <i class="fa fa-envelope-o" aria-hidden="true"></i>
        				    <?php echo $email_id; ?>
        				</span>
	        	
		        </div> 
		</div>
		<div class="col-md-8 col-sm-12 col-xs-12">
			    <div class="profile_box main_block" style="min-height: 141px;">
		        	<h3>Costing Details</h3>
		            <div class="row">
		             <div class="col-sm-6 col-xs-12 right_border_none_sm_xs" style="border-right: 1px solid #ddd">
		                <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Basic Amount <em>:</em></label> ".$sq_booking['basic_fair']; ?>
		                </span>
			        	<span class="main_block">
			        	  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
			        	  <?php echo "<label>Service charge <em>:</em></label> ".$sq_booking['service_charge']; ?>
			        	</span>
			        	<span class="main_block">
					      <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
					      <?php echo "<label>Delivery Charge <em>:</em></label> ".$sq_booking['delivery_charges']; ?> 
					    </span>
		        	    <span class="main_block">
		        	      <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		        	      <?php echo "<label>".$tax_name." <em>:</em></label> ".$sq_booking['service_tax_subtotal']; ?>
		        	    </span>
					 </div>
					 <div class="col-sm-6 col-xs-12">
		        	    <span class="main_block">
		        	      <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		        	      <div class="highlighted_cost"><?php echo "<label>Net Total <em>:</em></label> ".$sq_booking['net_total'] ?></div>
		        	    </span>
		        		<span class="main_block">
		        		  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		        		  <?php
							$sq_credit = mysql_fetch_assoc(mysql_query("SELECT sum(`credit_charges`) as sumc FROM `train_ticket_payment_master` WHERE train_ticket_id='$sq_booking[train_ticket_id]' and `clearance_status`!='Cancelled' and clearance_status != 'Pending'"));
							$charge = ($sq_credit['sumc'] != '')?$sq_credit['sumc']:0;
							echo "<label>Credit card charges <em>:</em></label> ".number_format($charge,2)?> 
		        		</span>
		        		<span class="main_block">
		        		  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		        		  <?php echo "<label>Due Date <em>:</em></label> ".get_date_user($sq_booking['payment_due_date']);?> 
		        		</span>
		        		<span class="main_block">
		        		  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		        		  <?php echo "<label>Booking Date <em>:</em></label> ".get_date_user($sq_booking['created_at']);?> 
		        		</span>
		        	 </div>
		        	</div>
				   </div>
			       </div>
      		    <div class="col-xs-12">
      		    <div class="profile_box main_block" style="margin-top: 25px">
	           	 <h3 class="editor_title">Passenger Details</h3>
	                <div class="table-responsive">
	                    <?php $offset = ""; ?>
	                    <table id="tbl_dynamic_passport" name="tbl_dynamic_passport" class="table table-bordered no-marg">
	                    <thead>
	        					<tr class="table-heading-row">
	        						<th>S_No.</th>
			        				<th>Name</th>
			        				<th>Date_of_Birth</th>
			        				<th>Adolescence</th>
			        				<th>Coach_No</th>
			        				<th>Seat_No</th>
			        				<th>Ticket_No</th>
		        				</tr>
	        					</thead>
	                       <tbody>
	                       <?php 
	                       $offset = "_u";
	                       $sq_entry_count = mysql_num_rows(mysql_query("select * from train_master_entries where train_ticket_id='$train_ticket_id'"));
	                       if($sq_entry_count==0){
	                       		include_once('ticket_master_tbl.php');	
	                       }
	                       else{
	                       		$count = 0;
	                       		$sq_entry = mysql_query("select * from train_ticket_master_entries where train_ticket_id='$train_ticket_id'");
                                $bg="";
	                       		while($row_entry = mysql_fetch_assoc($sq_entry)){
	                       			if($row_entry['status']=="Cancel")
	                       			{
	                       				$bg="danger";
	                       			}
	                       			else
	                       			{
	                       				$bg="#fff";
	                       			}
	                       			$count++;
	                       			?>
									 <tr class="<?php echo $bg; ?>">
									    <td><?php echo $count; ?></td>
									    <td><?php echo $row_entry['first_name']." ".$row_entry['last_name']; ?></td>
									    <td><?= get_date_user($row_entry['birth_date']) ?></td>
    									<td><?php echo $row_entry['adolescence']; ?></td>
									    <td>
									    	<?php echo $row_entry['coach_number']; ?>
									    </td>
									    <td>
									    	<?php echo $row_entry['seat_number']; ?>
									    </td>
									    <td>
									    	<?php echo $row_entry['ticket_number']; ?>
									    </td>
									</tr>  
									<script>
										$("#birth_date<?= $offset.$count ?>_d, #expiry_date<?= $offset ?>1").datetimepicker({ timepicker:false, format:'d-m-Y' });
									</script>      
	                       			<?php

	                       		}

	                       }
	                       ?>
	                     </tbody>
	                    </table>
	                    </div>
	                
	        </div>  
	    </div>
	</div>  
               