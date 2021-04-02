<div class="row">
	<div class="col-md-4 col-sm-12 col-xs-12">
		<div class="profile_box main_block">
        	 	<h3>Customer Details</h3>
				<?php $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_exc_info[customer_id]'")); 
				
				$contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
				$email_id = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key); 
				?>
				<span class="main_block"> 
				    <i class="fa fa-user-o" aria-hidden="true"></i>
				    <?php echo $sq_customer['first_name'].' '.$sq_customer['middle_name'].' '.$sq_customer['last_name'].'&nbsp'.'('.get_exc_booking_id($exc_id,$year).')'; ?>
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
	<div class="col-md-8 col-sm-12 col-xs-12">
		 <div class="profile_box main_block" style="min-height: 141px;">
	        <h3>Costing Details</h3>
	        <div class="row">
	            <div class="col-md-6 col-sm-6 col-xs-12 right_border_none_sm_xs" style="border-right: 1px solid #ddd">
	                <span class="main_block">
	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	                  <?php echo "<label>Basic Amount <em>:</em></label> ".$sq_exc_info['exc_issue_amount']; ?>
	                </span>
		        	<span class="main_block">
		        	  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		        	  <?php echo "<label>Service charge <em>:</em></label> ".$sq_exc_info['service_charge']; ?>
		        	</span>
					<span class="main_block">
	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	                  <?php echo "<label>".$tax_name." <em>:</em></label>". $sq_exc_info['service_tax_subtotal']; ?>
	                </span>
		        	<span class="main_block">
		        	  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		        	  <?php echo "<label>Markup <em>:</em></label> ".$sq_exc_info['markup']; ?>
		        	</span>
					<span class="main_block">
		        	  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		        	  <?php echo "<label>Markup Tax<em>:</em></label> ".$sq_exc_info['service_tax_markup']; ?>
		        	</span>
					<span class="main_block">
		        	  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		        	  <?php echo "<label>Roundoff<em>:</em></label> ".$sq_exc_info['roundoff']; ?>
		        	</span>

				 </div>
				 <div class="col-md-6 col-sm-6 col-xs-12">
	        	    <span class="main_block">
	        	      <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	        	      <div class='highlighted_cost'> <?php echo "<label>Net Total  <em>:</em></label> ".$sq_exc_info['exc_total_cost']; ?></div>
	        	    </span>
					<span class="main_block">
		        		  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		        		  <?php
							$sq_credit = mysql_fetch_assoc(mysql_query("SELECT sum(`credit_charges`) as sumc FROM `exc_payment_master` WHERE `exc_id`='$sq_exc_info[exc_id]' and `clearance_status`!='Cancelled' and clearance_status != 'Pending'"));
							$charge = ($sq_credit['sumc'] != '')?$sq_credit['sumc']:0;
							echo "<label>Credit card charges <em>:</em></label> ".number_format($charge,2)?> 
		        		</span>
	        		<span class="main_block">
	        		  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	        		  <?php echo "<label>Due Date <em>:</em></label> ".get_date_user($sq_exc_info['due_date']);?> 
	        		</span>
	        		<span class="main_block">
	        		  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	        		  <?php echo "<label>Booking Date <em>:</em></label> ".get_date_user($sq_exc_info['created_at']);?> 
	        		</span>
	        	 </div>
	        	</div>
			</div>
    </div>
</div>
<div class="row">    
  	<div class="col-xs-12">
  		<div class="profile_box main_block" style="margin-top: 25px">
           	<h3 class="editor_title">Excursion Details</h3>
                <div class="table-responsive">
                    <table id="tbl_dynamic_exc_update" name="tbl_dynamic_exc_update" class="table table-bordered no-marg">
                     <thead>
                       <tr class="table-heading-row">
                       	<th>S_No.</th>
                       	<th>Datetime&nbsp;&nbsp;</th>
                       	<th>City_name</th>
                       	<th>Activity_name</th>
                       	<th>Transfer_Option</th>
                       	<th>Total_adult</th>
                       	<th>total_child</th>
                       	<th>adult_cost</th>
                       	<th>child_cost</th>
                       	<th>total_cost</th>
                       </tr>
                       </thead>
                       <tbody>
                       <?php 
                       $bg="";
                       $sq_entry_count = mysql_num_rows(mysql_query("select * from excursion_master_entries where exc_id='$exc_id'"));
                       if($sq_entry_count==0){
                       		include_once('exc_member_tbl.php');	
                       }
                       else{
                       		$count = 0;
                       		$sq_entry = mysql_query("select * from excursion_master_entries where exc_id='$exc_id'"); 
                       		while($row_entry = mysql_fetch_assoc($sq_entry)){
                       			if($row_entry['status']=="Cancel"){
                       				$bg="danger";
                       			}
                       			else{
                       				$bg="#fff";
                       			}
                       			$sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row_entry[city_id]'"));
                       			$sq_exc = mysql_fetch_assoc(mysql_query("select * from excursion_master_tariff where entry_id='$row_entry[exc_name]'"));
                       			$count++;
                       			?>
								 <tr class="<?php echo $bg; ?>">
								    <td><?php echo $count; ?></td>
								    <td><?php echo get_datetime_user($row_entry['exc_date']); ?></td>
								    <td><?php echo $sq_city['city_name']; ?></td>
									<td><?php echo $sq_exc['excursion_name']; ?></td>
									<td><?php echo $row_entry['transfer_option']; ?></td>
								    <td><?php echo $row_entry['total_adult']; ?></td>
								    <td><?php echo $row_entry['total_child']; ?></td>
								    <td><?php echo $row_entry['adult_cost']; ?> </td>
								    <td><?php echo $row_entry['child_cost']; ?> </td>
								    <td><?php echo $row_entry['total_cost']; ?> </td>
								</tr>        
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
           