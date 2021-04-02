<?php
$financial_year_id = $_SESSION['financial_year_id'];
$role_id = $_SESSION['role_id'];
?>
<form id="frm_tab1">
    <input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
    <input type="hidden" id="financial_year_id" name="financial_year_id" value="<?= $financial_year_id ?>" >

	<div class="row">

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

		    <input type="hidden" id="emp_id" name="emp_id" value="<?= $emp_id ?>">
			<input type="hidden" id="login_id" name="login_id" value="<?= $login_id ?>">
			<input type="hidden" class="form-control" id="quotation_date" name="quotation_date" placeholder="Quotation Date" title="Quotation Date" value="<?= date('d-m-Y')?>"> 
			<select name="enquiry_id" id="enquiry_id" title="Enquiry No " style="width:100%" onchange="get_enquiry_details()">

				<option value="">*Enquiry No</option>
				<option value="0"><?= "New Enquiry" ?></option>

				<?php
			   if($role=='Admin'){
				    $sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Group Booking') and status!='Disabled' order by enquiry_id desc");
				 }
				 if($branch_status=='yes'){
					if($role=='Branch Admin'){
						$sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Group Booking') and status!='Disabled' and branch_admin_id='$branch_admin_id' order by enquiry_id desc");
					}
					elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){

						$sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Group Booking') and assigned_emp_id='$emp_id' and status!='Disabled' order by enquiry_id desc");
					}
					else{
						 $sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Group Booking') and status!='Disabled' and branch_admin_id='$branch_admin_id' order by enquiry_id desc");
					}
				}
				else{
					if($role=='B2b'){
						$sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Group Booking') and status!='Disabled' and assigned_emp_id='$emp_id' order by enquiry_id desc");
					}
					else{
						if($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
							$q = "select * from enquiry_master where enquiry_type in('Group Booking') and assigned_emp_id='$emp_id' and status!='Disabled' order by enquiry_id desc";
							$sq_enq = mysql_query($q);
						}
						else{
					 		$sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Group Booking') and status!='Disabled' order by enquiry_id desc");
						}
					}
				}
				while($row_enq = mysql_fetch_assoc($sq_enq)){

					?>

					<option value="<?= $row_enq['enquiry_id'] ?>">Enq<?= $row_enq['enquiry_id'] ?> : <?= $row_enq['name'] ?></option>

					<?php } ?>
			</select>

		</div>	

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	      <input type="text" id="tour_name" name="tour_name" onchange="validate_spaces(this.id);" placeholder="Tour Name" title="Tour Name">

	    </div>

	    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	     <input type="text" id="from_date" name="from_date" placeholder="From Date" value="<?php echo $sq_enq['travel_from_date'];?>" title="From Date" onchange="get_to_date(this.id,'to_date');total_days_reflect();">

	    </div>

	    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	      <input type="text" id="to_date" name="to_date" placeholder="To Date" title="To Date" onchange="total_days_reflect();change_dates_ever(this.id);" value="<?= $sq_enq['travel_to_date'] ?>">

	    </div>	        		            

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

			<input type="text" id="total_days" name="total_days" placeholder="Total Days" title="Total Days" readonly>

		</div>	

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	      <input type="text" id="customer_name" name="customer_name" onchange="validate_customer(this.id)" placeholder="Customer Name" title="Customer Name">

	    </div>

	    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	    	<input type="text" id="total_adult" name="total_adult" value="0" placeholder="Total Adult" title="Total Adult" onchange="total_passangers_calculate(); validate_balance(this.id)">

	    </div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

		<input type="text" class="form-control" id="children_with_bed" name="children_with_bed" onchange="validate_balance(this.id);total_passangers_calculate();cost_reflect();" placeholder="Child With Bed" title="Child With Bed"> 

		</div>

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
		<input type="text" class="form-control" id="children_without_bed" name="children_without_bed" onchange="validate_balance(this.id);total_passangers_calculate();" placeholder="Child Without Bed" title="Child Without Bed"> 
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

			<input type="text" id="total_infant" name="total_infant" value="0" placeholder="Total Infant" title="Total Infant" onchange="total_passangers_calculate(); validate_balance(this.id)">

		</div>	

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	      <input type="text" id="total_passangers" name="total_passangers" value="0" placeholder="Total Members" title="Total Members" readonly>

	    </div>

		

	    	        		                			        		        	        		


		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

			<input type="text" id="email_id" name="email_id" placeholder="Email ID" title="Email ID">

		</div>	
		<div class="col-sm-1 col-sm-6 col-xs-12 hidden" id="cc">
                <select name="country_code" id="country_code" style="display:none" >
                  <?= get_country_code() ?>
                </select>
              </div>

		<div class="col-md-2 col-sm-6 col-xs-12 mg_bt_10 hidden" id="mb">

	      <input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Mobile Number" title="Mobile Number"  style="display:none"> 

	    </div>

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	      <input type="text" class="form-control" id="quotation_date" name="quotation_date" placeholder="Quotation Date" title="Quotation Date" value="<?= date('d-m-Y')?>"> 

	    </div>

	    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	     	<select name="booking_type" id="booking_type" title="Booking Type">

	        	<option value="Domestic">Domestic</option>

	        	<option value="International">International</option>

	     	</select>

	    </div>

	</div>	



	<br><br>

	

	<div class="row text-center">

		<div class="col-xs-12">

			<button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>

		</div>

	</div>

</form>



<script>

function mobile_number (){
	if($('#enquiry_id').val() == '0'){
		$('#enquiry_id').css('display','block');
		$('#country_code').select2();
		$('#mobile_no').css('display','block');
		
	}
	else {
		$('#enquiry_id').css('display','none');
		$('#country_code').select2('destroy');
		$('#mobile_no').css('display','none');
	}
		
}
$('#frm_tab1').validate({

	rules:{

			enquiry_id : { required : true },

	},

	submitHandler:function(form){

		$('a[href="#tab2"]').tab('show');

	}

});


</script>

