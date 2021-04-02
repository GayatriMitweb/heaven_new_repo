<div class="row">
	<div class="col-md-12">
		<div class="profile_box main_block">
		<h3>Basic Details</h3>
        	 	<div class="row">
        	 	<div class="col-md-6 right_border_none_sm" style="border-right: 1px solid #ddd; min-height: 105px;">
        	   		<span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Company Name <em>:</em></label> ".$query['company_name']; ?>
		            </span>
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Accounting Name <em>:</em></label> ".$query['accounting_name'] ?>
		            </span>
        	 		<span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>IATA Status <em>:</em></label> ".$query['iata_status'] ?>
		            </span>
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>IATA Regstration No. <em>:</em></label> ".$query['iata_reg_no']; ?>
		            </span>
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Nature Of Business <em>:</em></label> ".$query['nature_of_business']; ?>
		            </span> 
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						  <?php
						  $sq_currency = mysql_fetch_assoc(mysql_query("select currency_code from currency_name_master where id='$query[currency]'")); ?>
		                  <?php echo "<label>Preferred Currency <em>:</em></label>".$sq_currency['currency_code'] ?>
		            </span>
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Telephone <em>:</em></label>".$query['telephone'] ?>
		            </span>
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Latitude <em>:</em></label> ".$query['latitude']; ?>
		            </span>       
		        </div>
        	 	<div class="col-md-6">	
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Turnover Slabs <em>:</em></label> ".$query['turnover']; ?>
		            </span>	  
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Skype ID <em>:</em></label> ".$query['skype_id']; ?>
		            </span>
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Website <em>:</em></label> ".$query['website']; ?>
		            </span>
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Credit Limit <em>:</em></label> ".$query['credit_limit']; ?>
		            </span>
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Deposit <em>:</em></label> ".$query['deposite']; ?>
		            </span>
					<?php
					if($query['company_logo']!=''){
						$newUrl = preg_replace('/(\/+)/','/',$query['company_logo']);
						$newUrl = explode('uploads', $newUrl);
						$newUrl1 = BASE_URL.'uploads'.$newUrl[1];
					?>
					<span class="main_block">
					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
					<?php echo "<label>Company Logo <em>:</em></label> "?><a href="<?php echo $newUrl1; ?>" download title="Download"><i class="fa fa-id-card-o"></i></a> 
					</span>
					<?php } ?>
					<?php
					if($query['agreement_url']!=''){
						$newUrl = preg_replace('/(\/+)/','/',$query['agreement_url']);
						$newUrl = explode('uploads', $newUrl);
						$newUrl1 = BASE_URL.'uploads'.$newUrl[1];
					?>
					<span class="main_block">
					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
					<?php echo "<label>Agreement <em>:</em></label> "?><a href="<?php echo $newUrl1; ?>" download title="Download"><i class="fa fa-id-card-o"></i></a> 
					</span>
					<?php } ?>
	                <span class="main_block">
	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	                  <?php echo "<label>Status <em>:</em></label> ".$query['active_flag']; ?>
	                </span>
		        </div>
		        </div>   
		    </div> 
	</div>
</div>
<div class="row mg_tp_10">
	<div class="col-md-6">
		<div class="profile_box main_block">
		<h3>Address Details</h3>
        	 	<div class="row">
        	 	<div class="col-md-12 right_border_none_sm" style="border-right: 1px solid #ddd; min-height: 105px;">
        	   		<span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Address-1 <em>:</em></label> ".$query['address1']; ?>
		            </span>
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Address-2 <em>:</em></label> ".$query['address2'] ?>
		            </span>
        	 		<span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						  <?php
						  $sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$query[city]'")); ?>
		                  <?php echo "<label>City <em>:</em></label> ".$sq_city['city_name'] ?>
		            </span>
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Pincode <em>:</em></label> ".$query['pincode']; ?>
		            </span>
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						  <?php 
						  $sq_country = mysql_fetch_assoc(mysql_query("select * from country_list_master where country_id='$query[country]'"));
						  $country_name = ($query['country']!='0') ? $sq_country['country_name'].'('.$sq_country['country_code'].')':'';
						  ?>
						  <?php echo "<label>Country <em>:</em></label> ".$country_name; ?>
		            </span> 
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						  <?php 
						  $sq_country = mysql_fetch_assoc(mysql_query("select * from state_master where id='$query[state]'"));
						  $country_name = ($query['state']!='0') ? $sq_country['state_name']:'';
						  ?>
						  <?php echo "<label>State <em>:</em></label> ".$country_name; ?>
		            </span> 
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Timezone <em>:</em></label>".$query['timezone'] ?>
		            </span>
					<?php
					if($query['address_proof_url']!=''){
						$newUrl = preg_replace('/(\/+)/','/',$query['address_proof_url']);
						$newUrl = explode('uploads', $newUrl);
						$newUrl1 = BASE_URL.'uploads'.$newUrl[1];
					?>
					<span class="main_block">
					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
					<?php echo "<label>Address Proof <em>:</em></label> "?><a href="<?php echo $newUrl1; ?>" download title="Download"><i class="fa fa-id-card-o"></i></a> 
					</span>
					<?php } ?>       
		        </div>
		        </div>   
		    </div> 
	</div>
	<div class="col-md-6">
		<div class="profile_box main_block">
		<h3>Access Details</h3>
        	 	<div class="row">
        	 	<div class="col-md-12 right_border_none_sm" style="min-height: 105px;">
        	   		<span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php echo "<label>Agent Code <em>:</em></label> ".$query['agent_code']; ?>
		            </span>
		            <span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		                  <?php
						  $username = $encrypt_decrypt->fnDecrypt($query['username'], $secret_key);
						  echo "<label>Username <em>:</em></label> ".$username ?>
		            </span>
        	 		<span class="main_block">
		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						  <?php
						  $password = $encrypt_decrypt->fnDecrypt($query['password'], $secret_key);
						  echo "<label>Password <em>:</em></label> ".$password;
						  ?>
		            </span>       
		        </div>
		        </div>   
		    </div> 
	</div>
</div>