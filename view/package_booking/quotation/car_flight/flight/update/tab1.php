<form id="frm_tab11">

	<div class="row">

		<input type="hidden" id="quotation_id1" name="quotation_id1" value="<?= $quotation_id ?>">

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

			<input type="hidden" id="login_id" name="login_id" value="<?= $login_id ?>">

			<select name="enquiry_id1" id="enquiry_id1" style="width:100%" onchange="get_flight_enquiry_details('1')">

				<?php 

				$sq_enq = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id='$sq_quotation[enquiry_id]' and enquiry_type='Flight Ticket'"));

					?>

					<option value="<?= $sq_enq['enquiry_id'] ?>">Enq<?= $sq_enq['enquiry_id'] ?> : <?= $sq_enq['name'] ?></option>

					<?php

					if($role=='Admin'){
				    $sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Flight Ticket') and status!='Disabled' order by enquiry_id desc");
					}	
					if($branch_status=='yes'){
						if($role=='Branch Admin'){
							$sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Flight Ticket') and status!='Disabled' and branch_admin_id='$branch_admin_id' order by enquiry_id desc");
						}
						elseif($role!='Admin' && $role!='Branch Admin'){

							$sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Flight Ticket') and assigned_emp_id='$emp_id' and status!='Disabled' order by enquiry_id desc");
						}
						else{
							 $sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Flight Ticket') and status!='Disabled' and branch_admin_id='$branch_admin_id' order by enquiry_id desc");
						}
					}
					else{
						if($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
							$q = "select * from enquiry_master where enquiry_type in('Flight Ticket') and assigned_emp_id='$emp_id' and status!='Disabled' order by enquiry_id desc";
							$sq_enq = mysql_query($q);
						}
						else{
							 $sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Flight Ticket') and status!='Disabled' order by enquiry_id desc");
						}
					}

				while($row_enq = mysql_fetch_assoc($sq_enq)){

					?>

					<option value="<?= $row_enq['enquiry_id'] ?>">Enq<?= $row_enq['enquiry_id'] ?> : <?= $row_enq['name'] ?></option>

				<?php

				}

				?>

			</select>

		</div>	

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	      <input type="text" class="form-control" id="customer_name1" name="customer_name1" onchange="validate_customer(this.id);"  placeholder="Customer Name" title="Customer Name" value="<?= $sq_quotation['customer_name'] ?>"> 

	    </div>	        		                			        		        	        		


		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

			<input type="text" id="email_id1" name="email_id1" placeholder="Email ID" title="Email ID" value="<?= $sq_quotation['email_id'] ?>">

		</div>	

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

			<input type="text" id="mobile_no1" name="mobile_no1" placeholder="Mobile No" onchange="mobile_validate(this.id);" title="Mobile No" value="<?= $sq_quotation['mobile_no'] ?>">

		</div>
<!-- 
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	      <input type="text" id="travel_datetime1" name="travel_datetime1" placeholder="Travel Date/Time" title="Travel Date/Time" value="<?= get_datetime_user($sq_quotation['traveling_date']) ?>">

	    </div>

	    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	      <input type="text" id="sector_from1" name="sector_from1" title="Sector From" placeholder="Sector From" onchange="validate_city(this.id);" value="<?= $sq_quotation['sector_from'] ?>">

	    </div>

	    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	      <input type="text" id="sector_to1" name="sector_to1" title="Sector To" placeholder="Sector To" onchange="validate_city(this.id);" value="<?= $sq_quotation['sector_to'] ?>">

	    </div>	        		            

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

			<input type="text" id="preffered_airline1" name="preffered_airline1" placeholder="Preferred Airline" onchange="validate_city(this.id);" title="Preferred Airline" value="<?= $sq_quotation['preffered_airline'] ?>">

		</div>	

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	      <input type="text" name="class_type1" id="class_type1" title="Class Type" placeholder="Class Type" onchange="validate_city(this.id);" value="<?= $sq_quotation['class_type'] ?>">

	    </div>

	    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	    	<input type="text" name="trip_type1" id="trip_type1" placeholder="Trip Type" title="Trip Type" onchange="validate_city(this.id);" value="<?= $sq_quotation['trip_type'] ?>">

	    </div>

	    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	      <input type="text" id="total_seats1" name="total_seats1" placeholder="Total Seats" title="Total Seats" onchange="validate_balance(this.id);" value="<?= $sq_quotation['total_seats'] ?>" >

	    </div>	        		           
  -->

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	      <input type="text" class="form-control" id="quotation_date1" name="quotation_date1" placeholder="Quotation Date" title="Quotation Date" value="<?= get_date_user($sq_quotation['quotation_date']) ?>" onchange="get_auto_values('quotation_date1','subtotal1','payment_mode','service_charge1','markup_cost1','update','true','service_charge', true);"> 

	    </div>
	</div>	

	<div class="row text-center mg_tp_20">

		<div class="col-xs-12">

			<button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>

		</div>

	</div>

</form>



<script>
$('#travel_datetime1').datetimepicker({format:'d-m-Y H:i' });

 

$('#frm_tab11').validate({

	rules:{

			 

	},

	submitHandler:function(form){

		var customer_name = $('#customer_name1').val();
		if(customer_name == ''){
			error_msg_alert("Please Enter Customer Name");
			return false;
		}

		$('a[href="#tab_2"]').tab('show');



	}

});

</script>

