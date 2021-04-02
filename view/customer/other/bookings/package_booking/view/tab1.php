<div class="row">
	<div class="col-md-4 col-sm-12 col-xs-12 mg_bt_20_xs">
		<div class="profile_box main_block" style="min-height: 217px;">
			<h3>Tour Details</h3>
			<div class="row">
				<div class="col-xs-12 right_border_none_sm" style="border-right: 1px solid #ddd">
					<span class="main_block"> 
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Booking ID <em>:</em></label>" .get_package_booking_id($booking_id,$year) ?>
					</span>
					<span class="main_block"> 
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Tour Name <em>:</em></label>" .$sq_package_info['tour_name']; ?>
					</span>
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Tour Type <em>:</em></label>" .$sq_package_info['tour_type']; ?>
					</span>
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Tour Days <em>:</em></label>" .$sq_package_info['total_tour_days']; ?>
					</span>
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>From Date <em>:</em></label>" .date('d-m-Y',strtotime($sq_package_info['tour_from_date'])) ?> 
					</span>
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>To Date <em>:</em></label>" .date('d-m-Y',strtotime($sq_package_info['tour_to_date'])) ?> 
					</span>
				</div>
			</div>
		</div>
	</div>
	<?php
	$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_package_info[customer_id]'"));				
	$contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
	$email_id = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key);
	$cust_name = ($sq_customer['type'] == 'Corporate')?$sq_customer['company_name']:$sq_customer['first_name'].' '.$sq_customer['middle_name'].' '.$sq_customer['last_name']; 
	?>
	<div class="col-md-8 col-sm-12 col-xs-12">
		<div class="profile_box main_block" style="min-height: 217px;">

			<h3>Customer Details</h3>


			<div class="row">

				<div class="col-sm-6 col-xs-12 right_border_none_sm_xs" style="border-right: 1px solid #ddd">

					<span class="main_block"> 

							<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

						<?php echo  "<label>Customer Name <em>:</em></label> " .$cust_name.'&nbsp'; ?>

					</span>

					<span class="main_block">

						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

						<?php echo "<label>Email <em>:</em></label> " .$email_id; ?>

					</span>	

					<span class="main_block">

						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

						<?php echo "<label>Mobile No <em>:</em></label>" .$contact_no; ?> 

					</span>

				</div>

				<div class="col-sm-6 col-xs-12">
									<?php if($sq_customer['type'] == 'Corporate'){ ?>
					<span class="main_block">

						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

						<?php echo "<label>Contact Person <em>:</em></label> ".$sq_package_info['contact_person_name']; ?>

					</span>
									<?php } ?>

							<span class="main_block">

									<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

								<?php echo "<label>City <em>:</em></label> ".$sq_package_info['city']; ?>

							</span>

					<span class="main_block">

						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

						<?php echo "<label>Country <em>:</em></label> ".$sq_package_info['country_name']; ?>

					</span>

					<span class="main_block">

						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

							<?php echo "<label>State <em>:</em></label> ".$sq_package_info['state']; ?> 

					</span>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-8 col-sm-12 col-xs-12">
		<div class="profile_box main_block">
			<h3>Booking Details</h3>
			<div class="row">
				<div class="col-xs-12">
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Due Date <em>:</em></label> ";
						echo ($sq_package_info['due_date']=='1970-01-01')?get_date_user($sq_package_info['booking_date']):get_date_user($sq_package_info['due_date']);?> 
					</span>
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Booking Date <em>:</em></label> ".get_datetime_user($sq_package_info['booking_date']) ;?> 
					</span>
				</div>
			</div>
			<div class="row">	
				<div class="col-md-12">
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Special Request <em>:</em></label> ".$sq_package_info['special_request'];?> 
					</span>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">    
	<div class="col-xs-12">
		<div class="profile_box main_block">
			<h3 class="editor_title">Passenger Details</h3>
				<div class="table-responsive">
					<table  class="table table-bordered no-marg">
						<thead>
							<tr class="table-heading-row">
								<th>S_No.</th>
								<th>Honorific</th>
								<th>Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
								<th>Gender</th>
								<th>Date_of_birth</th>
								<th>Age(Y:M:D)</th>
								<th>Adole</th>
								<th>Passport_No.</th>
								<th>Issue_Date</th>
								<th>Expire_Date</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$count = 0;
							$bg="";
							$sq_entry = mysql_query("select * from package_travelers_details where booking_id='$booking_id'");
							while($row_entry = mysql_fetch_assoc($sq_entry)){

								if($row_entry['status']=="Cancel")
									$bg="danger";
								else
									$bg="#fff";
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
									<?php }
									if($row_entry['passport_issue_date']=='1970-01-01'){ ?>
									<td><?php echo "N/A"; ?> </td>
									<?php } else { ?>
									<td><?php echo get_date_user($row_entry['passport_issue_date']); ?></td>
									<?php }
									if($row_entry['passport_expiry_date']=='1970-01-01'){ ?>
									<td><?php echo "N/A"; ?> </td>
									<?php } else { ?>
									<td><?php echo get_date_user($row_entry['passport_expiry_date']); ?></td>
									<?php }  ?>
								</tr>  
								<script>
									$("#birth_date<?= $offset.$count ?>_d, #expiry_date<?= $offset ?>1").datetimepicker({ timepicker:false, format:'d-m-Y' });
								</script>
								<?php } ?>
						</tbody>
				</table>
			</div>
		</div>
	</div>
</div>