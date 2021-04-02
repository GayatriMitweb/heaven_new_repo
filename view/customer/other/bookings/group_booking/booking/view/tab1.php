<div class="row">

	<div class="col-sm-6 right_border_none_sm mg_bt_20" style="border-right: 1px solid #ddd">

		<div class="profile_box main_block" style="min-height: 166px;">

    	 	<h3>Tour Details</h3>

    	 	<?php $tour_id = $sq_group_info['tour_id'];

    	 	$sql = $query = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id='$tour_id'"));?>

    	 	<span class="main_block"> 

			    <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

			    <?php echo "<label>Booking ID <em>:</em></label> " .get_group_booking_id($id,$year) ?>

			</span>

			<span class="main_block"> 

			    <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

			    <?php echo "<label>Tour Name <em>:</em></label> " .$sql['tour_name']; ?>

			</span>

			<?php 				

			$tour_group_id = $sq_group_info['tour_group_id'];	
			$sq_group = mysql_fetch_assoc(mysql_query("select * from tour_groups where group_id='$tour_group_id'"));

				$tour_group = get_date_user($sq_group['from_date']).' To '.get_date_user($sq_group['to_date']);

			?>

			<span class="main_block">

			    <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

			    <?php echo "<label>Tour Date <em>:</em></label> " .$tour_group; ?>

			</span>	

			<span class="main_block"> 

			    <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

			    <?php echo "<label>Tour Type <em>:</em></label> " .$sql['tour_type']; ?>

			</span>

	    </div> 

	</div>

	<div class="col-sm-6 mg_bt_20">

		<div class="profile_box main_block" style="min-height: 156px;">

    	 	<h3>Customer Details</h3>

    		<?php

    		 $sq_tour_deatils = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$id'"));

    		 $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_tour_deatils[customer_id]'")); 

    		?>

			<span class="main_block"> 

			    <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

			    <?php echo  "<label>Customer Name <em>:</em></label> " .$sq_customer['first_name'].' '.$sq_customer['middle_name'].' '.$sq_customer['last_name'].'&nbsp'; ?>

			</span>

			<?php  

		        	  if($sq_customer['type'] == 'Corporate'){

		        	?>

        	 		<span class="main_block">

		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

		                  <?php echo "<label>Company <em>:</em></label> ".$sq_customer['company_name'] ?>

		            </span>

		            <?php  } ?>

			<?php  

				$sq_traveler_personal_info = mysql_fetch_assoc(mysql_query("select * from traveler_personal_info where tourwise_traveler_id='$id'"));

			?>

			<span class="main_block">

			    <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

			    <?php echo "<label>Email <em>:</em></label> " .$sq_traveler_personal_info['email_id']; ?>

			</span>	

			<span class="main_block">

			    <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

			    <?php echo "<label>Mobile No<em>:</em></label>" .$sq_traveler_personal_info['mobile_no']; ?> 

			</span>

        	<span class="main_block">

        	  	<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

        	 	<?php echo "<label>Address <em>:</em></label> ".$sq_traveler_personal_info['address']; ?>

        	</span>

       	</div>

    </div>

</div>



<div class="row">

	<div class="col-sm-6 right_border_none_sm mg_bt_20_xs" style="border-right: 1px solid #ddd">

		<div class="profile_box main_block" style="min-height: 161px;">

			<h3>Emergency Contact</h3>

		    <span class="main_block">

		      	<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

		      	<label>Name <em>:</em></label>

		      	<?php if($sq_tour_deatils['relative_name']!=""){

		     echo $sq_tour_deatils['relative_honorofic'].' '.$sq_tour_deatils['relative_name']; }?>

		    </span>

		    <span class="main_block">

		      	<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

		      <?php echo "<label>Relation <em>:</em></label> ".$sq_tour_deatils['relative_relation']; ?> 

		    </span>

			<span class="main_block">

			  	<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

			  <?php echo "<label>Mobile No <em>:</em></label> ".$sq_tour_deatils['relative_mobile_no'];?> 

			</span>

		</div>

	</div>

	<?php 



		$sq_total_mem = mysql_num_rows(mysql_query("select traveler_id from travelers_details where traveler_group_id='$sq_group_info[traveler_group_id]'"));



	?>

	<div class="col-sm-6 mg_bt_20_xs">

		<div class="profile_box main_block" style="min-height: 161px;">

			<h3>Accommodation Details </h3>

			<span class="main_block">

		  		<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

		  		<?php echo "<label>Total guest <em>:</em></label> ".$sq_total_mem;?> 

			</span>

			<span class="main_block">

					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

					<?php echo "<label>Single Bed Room <em>:</em></label> ".$sq_tour_deatils['s_single_bed_room'];?> 

			</span>

			<span class="main_block">

		  		<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

		  		<?php echo "<label>Double Bed Room <em>:</em></label> ".$sq_tour_deatils['s_double_bed_room'];?> 

			</span>

			<span class="main_block">

		  		<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

		  		<?php echo "<label>Extra Bed <em>:</em></label> ".$sq_tour_deatils['s_extra_bed'];?> 

			</span>

			<span class="main_block">

		  		<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

		  		<?php echo "<label>On Floor <em>:</em></label> ".$sq_tour_deatils['s_on_floor'];?> 

			</span>

		</div>

	</div>

</div>

<div class="row" >
	<div class="profile_box main_block" style="min-height: 161px;">
		<h3>Booking Details </h3>
		<div class="row">
			<div class="profile_box main_block" style="min-height: 17px;">
				<div class="col-md-6">
						<span class="main_block">

							<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

							<?php echo "<label>Due Date<em>:</em></label> ".get_date_user($sq_tour_deatils['balance_due_date']) ;?> 

						</span>
				</div>
				<div class="col-md-6">
						<span class="main_block">

							<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

							<?php echo "<label>Booking Date<em>:</em></label> ".get_datetime_user($sq_tour_deatils['form_date']) ;?> 

						</span>

				</div>
			</div>	
			</div>


			<div class="row">

				<div class="col-md-12">

					<div class="profile_box main_block" style="min-height: 17px;">

						<span class="main_block">

							<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

							<?php echo "<label>Special Request <em>:</em></label> ".$sq_tour_deatils['special_request'];?> 

						</span>
					</div>
				</div>

			</div>
	</div>
</div>


		



<div class="row">    

  	<div class="col-md-12">

  		<div class="profile_box main_block" style="margin-top: 25px">

           	<h3 class="editor_title">Passenger Details</h3>

                <div class="table-responsive">

                    <table class="table table-bordered no-marg">

	                    <thead>

	                        <tr class="table-heading-row">

		                       	<th>S_No.</th>
		                       	<th>Honorific</th>
		                       	<th>Name</th>

		                       	<th>Gender</th>

		                       	<th>DOB</th>

		                       	<th>Age</th>

		                       	<th>Adole</th>

		                       	<th>Passport_No.</th>

		                       	<th>Issue_Date</th>

		                       	<th>Expire_Date</th>

	                        </tr>

	                    </thead>

                        <tbody>

                       <?php 

                       		$count = 0;

                       		$traveler_group_id = $sq_tour_deatils['traveler_group_id'];

                       		$sq_entry = mysql_query("select * from travelers_details where traveler_group_id='$traveler_group_id'");

                           

                       		while($row_entry = mysql_fetch_assoc($sq_entry)){

                       			 $bg="";

                       			$sq_entry1 = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where traveler_group_id='$row_entry[traveler_group_id]'"));

                       			if($row_entry['status']=="Cancel" || $sq_entry1['tour_group_status']=='Cancel' ) 	{

                       				$bg="danger";

                       			}

                       			else  {

                       				$bg="#fff";

                       			}

                       			$count++;

                       			?>

							<tr class="<?php echo $bg; ?>">

							    <td><?php echo $count; ?></td>
							    <td><?php echo $row_entry['m_honorific'] ?></td>

							    <td><?php echo $row_entry['first_name']." ".$row_entry['last_name']; ?></td>

								<td><?php echo $row_entry['gender']; ?></td>

							    <td><?php echo get_date_user($row_entry['birth_date']); ?></td>

							    <td><?php echo $row_entry['age']; ?></td>

							    <td><?php echo $row_entry['adolescence']; ?> </td>

							    <?php 

							    if($row_entry['passport_no']==''){ ?>

							    <td><?php echo "N/A"; ?> </td>

							    <?php } else { ?>

							    <td><?php echo $row_entry['passport_no']; ?> </td>

							    <?php } ?>

							    <?php 

							    if($row_entry['passport_issue_date']=='0000-00-00'){ ?>

							    <td><?php echo "N/A"; ?> </td>

							    <?php } else { ?>

							    <td><?php echo get_date_user($row_entry['passport_issue_date']); ?></td>

							    <?php }  ?>

							    <?php

							    if($row_entry['passport_expiry_date']=='0000-00-00'){ ?>

							    <td><?php echo "N/A"; ?> </td>

							    <?php } else { ?>

							    <td><?php echo get_date_user($row_entry['passport_expiry_date']); ?></td>

							    <?php }  ?>

							</tr>  

								<script>

									$("#birth_date<?= $offset.$count ?>_d, #expiry_date<?= $offset ?>1").datetimepicker({ timepicker:false, format:'d-m-Y' });

								</script>      

                       			<?php



                       		}



                       ?>

                     </tbody>

                </table>

            </div>

        </div>  

    </div>

</div>  



 

           