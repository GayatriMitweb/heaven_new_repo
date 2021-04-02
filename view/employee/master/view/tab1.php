<div class="row">

	<div class="col-md-12">

        <h3 class="editor_title">User Information</h3>
		<div class="panel panel-default panel-body app_panel_style">
			<div class="profile_box main_block">

        	 	<?php 
					$count = 0;
					$sq_emp = mysql_fetch_assoc(mysql_query($query));
        	 	?>

        	 	<div class="row">

        	 	<div class="col-md-6 right_border_none_sm" style="border-right: 1px solid #ddd;">

	        		<span class="main_block">

		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

		                  <?php echo "<label>Name <em>:</em></label> ".$sq_emp['first_name'].' '.$sq_emp['last_name']; ?>

		            </span>

		            <span class="main_block">

		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

		                  <?php echo "<label>Mobile No <em>:</em></label> ".$sq_emp['mobile_no']; ?>

		            </span>

		            <span class="main_block">

		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

		                  <?php echo "<label>Alternative No <em>:</em></label> ".$sq_emp['mobile_no2']; ?>

		            </span>        

        	 		<span class="main_block">

		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

		                  <?php echo "<label>Email <em>:</em></label> ".$sq_emp['email_id']; ?>

		            </span>		            

		        </div>

        	 	<div class="col-md-6">		

		            <span class="main_block">

		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

		                  <?php echo "<label>DOB <em>:</em></label> ".date('d-m-Y', strtotime($sq_emp['dob'])); ?>

		            </span>

		            <span class="main_block">

		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

		                  <?php echo "<label>Age <em>:</em></label> ".$sq_emp['age']; ?>

		            </span>

		            <span class="main_block">

		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

		                  <?php echo "<label>Gender <em>:</em></label> ".$sq_emp['gender']; ?>

		            </span>

		            <span class="main_block">

		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

		                  <?php echo "<label>UAN <em>:</em></label> ".$sq_emp['uan_code']; ?>

		            </span>

		            

		            <?php

	                if($sq_emp['photo_upload_url']!=""){

	                	$newUrl1 = preg_replace('/(\/+)/','/',$sq_emp['photo_upload_url']); 



	                ?>	

	                <span class="main_block">

	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

	                  <?php echo "<label>Photo Proof <em>:</em></label> "?><a href="<?php echo $newUrl1; ?>" download title="View Photo"><i class="fa fa-id-card-o"></i></a> 

	                </span>

	                <?php }

	                ?>

		         
	              

		        </div>

		      </div>

		             

		    </div> 
		</div>

	</div>


	<div class="col-md-12 mg_tp_10">
		
	    <h3 class="editor_title">Official Information</h3>
		<div class="panel panel-default panel-body app_panel_style">
			<div class="profile_box main_block">


            <?php  

             $sq_location = mysql_fetch_assoc(mysql_query("select * from locations where location_id='$sq_emp[location_id]'"));

		   	 $sq_branch = mysql_fetch_assoc(mysql_query("select * from branches where branch_id='$sq_emp[branch_id]'"));

			 $sq_login = mysql_fetch_assoc(mysql_query("select * from roles where emp_id='$sq_emp[emp_id]'"));

            ?>

	        <div class="row">

	            <div class="col-md-6" style="border-right: 1px solid #ddd">

	                <span class="main_block">

	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

	                  <?php echo "<label>Location <em>:</em></label> ".$sq_location['location_name']; ?>

	                </span>

	                <span class="main_block">

	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

	                  <?php echo "<label>Branch <em>:</em></label> ".$sq_branch['branch_name']; ?>

	                </span>

	                <span class="main_block">

	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

	                  <?php
						$username = $encrypt_decrypt->fnDecrypt($sq_emp['username'], $secret_key);
						echo "<label>Username <em>:</em></label> ".$username; ?>

	                </span>

                	<span class="main_block">

	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

	                  <?php
						$password = $encrypt_decrypt->fnDecrypt($sq_emp['password'], $secret_key);
						echo "<label>Password <em>:</em></label> ".$password; ?>

	                </span>	
	        	</div>

	        	<div class="col-md-6">

					<span class="main_block">

					<?php 

						$query_role = mysql_fetch_assoc(mysql_query("select * from role_master where role_id = '$sq_emp[role_id]'")); 

					?>

					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

					<?php echo "<label>Role <em>:</em></label> ". $query_role['role_name']; ?>

					</span>	

	                <span class="main_block">

	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

	                  <?php echo "<label>Joining Date <em>:</em></label> ".date('d-m-Y', strtotime($sq_emp['date_of_join'])); ?>

	                </span>	        

	                <span class="main_block">

	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

	                  <?php echo "<label>Monthly Target To Sale <em>:</em></label> ".$sq_emp['target']; ?>

	                </span>	
	                <span class="main_block">

	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

	                  <?php echo "<label>Incentive(%) <em>:</em></label> ".$sq_emp['incentive_per']; ?>

	                </span>

	                  <?php

	                if($sq_emp['id_proof_url']!=""){

	                	$newUrl = preg_replace('/(\/+)/','/',$sq_emp['id_proof_url']); 



	                ?>	

	                <span class="main_block">

	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

	                  <?php echo "<label>ID Proof <em>:</em></label> "?><a href="<?php echo $newUrl; ?>" download title="View ID"><i class="fa fa-id-card-o"></i></a> 

	                </span>

	                <?php }

	                ?>

	        	</div>

	        	</div>
						
					<div class="row">
					<div class="col-md-12">
						<span class="main_block">
							<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
							<?php echo "<label>Address <em>:</em></label> ".$sq_emp['address']; ?>
						</span>
					</div>
					</div>

			</div>
		</div>	 
	</div>


	<div class="col-md-12 mg_tp_10">
		
		<h3 class="editor_title">Mailing Information</h3>
		<div class="panel panel-default panel-body app_panel_style">
			<div class="profile_box main_block">
			<div class="row">

				<div class="col-md-6" style="border-right: 1px solid #ddd">

					<span class="main_block">

					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

					<?php echo "<label>SMTP Status <em>:</em></label> ".$sq_emp['app_smtp_status']; ?>

					</span>

					<span class="main_block">

					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

					<?php echo "<label>SMTP Host <em>:</em></label> ".$sq_emp['app_smtp_host']; ?>

					</span>

					<span class="main_block">

					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

					<?php echo "<label>SMTP Port <em>:</em></label> ".$sq_emp['app_smtp_port']; ?>

					</span>
				</div>

				<div class="col-md-6">

					<span class="main_block">

					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

					<?php echo "<label>SMTP Password <em>:</em></label> ".$sq_emp['app_smtp_password']; ?>

					</span>

					<span class="main_block">

					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

					<?php echo "<label>SMTP Method <em>:</em></label> ".$sq_emp['app_smtp_method']; ?>

					</span>	

				</div>

				</div>

			</div>
		</div>	 
	</div>

	<div class="col-md-12 mg_tp_10">

	     <h3 class="editor_title">Visa Information</h3>
		 <div class="panel panel-default panel-body app_panel_style">
		 	<div class="profile_box main_block">

 
	        <div class="row">

	            <div class="col-md-6" style="border-right: 1px solid #ddd">

	                <span class="main_block">

	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

	                  <?php echo "<label>Country Name <em>:</em></label> ".$sq_emp['visa_country_name']; ?>

	                </span>

	                <span class="main_block">

	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

	                  <?php echo "<label>Type <em>:</em></label> ".$sq_emp['visa_type']; ?>

	                </span>

	                <span class="main_block">

	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

	                  <?php echo "<label>Issue Date <em>:</em></label> ". get_date_user($sq_emp['issue_date']);?>

	                </span>
	                
	        	</div>

	        	<div class="col-md-6">
	        		<span class="main_block">

	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

	                  <?php echo "<label>Expire Date <em>:</em></label> ".get_date_user($sq_emp['expiry_date']); ?>

	                </span>	

	                <span class="main_block">

	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

	                  <?php echo "<label>Visa Amount<em>:</em></label> ".$sq_emp['visa_amt']; ?>

	                </span>	

	                <span class="main_block">

	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

	                  <?php echo "<label>Renewal Amount<em>:</em></label> ".$sq_emp['renewal_amount']; ?>

	                </span>		                

	        	</div>

	        	</div>

			</div>
		 </div>

    </div>

</div>
