<div class="row">
	<div class="col-md-6 col-sm-12 col-xs-12 mg_bt_20_xs">
		<div class="profile_box main_block">
        	 	<h3>Customer Details</h3>
				<?php $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_hotel_info[customer_id]'")); 
				$contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
				$email_id = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key); 
				?>
        		<div class="row">
        		  <div class="col-sm-7 col-xs-12 right_border_none_sm_xs"  style="border-right: 1px solid #ddd">
	        		<span class="main_block"> 
					    <i class="fa fa-id-card-o" aria-hidden="true"></i>
	        		    <?php echo get_hotel_booking_id($booking_id,$year); ?>
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
				  <div class="col-sm-5 col-xs-12">
								<span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Adults <em>:</em></label> ".$sq_hotel_info['adults']; ?>
		            </span>
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Children <em>:</em></label> ".$sq_hotel_info['childrens']; ?>
		            </span>
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Infants <em>:</em></label> ".$sq_hotel_info['infants']; ?>
		            </span>
		       </div>
					 
					 <div class="col-sm-12 col-xs-12">
								<span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Passenger <em>:</em></label> ".$sq_hotel_info['pass_name']; ?>
		            </span>
					 </div>
		        </div>
		        	
	    </div> 
	</div>
	<div class="col-md-6 col-sm-12 col-xs-12">
		 <div class="profile_box main_block" style="min-height: 141px;">
	        <h3>Costing Details</h3>
	        <div class="row">
	            <div class="col-sm-6 col-xs-12 right_border_none_sm_xs" style="border-right: 1px solid #ddd">
	                <span class="main_block">
	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	                  <?php echo "<label>Basic Amount <em>:</em></label> ".$sq_hotel_info['sub_total']; ?>
	                </span>
		        	<span class="main_block">
		        	  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		        	  <?php echo "<label>Service charge <em>:</em></label> ".$sq_hotel_info['service_charge']; ?>
		        	</span>
				    <span class="main_block">
	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	                  <?php echo "<label>".$tax_name." <em>:</em></label>". $sq_hotel_info['service_tax_subtotal']; ?>
	                </span>
		        	<span class="main_block">
		        	  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		        	  <?php echo "<label>Markup <em>:</em></label> ".$sq_hotel_info['markup']; ?>
		        	</span>
					<span class="main_block">
		        	  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		        	  <?php echo "<label>Markup Tax<em>:</em></label> ".$sq_hotel_info['markup_tax']; ?>
		        	</span>
				 </div>
				 <div class="col-sm-6 col-xs-12">
	        	    <span class="main_block">
	        	      <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	        	      <?php echo "<label>Discount <em>:</em></label> ".$sq_hotel_info['discount']; ?>
	        	    </span>
	        	    <span class="main_block">
	        	      <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	        	      <?php echo "<label>TDS <em>:</em></label> ".$sq_hotel_info['tds']; ?> 
	        	    </span>
	        		<span class="main_block">
	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	                  <div class="highlighted_cost"><?php echo "<label>Net Total <em>:</em></label> ";?> <?php echo $sq_hotel_info['total_fee']; ?> </div>
	                </span>
					
					<span class="main_block">
		        		  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		        		  <?php
							$sq_credit = mysql_fetch_assoc(mysql_query("SELECT sum(`credit_charges`) as sumc FROM `hotel_booking_payment` WHERE `booking_id`='$sq_hotel_info[booking_id]' and `clearance_status`!='Cancelled' and clearance_status != 'Pending'"));
							$charge = ($sq_credit['sumc'] != '')?$sq_credit['sumc']:0;
							echo "<label>Credit card charges <em>:</em></label> ".number_format($charge,2)?> 
		        		</span>
	        		<span class="main_block">
	        		  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	        		  <?php echo "<label>Due Date <em>:</em></label> ".get_date_user($sq_hotel_info['due_date']);?> 
	        		</span>
	        		<span class="main_block">
	        		  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	        		  <?php echo "<label>Booking Date <em>:</em></label> ".get_date_user($sq_hotel_info['created_at']);?> 
	        		</span>
	        	 </div>
	        	</div>
			</div>
    </div>
</div>
<div class="row">    
  	<div class="col-xs-12">
  		<div class="profile_box main_block" style="margin-top: 25px">
           	<h3 class="editor_title">Room Details</h3>
                <div class="table-responsive">
                    <table id="tbl_dynamic_visa_update" name="tbl_dynamic_visa_update" class="table table-bordered no-marg">
                       <thead>
	                       <tr class="table-heading-row">
	                       		<th>S_No.</th>
								<th>City</th>
								<th>Hotel</th>
								<th>Check_In</th>
								<th>Check_Out</th>
								<th>Nights</th>
								<th>Rooms</th>
								<th>Room_Type</th>
								<th>Category</th>
								<th>Accommodation</th>
								<th>Meal_plan</th>
								<th>Extra_Bed</th>
								<th>Conf_No</th>
	                       </tr>
                       </thead>
                       <tbody>
                       <?php 
                       $count = 0;
                       $sq_hotel_entry = mysql_query("select * from hotel_booking_entries where booking_id='$booking_id'");

                       while($row_entry = mysql_fetch_assoc($sq_hotel_entry)){

                       		$bg = ($row_entry['status']=="Cancel") ? "danger" : "";
		                       
		                       $sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row_entry[city_id]'"));

		                       $sq_hotel = mysql_fetch_assoc(mysql_query("select hotel_id, hotel_name from hotel_master where hotel_id='$row_entry[hotel_id]'"));

		                       $count++;
                       			?>
								 <tr class="<?= $bg ?>">
								    <td><?php echo $count; ?></td>
								    <td><?php echo $sq_city['city_name']; ?></td>
									<td><?php echo $sq_hotel['hotel_name']; ?></td>
								    <td><?php echo date('d/m/Y H:i:s', strtotime($row_entry['check_in'])); ?></td>
								    <td><?php echo date('d/m/Y H:i:s', strtotime($row_entry['check_out'])); ?></td>
								    <td><?php echo $row_entry['no_of_nights']; ?></td>
								    <td><?php echo $row_entry['rooms'];  ?> </td>
								    <td><?php echo $row_entry['room_type']; ?></td>
								    <td><?php echo $row_entry['category']; ?></td>
								    <td><?php echo $row_entry['accomodation_type']; ?></td>
									<td><?php echo $row_entry['meal_plan'];  ?></td>
								    <td><?php echo $row_entry['extra_beds'];  ?></td>
								    <td><?php echo $row_entry['conf_no'];  ?></td>
								</tr>  
                       			<?php

                       		}

                       
                       ?>
                     </tbody>
                    </table>
                </div>
                
        </div>  
    </div>
</div>  
           