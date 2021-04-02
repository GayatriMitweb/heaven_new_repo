	<div class="row">
		<div class="col-md-4 col-sm-12 col-xs-12 mg_bt_20_xs">
				<div class="profile_box main_block">
		        	 <h3>Customer Details</h3>
		        	 <div class="col-xs-12 right_border_none_sm" style="border-right: 1px solid #ddd">
		        	 	<?php
		        			$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_passport_info[customer_id]'"));

							$contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
							$email_id = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key); 
						?>
        				<span class="main_block"> 
        				    <i class="fa fa-user-o" aria-hidden="true"></i>
        				    <?php echo $sq_customer['first_name'].' '.$sq_customer['middle_name'].' '.$sq_customer['last_name'].'&nbsp'.'('.get_passport_booking_id($passport_id,$year).')'; ?>
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
        				    <?php echo $contact_no; ?> 
        				</span>
        				<span class="main_block">
        				    <i class="fa fa-envelope-o" aria-hidden="true"></i>
        				    <?php echo $email_id; ?>
        				</span>
		        	 </div>
	        	
		        </div> 
		</div>
		<div class="col-md-8 col-sm-12 col-xs-12">
			    <div class="profile_box main_block" style="min-height: 141px;">
		        	<h3>Costing Details</h3>
		            <div class="row">
		             <div class="col-sm-6 col-xs-12 right_border_none_sm_xs" style="border-right: 1px solid #ddd">
		                <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Basic Amount <em>:</em></label> ".$sq_passport_info['passport_issue_amount']; ?>
		                </span>
			        	<span class="main_block">
			        	  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
			        	  <?php echo "<label>Service charge <em>:</em></label> ".$sq_passport_info['service_charge']; ?>
			        	</span>
					    <span class="main_block">
					      <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
					      <?php echo "<label>".$tax_name." <em>:</em></label> ".$sq_passport_info['service_tax_subtotal']; ?> 
					    </span>
		        	    <span class="main_block">
		        	      <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		        	      <?php echo "<label>RoundOff <em>:</em></label> ".$sq_passport_info['roundoff']; ?>
		        	    </span>
					 </div>
					 <div class="col-sm-6 col-xs-12">
		        	    <span class="main_block">
		        	      <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		        	      <div class="highlighted_cost"><?php echo "<label>Net Total  <em>:</em></label> ".$sq_passport_info['passport_total_cost'] ?></div> 
		        	    </span>
		        		<span class="main_block">
		        		  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		        		  <?php
							$sq_credit = mysql_fetch_assoc(mysql_query("SELECT sum(`credit_charges`) as sumc FROM `passport_payment_master` WHERE `passport_id`='$sq_passport_info[passport_id]' and `clearance_status`!='Cancelled' and clearance_status != 'Pending'"));
							$charge = ($sq_credit['sumc'] != '')?$sq_credit['sumc']:0;
							echo "<label>Credit card charges <em>:</em></label> ".number_format($charge,2)?> 
		        		</span>
		        		<span class="main_block">
		        		  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		        		  <?php echo "<label>Due Date <em>:</em></label> ".get_date_user($sq_passport_info['due_date']) ;?> 
		        		</span>
		        		<span class="main_block">
		        		  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		        		  <?php echo "<label>Booking Date <em>:</em></label> ".get_date_user($sq_passport_info['created_at']) ;?> 
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
			        				<th>Date_of_birth</th>
			        				<th>Adolescence</th>
			        				<th>Received_documents</th>
									<th>Appointment_Date</th>
		        				</tr>
	        					</thead>
	                       <tbody>
	                       <?php 
	                       $offset = "_u";
	                       $sq_entry_count = mysql_num_rows(mysql_query("select * from passport_master_entries where passport_id='$passport_id'"));
	                       if($sq_entry_count==0){
	                       		include_once('passport_member_tbl.php');	
	                       }
	                       else{
	                       		$count = 0;
	                       		$sq_entry = mysql_query("select * from passport_master_entries where passport_id='$passport_id'");
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
									    	<?php echo $row_entry['received_documents'];  ?>
									    </td>
										<td><?= get_date_user($row_entry['appointment_date']) ?></td>
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
               